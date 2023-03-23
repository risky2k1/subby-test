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

        $end_at=$company->subscription('main')->getSubscriptionTotalDurationIn('day');

        if ($company->hasActiveSubscription()) {

            $company->subscription()->renew();

        } else(
            $company->newSubscription(
            'main', // identifier tag of the subscription. If your application offers a single subscription, you might call this 'main' or 'primary'
            $plan, // Plan or PlanCombination instance your subscriber is subscribing to
            $plan->name, // Human-readable name for your subscription
            $plan->description, // Description
            Carbon::now(), // Start date for the subscription, defaults to now()
            'free' // Payment method service defined in config
        ));


        return redirect()->route('admin.company.index',[
            'end_at'=>$end_at,
        ])->with([
            'success'=> 'Your subscription has been created.',
            'end_at'=> $end_at,
        ]);
    }
}
