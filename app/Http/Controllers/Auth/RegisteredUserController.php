<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->forceFill(['terms_accepted_at' => now()])->save();

        event(new Registered($user));

        Auth::login($user);

        // Send OTP immediately after registration
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->forceFill([
            'otp_code'       => bcrypt($code),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        Mail::to($user->email)->send(new \App\Mail\OnboardingOtpMail($user, $code));

        return redirect()->route('onboarding.verify');
    }
}
