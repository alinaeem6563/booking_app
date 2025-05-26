<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(Request $request){
        $recommendedServices = Service::with(['provider', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->inRandomOrder()
            ->limit(4)
            ->get();
        $services = Service::with('provider')->get();
        $providerId = $request->input('provider_id');

        $query = Service::with(['provider', 'reviews']);

        if ($providerId) {
            $query->where('provider_id', $providerId); // or 'user_id' based on your DB
        }
        $allProviders =  User::where('account_type', 'provider')
            ->with(['services' => function ($query) {
                $query->select('id', 'provider_id', 'service_location');
            }])
            ->get();
        return view('home.Home',compact('recommendedServices', 'services', 'allProviders'));
    }
}
 