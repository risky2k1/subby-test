<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Bpuig\Subby\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::query()->get();

        return view('admin.master', [
            'companies' => $companies,
        ]);
    }

    public function subscribeCompany(Request $request)
    {
        $company = Company::find($request->input('company_id'));

        $plan = Plan::find($request->input('plan'));
//    dd($company->subscription('main')->isActive());
        // Subscribe the company to the selected plan
//            if ($plan === '6-months') {
////                dd('vao day');
        if ($company->subscription()->isActive()) {
            $company->subscription()->renew();
        } else($company->newSubscription(
            'main', // identifier tag of the subscription. If your application offers a single subscription, you might call this 'main' or 'primary'
            $plan, // Plan or PlanCombination instance your subscriber is subscribing to
            $plan->name, // Human-readable name for your subscription
            $plan->description, // Description
            Carbon::now(), // Start date for the subscription, defaults to now()
            'free' // Payment method service defined in config
        ));

//                dd('plan sub succsses');
//            } elseif ($plan === '12-months') {
//                $company->newSubscription('main', '12-months')->create();
//            }

        return redirect()->route('admin.company.index')->with('success', 'Your subscription has been created.');
    }
}
