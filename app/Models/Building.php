<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     title="Building",
 *     description="Модель здания",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         example="г. Уфа, ул. Ленина 1"
 *     ),
 *     @OA\Property(
 *         property="latitude",
 *         type="number",
 *         format="float",
 *         example=54.7388
 *     ),
 *     @OA\Property(
 *         property="longitude",
 *         type="number",
 *         format="float",
 *         example=55.9721
 *     )
 * )
 */
class Building extends Model
{
    protected $fillable = ['address', 'latitude', 'longitude'];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
