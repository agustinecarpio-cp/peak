<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

/**
 * Class DBTransaction
 * @package App\Http\Middleware
 * @author richard <chadxxx21@gmail.com>
 * @since 03/12/2020
 */
class DBTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param         $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        try {
            return DB::transaction(function () use ($request, $next){
                $response = $next($request);

                if (!empty($response->exception)) {
                    throw $response->exception;
                }

                return $response;
            });
        } catch (\Exception $exception) {

            if (method_exists($exception, 'render')) {
                return $exception->render($request);
            }
            throw $exception;

        }

    }
}
