<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Customer;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_shops' => Shop::count(),
            'active_shops' => Shop::where('is_active', true)->count(),
            'total_customers' => Customer::withoutGlobalScope('shop')->count(),
            'total_loans' => Loan::withoutGlobalScope('shop')->count(),
        ];

        $latest_shops = Shop::withCount(['customers', 'loans'])->latest()->take(5)->get();

        return view('super-admin.dashboard', compact('stats', 'latest_shops'));
    }
}
