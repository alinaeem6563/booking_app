<?php

namespace App\Http\Controllers\PrintReceipt;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PrintReceiptController extends Controller
{
    public function index()
    {
        return view('payment.print-receipt');
    }

    public function show($id)
    {
        $receipt = Booking::with('service')->findOrFail($id);

        if (Auth::id() !== $receipt->user_id && Auth::user()->account_type !== 'admin') {
            abort(403, 'Unauthorized access to this receipt.');
        }

        $serviceOfferingName = 'Unknown Service';
        $servicePrice = 0;
        $offeringId = trim((string) $receipt->service_offering_id);

        // Decode service offerings
        $rawOfferings = $receipt->service->service_offerings;
        $decodedOnce = json_decode($rawOfferings, true);
        $offerings = is_string($decodedOnce)
            ? json_decode($decodedOnce, true) ?? []
            : ($decodedOnce ?? []);

        foreach ($offerings as $off) {
            if (isset($off['service_id']) && trim($off['service_id']) === $offeringId) {
                $serviceOfferingName = $off['service_name'] ?? 'Unknown';
                $servicePrice = isset($off['price']) ? (float)$off['price'] : 0;
                break;
            }
        }

        // Additional services
        $rawAdds = $receipt->service->additional_services;
        $adds = json_decode($rawAdds, true) ?? [];

        $additionalServicePrices = [];
        foreach ($adds as $add) {
            $additionalServicePrices[$add['name']] = (float)$add['price'];
        }

        $selectedAdds = json_decode($receipt->additional_services, true) ?? [];

        // 🧮 CALCULATIONS

        $duration = $receipt->duration; // assumed to be in hours
        $subTotal = $servicePrice * $duration + $receipt->service->service_fee;

        $additionalTotal = 0;
        foreach ($selectedAdds as $item) {
            if (isset($additionalServicePrices[$item])) {
                $additionalTotal += $additionalServicePrices[$item];
            }
        }

        $beforeTaxTotal = $subTotal + $additionalTotal;

        $taxRate = (float) $receipt->service->tax;
        $taxAmount = round(($beforeTaxTotal * $taxRate) / 100, 2);

        $grandTotal = $beforeTaxTotal + $taxAmount;

        return view('payment.print-receipt', compact(
            'receipt',
            'selectedAdds',
            'additionalServicePrices',
            'serviceOfferingName',
            'servicePrice',
            'duration',
            'beforeTaxTotal',
            'additionalTotal',
            'taxRate',
            'taxAmount',
            'grandTotal'
        ));
    }
}
