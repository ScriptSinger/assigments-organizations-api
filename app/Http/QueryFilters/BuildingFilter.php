<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Closure;

class BuildingFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled('building_id')) {
            $query->where('building_id', request('building_id'));
        }
        return $next($query);
    }
}
