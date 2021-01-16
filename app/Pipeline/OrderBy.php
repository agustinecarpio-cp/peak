<?php

namespace App\Pipeline;

use Closure;

class OrderBy
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
        if (!$request->has('order_by')) {
            $params = $request->all();
            $params['order_by'] = 'id';
            $request->merge($params);
        }
        return $next($request);
    }
}
