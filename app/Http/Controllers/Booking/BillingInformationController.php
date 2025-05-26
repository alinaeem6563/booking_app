<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\BillingInformation;


class BillingInformationController extends Controller
{

    public function show(string $id)
    {
        $billing = BillingInformation::with('booking')->findOrFail($id);
        return view('payment.success', compact('billing'));
    }
}
