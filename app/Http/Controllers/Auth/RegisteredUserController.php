<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Referral;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $view = config('front.pages.register');

        if (!$view) {
            abort(404);
        }

        return view($view);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        $referralUser = null;

        if ($request->referral_code && option('user_refrral_enable', false)) {
            $referralUser = User::where('referral_code', $request->referral_code)->first();
        }

        return DB::transaction(function () use ($validated, $request, $referralUser) {

            $user = User::create([
                'first_name'          => request('first_name'),
                'last_name'           => request('last_name'),
                'mobile'        => $request->username,
                'username'        => $request->username,
                'national_code' => $request->national_code,
                'password'      => Hash::make($validated['password']),
                'referral_code' => Referral::generateCode(),
                'referral_id'   => $referralUser?->id,
                // اگر بخوای colleague رو فعال کنی، اینجا اضافه میشه:
                // 'type'   => $request->colleague ? 'colleague' : 'customer',
                // 'status' => $request->colleague ? 'pending' : 'active',
            ]);

            if ($referralUser) {
                Referral::create([
                    'owner_id' => $referralUser->id,
                    'user_id'  => $user->id,
                ]);
            }

            event(new Registered($user));
            Auth::login($user);

            return response('success');
        });
    }

}
