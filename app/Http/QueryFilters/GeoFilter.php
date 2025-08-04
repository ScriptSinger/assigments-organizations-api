<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Closure;


class GeoFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled(['lat', 'lng', 'radius'])) {
            $lat = request('lat');
            $lng = request('lng');
            $radius = request('radius'); // в км

            $query->whereHas('building', function ($q) use ($lat, $lng, $radius) {
                $q->selectRaw("
                    (6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    )) AS distance
                ", [$lat, $lng, $lat])
                    ->having('distance', '<=', $radius);
            });
        }
        return $next($query);
    }
}
