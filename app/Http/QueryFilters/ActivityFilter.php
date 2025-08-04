<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Closure;

class ActivityFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled('activity_id')) {
            $query->whereHas('activities', function ($q) {
                $q->where('activities.id', request('activity_id'));
            });
        }
        return $next($query);
    }
}
