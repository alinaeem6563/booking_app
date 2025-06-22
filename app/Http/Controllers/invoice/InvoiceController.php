<?php

namespace App\Http\Controllers\invoice;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $bookingInvoices = Booking::where('provider_id', Auth::id())->get();
        $amountSums = Booking::where('provider_id', Auth::id())
            ->select('payment_status', DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');
        $paymentCounts = Booking::select('payment_status', DB::raw('COUNT(*) as total'))
            ->where('provider_id', Auth::id())
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');
        $totalConfirmedAmount = $amountSums['confirmed'] ?? 0;
        $totalPendingAmount   = $amountSums['pending'] ?? 0;
        $confirmedCount = $paymentCounts['confirmed'] ?? 0;
        $pendingCount   = $paymentCounts['pending'] ?? 0;
        $invoices = $bookingInvoices->map(function ($invoice) {
            $offerings = json_decode($invoice->service->service_offerings ?? '[]', true);

            // Find the offering that matches the booking's offering ID
            $matchedOffering = collect($offerings)->firstWhere('service_id', $invoice->service_offering_id);
            $selectedExtras = json_decode($invoice->additional_services ?? '[]', true);
            $serviceExtras = json_decode($invoice->service->additional_services ?? '[]', true);

            $items = collect($selectedExtras)->map(function ($serviceName) use ($serviceExtras) {
                $matched = collect($serviceExtras)->firstWhere('name', $serviceName);
                $price = isset($matched['price']) ? floatval($matched['price']) : 0;
                return [
                    'name' => $serviceName,
                    'price' => $price,
                    'totalAmount' => $price,
                ];
            });
            return [
                'id' => $invoice->id,
                'invoiceNumber' => '#BE-' . date('Y') . '-00' . $invoice->id,
                'service' => $matchedOffering['service_name'] ?? 'Not found',
                'servicePrice' => $matchedOffering['price'] ?? 'Not found',
                'status' => $invoice->payment_status,
                'clientName' => trim(($invoice->user->first_name ?? '') . ' ' . ($invoice->user->last_name ?? '')),
                'issueDate' => $invoice->billingInformation->updated_at,
                'amount' => $invoice->total_amount,
                'clientAvatar' => $invoice->user->profile_photo_url ?? asset('images/default-avatar.png'),
                'clientEmail' => $invoice->billingInformation->email,
                'paymentDate' => $invoice->billingInformation->updated_at,
                'description' => $invoice->special_instruction ?? 'N/A',
                'items' => $items,
                'serviceFee' => $invoice->service->service_fee ?? '0',
                'tax' => $invoice->service->tax ?? '0',
                'subtotal' => $invoice->total_amount
                    - ($invoice->service->service_fee ?? 0)
                    - ($invoice->service->tax ?? 0),
                'time' => $invoice->duration,

            ];
        });
        return view('invoice.all-invoices', [
            'invoices' => $invoices,
            'totalConfirmedAmount' => $totalConfirmedAmount,
            'totalPendingAmount' => $totalPendingAmount,
            'confirmedCount' => $confirmedCount,
            'pendingCount' => $pendingCount,

        ]);
    }
    public function userInvoice()
    {
        $bookingInvoices = Booking::where('user_id', Auth::id())->get();
        $amountSums = Booking::where('user_id', Auth::id())
            ->select('payment_status', DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');
        $paymentCounts = Booking::select('payment_status', DB::raw('COUNT(*) as total'))
            ->where('user_id', Auth::id())
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');
        $totalConfirmedAmount = $amountSums['confirmed'] ?? 0;
        $totalPendingAmount   = $amountSums['pending'] ?? 0;
        $confirmedCount = $paymentCounts['confirmed'] ?? 0;
        $pendingCount   = $paymentCounts['pending'] ?? 0;
        $invoices = $bookingInvoices->map(function ($invoice) {
            $offerings = json_decode($invoice->service->service_offerings ?? '[]', true);

            // Find the offering that matches the booking's offering ID
            $matchedOffering = collect($offerings)->firstWhere('service_id', $invoice->service_offering_id);
            $selectedExtras = json_decode($invoice->additional_services ?? '[]', true);
            $serviceExtras = json_decode($invoice->service->additional_services ?? '[]', true);

            $items = collect($selectedExtras)->map(function ($serviceName) use ($serviceExtras) {
                $matched = collect($serviceExtras)->firstWhere('name', $serviceName);
                $price = isset($matched['price']) ? floatval($matched['price']) : 0;
                return [
                    'name' => $serviceName,
                    'price' => $price,
                    'totalAmount' => $price,
                ];
            });
            return [
                'id' => $invoice->id,
                'invoiceNumber' => '#BE-' . date('Y') . '-00' . $invoice->id,
                'service' => $matchedOffering['service_name'] ?? 'Not found',
                'servicePrice' => $matchedOffering['price'] ?? 'Not found',
                'status' => $invoice->payment_status,
                'clientName' => trim(($invoice->user->first_name ?? '') . ' ' . ($invoice->user->last_name ?? '')),
                'issueDate' => $invoice->billingInformation->updated_at,
                'amount' => $invoice->total_amount,
                'clientAvatar' => $invoice->user->profile_photo_url ?? asset('images/default-avatar.png'),
                'clientEmail' => $invoice->billingInformation->email,
                'paymentDate' => $invoice->billingInformation->updated_at,
                'description' => $invoice->special_instruction ?? 'N/A',
                'items' => $items,
                'serviceFee' => $invoice->service->service_fee ?? '0',
                'tax' => $invoice->service->tax ?? '0',
                'subtotal' => $invoice->total_amount
                    - ($invoice->service->service_fee ?? 0)
                    - ($invoice->service->tax ?? 0),
                'time' => $invoice->duration,

            ];
        });
        return view('invoice.user-invoice', [
            'invoices' => $invoices,
            'totalConfirmedAmount' => $totalConfirmedAmount,
            'totalPendingAmount' => $totalPendingAmount,
            'confirmedCount' => $confirmedCount,
            'pendingCount' => $pendingCount,

        ]);
    }
}
