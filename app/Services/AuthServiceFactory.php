<?php
namespace App\Services;

use App\Models\User;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;
use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceFactory
{
     /**
     * Determine authentication servicee from company name
     *
     * @param string $company
     * @return mixed
     * @throws \Exception
     */
    public static function createAuthService($company)
    {
        switch ($company) {
            case 'FOO':
                return new AuthWS();
            case 'BAR':
                return new LoginService();
            case 'BAZ':
                return new Authenticator();
            default:
                throw new \Exception('Invalid company');
        }
    }


    /**
     * Determine authentication servicee from company name
     *
     * @param string $company
     * @param string $password
     * @return boolean
     * @throws \Exception
     */
    public static function authenticate($login, $password)
    {
        $company = self::determineCompany($login);
        $service = self::createAuthService($company);
        switch ($company) {
            case 'FOO':
                if ($service->authenticate($login, $password) instanceof AuthenticationFailedException) {
                    return false;
                }
                return true;
            case 'BAR':
                return $service->login($login, $password);
            case 'BAZ':
                if ($service->auth($login, $password) instanceof Success) {
                    return true;
                }
                return false;
            default:
                throw new \Exception('Invalid company');
        }
    }


    /**
     * Determine company from login id
     *
     * @param string $login
     * @return string
     * @throws \Exception
     */
    public static function determineCompany($login)
    {
        $matches = [];
        if (preg_match('/^(FOO|BAR|BAZ)_/', $login, $matches)) {
            // The company prefix is in $matches[1]
            $companyPrefix = strtoupper($matches[1]);
            $company = strtoupper($companyPrefix);
            return $company;
        }
        throw new \Exception('Invalid company');
    }

     /**
     * Login the user with the given username and password and return the JWT token
     * @param string $login
     * @param string $password
     * @return string
     * @throws \Exception
     */
    public static function login($login, $password)
    {
        $results = self::authenticate($login, $password);
        if ($results) {
            $user = new User();
            $user->login = $login;
            $user->company = self::determineCompany($login);
            $token = JWTAuth::fromUser($user);
            return $token;
        }
        throw new \Exception('Login  Failed');

    }

}
