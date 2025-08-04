<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Closure;


class NameFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
        return $next($query);
    }
}
