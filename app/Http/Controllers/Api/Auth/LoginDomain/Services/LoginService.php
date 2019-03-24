<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\User;

use App\Exceptions\AuthExceptions\UnauthenticatedUser;

use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;

class LoginService implements LoginContract
{
    private function authenticateUser(string $email, string $password): User
    {
        $credentials = ['email' => $email, 'password' => $password];

        if (!Auth::attempt($credentials))
            throw new UnauthenticatedUser();

        return Auth::user();
    }

    private function createToken($user): array
    {
        $tokenResult = $user->createToken('checkpoint');
        $token = $tokenResult->token;
        $token->save();

        return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer'
        ];
    }


    public function login(string $email, string $password): array
    {
        $user = $this->authenticateUser($email, $password);
        return $this->createToken($user);
    }
}
