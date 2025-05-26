<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\BillingInformation;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Session as LaravelSession;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($booking)
    {
        $booking = Booking::with(['provider', 'service', 'timeSlot'])
            ->findOrFail($booking);

        if ($booking->status === 'paid') {
            return redirect()->route('payment.success', ['booking' => $booking->id]);
        }

        return view('payment.payment', array_merge([
            'booking' => $booking
        ], $this->extractBookingDetails($booking)));
    }
    private function extractBookingDetails(Booking $booking): array
    {
        $rawOfferings = $booking->service->service_offerings;
        $firstDecode  = json_decode($rawOfferings, true);
        $offerings    = is_string($firstDecode)
            ? (json_decode($firstDecode, true) ?? [])
            : ($firstDecode ?? []);

        $offeringLookup = [];
        foreach ($offerings as $off) {
            $offeringLookup[$off['service_id']] = [
                'name'  => $off['service_name'],
                'price' => (float)$off['price'],
            ];
        }

        $chosenId            = $booking->service_offering_id;
        $chosenOffering      = $offeringLookup[$chosenId] ?? ['name' => 'Unknown Service', 'price' => 0];
        $serviceOfferingName = $chosenOffering['name'];
        $servicePrice        = $chosenOffering['price'];

        $rawAdds = $booking->service->additional_services;
        $adds    = json_decode($rawAdds, true) ?? [];

        $additionalServicePrices = [];
        foreach ($adds as $add) {
            $additionalServicePrices[$add['name']] = (float)$add['price'];
        }

        $selectedAdds = json_decode($booking->additional_services, true) ?? [];

        return [
            'serviceOfferingName'     => $serviceOfferingName,
            'servicePrice'            => $servicePrice,
            'selectedAdds'            => $selectedAdds,
            'additionalServicePrices' => $additionalServicePrices,
        ];
    }

    public function process(Request $request, $booking)
    {
        $booking = Booking::findOrFail($booking);

        // Check if payment already confirmed for this booking
        $existingPayment = Payment::where('booking_id', $booking->id)
            ->where('status', 'confirmed')
            ->first();

        if ($existingPayment) {
            return response()->json([
                'message' => 'Booking already paid. Cannot process again.',
            ], 409);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'address'    => 'required|string',
            'city'       => 'required|string|max:255',
            'province'   => 'required|string|max:255',
            'zip_code'   => 'nullable|string|max:255',
            'country'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        LaravelSession::put('billing_info_' . $booking->id, $validator->validated());

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $booking->service->service_name . " ({$booking->duration}(hour)s)",
                        ],
                        'unit_amount'  => (int)round($booking->total_amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['booking' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('payment.cancel',  ['booking' => $booking->id]),
                'metadata'    => array_merge($validator->validated(), [
                    'booking_id' => $booking->id,
                    'amount'     => $booking->total_amount,
                ]),
            ]);

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            Log::error('Stripe Session Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Booking is reserved, but payment failed or was declined.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function success(Request $request, $bookingId)
    {
        try {
            // ✅ If session_id exists, process the payment
            $sessionId = $request->get('session_id');

            if ($sessionId) {
                Stripe::setApiKey(config('services.stripe.secret'));
                $session = Session::retrieve($sessionId);

                if ($session->payment_status !== 'paid') {
                    return redirect()->route('payment-declined')
                        ->with('error', 'Payment not completed.')
                        ->with('booking_id', $bookingId);
                }

                $metadata = $session->metadata;
                $bookingId = $metadata->booking_id ?? $bookingId;
                $amount = $metadata->amount ?? null;

                if (!$bookingId || !$amount) {
                    return redirect()->route('payment-declined')
                        ->with('error', 'Invalid payment metadata.')
                        ->with('booking_id', $bookingId);
                }

                // Only insert if not already confirmed
                if (!Payment::where('booking_id', $bookingId)->where('status', 'confirmed')->exists()) {
                    Payment::create([
                        'booking_id'      => $bookingId,
                        'amount'          => $amount,
                        'payment_gateway' => 'stripe',
                        'status'          => 'confirmed',
                    ]);

                    // Save billing info if not already exists
                    if (!BillingInformation::where('booking_id', $bookingId)->exists()) {
                        BillingInformation::create([
                            'booking_id' => $bookingId,
                            'first_name' => $metadata->first_name ?? null,
                            'last_name'  => $metadata->last_name ?? null,
                            'email'      => $metadata->email ?? null,
                            'address'    => $metadata->address ?? null,
                            'city'       => $metadata->city ?? null,
                            'province'   => $metadata->province ?? null,
                            'zip_code'   => $metadata->zip_code ?? null,
                            'country'    => $metadata->country ?? null,
                        ]);
                    }

                    // ✅ Update booking payment status
                    $bookingModel = Booking::find($bookingId);
                    if ($bookingModel) {
                        $bookingModel->payment_status = 'confirmed';
                        $bookingModel->save();

                    }
                }

                // Redirect to same page WITHOUT session_id to prevent re-processing on reload
                return redirect()->route('payment.success', ['booking' => $bookingId])
                    ->with('message', 'Payment successful!');
            }

            // ✅ Handle reload / second-time visit (no session_id, but booking ID is available)
            $bookingModel = Booking::with(['service', 'provider', 'timeSlot'])->findOrFail($bookingId);
            $billingInfo = BillingInformation::where('booking_id', $bookingId)->first();

            return view('payment.success', array_merge([
                'booking'     => $bookingModel,
                'billingInfo' => $billingInfo,
                'message'     => session('message', 'Payment already confirmed.'),
            ], $this->extractBookingDetails($bookingModel)));
        } catch (\Exception $e) {
            Log::error('Stripe Payment Success Error: ' . $e->getMessage());

            return redirect()->route('payment-declined')
                ->with('error', 'Unexpected error after payment: ' . $e->getMessage())
                ->with('booking_id', $bookingId);
        }
    }



    public function cancel(Request $request, $booking)
    {
        return redirect()->route('payment-declined', ['booking' => $booking])
            ->with('error', 'Payment was cancelled.');
    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
