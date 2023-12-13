<?php

namespace App\Casts;

use App\ValueObjects\Vector2D;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsVector2D implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return Vector2D::fromString($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof Vector2D) {
            return $value->toString();
        }
        try {
            return Vector2D::fromAbbreviation($value)->toString();
        } catch (\Throwable $th) {
            return Vector2D::fromString($value)->toString();
        }
    }
}
