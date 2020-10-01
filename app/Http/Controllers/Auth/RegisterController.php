<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\RegisterRequest;
use App\Jobs\RegisterUser;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(RedirectIfAuthenticated::class);
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, app(RegisterRequest::class)->rules());
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        $user = $this->dispatchNow(RegisterUser::fromRequest(app(RegisterRequest::class)));

        event(new Registered($user));

        return $user;
    }
}
