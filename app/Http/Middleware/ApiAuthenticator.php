<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\AuthHelper;

class ApiAuthenticator
{
    protected $authHelper;


    public function __construct(AuthHelper $authHelper)
    {
        $this->authHelper = $authHelper;
    }

    public function handle($request, Closure $next)
    {
        $securityCode = $request->header('auth');
        $sessionData = $this->authHelper->authenticate($securityCode);
        if($sessionData){
            $status = 'valid';
        } else {
            $status = 'invalid';
        }

        if ($status == 'valid') {
            return $next($request);
        } else {
            return response()->json([
                'auth' => $status
            ]);
        }
    }
}
