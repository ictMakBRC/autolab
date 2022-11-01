<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\LoginActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        //return $request;

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        LoginActivity::addToLog('logged Out', Auth::user()->email, $request->ip());

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function generate()
    {
        $letters='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lettersLength = strlen($letters);
        //AAA001
        // $letter1=$letters[0];
        // $letter2=$letters[0];
        // $letter3=$letters[0];
        $labno=null;
        $labno =$letters[0].$letters[1].$letters[2].'001';
        if ($labno) {
            $letterPart=substr($labno,0,3);
            $numPart=(int)substr($labno,3)+1;

            $letter1=$letterPart[0];
            $letter2=$letterPart[1];
            $letter3=$letterPart[2];

            $letterPos=strpos($letters,$letterPart[0]);//position of the substr letter in letters

            if ($numPart<10 || $numPart<100 ||$numPart<1000) {
                $numPart=str_pad($numPart, 3, '0', STR_PAD_LEFT);
            }

            if ((int)$numPart==1000) {
                $labno = $letters[0].$letters[0].$letters[0].'001';
            }

            // return $letter2;
            

            
        }else{
            $labno =$letters[0].$letters[0].$letters[0].'001';
        }

        return $labno;
    }
}
