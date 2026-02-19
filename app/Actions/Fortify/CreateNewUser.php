<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', \Laravel\Fortify\Rules\Password::default()],
        'accepted_policies' => ['required'],
    ])->validate();

    return User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'rol_id' => 3, // visitante por defecto
        'accepted_policies' => true,
        'accepted_at' => Carbon::now(),
        'accepted_ip' => request()->ip(),
    ]);
}}

