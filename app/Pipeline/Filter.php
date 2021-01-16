<?php

namespace App\Pipeline;

use Closure;

/**
 * Class Filter
 * @package App\Pipeline
 * @author richard  <chadxxx21@gmail.com>
 * @since 02/22/2020
 */
class Filter
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
        if (!$request->has('filter_keys') || !is_array($request->get('filter_keys')) ) {
            $params = $request->all();
            $params['filter_keys'] = [];
            $request->merge($params);
        }

        if (!$request->has('filter_values') || !is_array($request->get('filter_values')) ) {
            $params = $request->all();
            $params['filter_values'] = [];
            $request->merge($params);
        }

        return $next($request);
    }
}
