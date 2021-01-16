<?php

namespace App\Pipeline;

use Closure;

/**
 * Class Page
 * @package App\Pipeline
 * @author richard <chadxxx21@gmail.com>
 * @since 02/22/2020
 */
class Page
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
        if (!$request->has('page')) {
            $params = $request->all();
            $params['page'] = 1;
            $request->merge($params);
        }
        return $next($request);
    }
}
