<?php

namespace App\Http\QueryFilters;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Closure;

class ActivityTreeFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled('activity_tree_id')) {
            $rootId = request('activity_tree_id');

            $activityIds = $this->getActivityTreeIds($rootId);

            $query->whereHas('activities', function ($q) use ($activityIds) {
                $q->whereIn('activities.id', $activityIds);
            });
        }

        return $next($query);
    }

    protected function getActivityTreeIds($rootId)
    {
        // 0 уровень (корень)
        $ids = collect([$rootId]);

        // 1 уровень
        $firstLevel = Activity::where('parent_id', $rootId)->pluck('id');
        $ids = $ids->merge($firstLevel);

        if ($firstLevel->isNotEmpty()) {
            // 2 уровень
            $secondLevel = Activity::whereIn('parent_id', $firstLevel)->pluck('id');
            $ids = $ids->merge($secondLevel);

            if ($secondLevel->isNotEmpty()) {
                // 3 уровень
                $thirdLevel = Activity::whereIn('parent_id', $secondLevel)->pluck('id');
                $ids = $ids->merge($thirdLevel);
            }
        }

        return $ids->unique();
    }
}
