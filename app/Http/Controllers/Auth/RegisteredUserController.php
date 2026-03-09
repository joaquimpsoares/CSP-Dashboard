<?php

namespace App\Http\Controllers\Auth;

use App\Country;
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
        $countries = Country::pluck('name', 'id');
        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Company fields
            'company_name' => ['required', 'string', 'max:255'],
            'nif'          => ['required', 'string', 'max:20'],
            'country_id'   => ['required', 'integer', 'exists:countries,id'],
            'address_1'    => ['required', 'string', 'max:255'],
            'address_2'    => ['nullable', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:255'],
            'state'        => ['required', 'string', 'max:255'],
            'postal_code'  => ['required', 'string', 'max:20'],
            // User fields
            'name'           => ['required', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:20'],
            'email'          => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        // Resolve Provider user level — must be set in the INSERT itself to avoid FK violation
        $providerLevelId = \App\UserLevel::where('name', config('app.provider'))->value('id');

        $user = (new User())->forceFill([
            'name'                      => $request->name,
            'last_name'                 => $request->last_name,
            'phone'                     => $request->phone,
            'country_id'                => $request->country_id,
            'email'                     => $request->email,
            'password'                  => Hash::make($request->password),
            'user_level_id'             => $providerLevelId,
            'terms_accepted_at'         => now(),
            'notifications_preferences' => 1,
        ]);
        $user->save();

        // Create a Provider record with full company details and link it to this user
        $provider = \App\Provider::create([
            'company_name' => $request->company_name,
            'nif'          => $request->nif,
            'country_id'   => $request->country_id,
            'address_1'    => $request->address_1,
            'address_2'    => $request->address_2,
            'city'         => $request->city,
            'state'        => $request->state,
            'postal_code'  => $request->postal_code,
            'status_id'    => 4, // Pending — awaiting onboarding completion
        ]);
        $user->forceFill(['provider_id' => $provider->id])->save();

        // Assign Spatie Provider role so middleware/scopes work from first login
        $user->assignRole('Provider');

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
