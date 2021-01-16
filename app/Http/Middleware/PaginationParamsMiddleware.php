<?php

namespace App\Http\Middleware;

use App\Pipeline\Filter;
use App\Pipeline\Limit;
use App\Pipeline\Order;
use App\Pipeline\OrderBy;
use App\Pipeline\Page;
use App\Pipeline\Search;
use Closure;
use Illuminate\Routing\Pipeline;

class PaginationParamsMiddleware
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
        $result = app(Pipeline::class)
            ->send($request)
            ->through([
                Page::class,
                Limit::class,
                Search::class,
                Filter::class,
                Order::class,
                OrderBy::class
            ])
            ->thenReturn();

        return $next($result);
    }
}
