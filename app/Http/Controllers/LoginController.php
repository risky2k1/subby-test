<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!empty($request->email)) {
            $user= User::where('email',$request->email)->first();


            $company = Company::query()
                ->where('id',$user->company_id)
                ->first();

            if(!$company){
                return back()->withErrors([
                    'message'=>'Company not found',
                ]);
            }
            if($company->hasActiveSubscription()){
                return back()->withErrors([
                    'message'=>'Your company hasnt subscribe yet',
                ]);
            }
        }

        // Authenticate the user
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin');
        }

        return back()->withErrors([
            'message' => 'Invalid credentials.',
            ]);
    }
}
