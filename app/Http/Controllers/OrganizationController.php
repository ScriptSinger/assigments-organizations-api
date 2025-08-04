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
     * @OA\Get(
     *     path="/organizations",
     *     summary="Получить список организаций",
     *     description="Возвращает список организаций с возможностью фильтрации по зданию, названию, геопозиции и виду деятельности (включая дерево до 3 уровней).",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="building_id",
     *         in="query",
     *         description="ID здания для фильтрации",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Поиск по названию организации",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         description="Широта для фильтрации по радиусу",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=54.7388)
     *     ),
     *     @OA\Parameter(
     *         name="lng",
     *         in="query",
     *         description="Долгота для фильтрации по радиусу",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=55.9721)
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         description="Радиус поиска (в километрах)",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="activity_id",
     *         in="query",
     *         description="ID вида деятельности (учитывается дерево до 3 уровней)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *                 @OA\Property(property="phones", type="array", @OA\Items(type="string"), example={"2-222-222", "8-923-666-13-13"}),
     *                 @OA\Property(property="building", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="address", type="string", example="г. Уфа, ул. Ленина 1"),
     *                     @OA\Property(property="latitude", type="number", format="float", example=54.7388),
     *                     @OA\Property(property="longitude", type="number", format="float", example=55.9721)
     *                 ),
     *                 @OA\Property(property="activities", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Молочная продукция")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/organizations/{organization}",
     *     summary="Получить организацию по ID",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         description="ID организации",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные организации",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string", example="123"),
     *             @OA\Property(property="name", type="string", example="Название организации"),
     *             @OA\Property(property="building", type="object", ref="#/components/schemas/Building"),
     *             @OA\Property(property="activities", type="array", @OA\Items(ref="#/components/schemas/Activity"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена"
     *     )
     * )
     */

    public function show(string $id)
    {
        $organization = Organization::with(['building', 'activities'])->findOrFail($id);
        return response()->json($organization);
    }
}
