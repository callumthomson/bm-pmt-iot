<?php

namespace App\Http\Middleware;

use Closure;
use App\Device;

class VerifyApiToken
{
    private $token;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->tokenExists($request)) {
            $this->token = $request->input('token');
        } else {
            return response(null, 401);
        }

        if(!$this->tokenValid()) {
            return response(null, 401);
        }
        return $next($request);
    }

    public function tokenExists($request)
    {
        $token = $request->input('token', null);
        if($token != null) {
            $this->token = $token;
            return true;
        }
        return false;
    }

    public function tokenValid()
    {
        $device = Device::where('token', '=', $this->token)->first();
        if($device != null) {
            return true;
        }
        return false;
    }
}
