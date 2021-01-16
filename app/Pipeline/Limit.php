<?php

namespace App\Pipeline;

use Closure;

/**
 * Class Limit
 * @package App\Pipeline
 * @author richard <chadxxx21@gmail.com>
 * @since 02/22/2020
 */
class Limit
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
        if (!$request->has('limit')) {
            $params = $request->all();
            $params['limit'] = 5;
            $request->merge($params);
        }
        return $next($request);
    }
}
