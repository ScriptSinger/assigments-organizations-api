<?php

namespace App\Http\Controllers;

use App\Http\QueryFilters\ActivityFilter;
use App\Http\QueryFilters\ActivityTreeFilter;
use App\Http\QueryFilters\BuildingFilter;
use App\Http\QueryFilters\GeoFilter;
use App\Http\QueryFilters\NameFilter;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = app()->make(Pipeline::class)
            ->send(Organization::query()->with(['building', 'activities']))
            ->through([
                ActivityFilter::class,
                NameFilter::class,
                BuildingFilter::class,
                GeoFilter::class,
                ActivityTreeFilter::class
            ])
            ->thenReturn()
            ->get();

        return response()->json($organizations);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organization = Organization::with(['building', 'activities'])->findOrFail($id);
        return response()->json($organization);
    }
}
