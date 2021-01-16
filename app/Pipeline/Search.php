<?php

namespace App\Pipeline;

use Closure;

/**
 * Class Search
 * @package App\Pipeline
 * @author richard <chadxxx21@gmail.com>
 * @since 02/22/2020
 */
class Search
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
        if (($request->has('search') && $request->input('search') === null) || !$request->has('search')) {
            $params = $request->all();
            $params['search'] = '';
            $request->merge($params);
        }

        return $next($request);
    }
}
