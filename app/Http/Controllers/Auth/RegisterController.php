<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = RouteServiceProvider::PAY;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'raceType' => ['required', 'alpha'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'alpha'],
            'dateOfBirth' => ['required', 'date'],
            'angkatan' => ['required', 'numeric', 'min:1953'],
            'blood' => ['required'],
            'jersey' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:10', 'max:13'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $name = $data['firstName'] . ' ' . $data['lastName'];

        return User::create([
            'name' => $name,
            'gender' => $data['gender'],
            'dateOfBirth' => $data['dateOfBirth'],
            'angkatan' => $data['angkatan'],
            'blood' => $data['blood'],
            'jersey' => $data['jersey'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'alamat' => $data['alamat'],
            'raceType' => $data['raceType'],
        ]);
    }
}
