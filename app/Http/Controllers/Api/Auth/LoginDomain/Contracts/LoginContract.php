<?php
namespace App\Http\Controllers\Api\Auth\LoginDomain\Contracts;

interface LoginContract
{
    public function login(string $email, string $password);
}
