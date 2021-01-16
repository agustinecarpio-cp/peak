<?php

namespace App\Pipeline;

use Closure;

class Order
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('order')) {
            $params = $request->all();
            $params['order'] = 'DESC';
            $request->merge($params);
        }
        return $next($request);
    }
}
