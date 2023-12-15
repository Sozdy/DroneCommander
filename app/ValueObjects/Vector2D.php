<?php

namespace App\ValueObjects;

use App\Exceptions\Vector2DInvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

class Vector2D implements Arrayable, Jsonable, JsonSerializable
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param string $string Example: 1x1 or 0x1
     * @param string $separator
     * @return Vector2D
     * @throws Vector2DInvalidArgumentException
     */
    public static function fromString(string $string, string $separator = 'x'): Vector2D
    {
        $parts = explode($separator, $string);
        $is_valid = count($parts) === 2
            && is_numeric($parts[0])
            && is_numeric($parts[1]);

        if (! $is_valid) {
            throw new Vector2DInvalidArgumentException("Invalid string format \"$string\". Example: 1x1 or 0x1");
        }
        return new Vector2D((int)$parts[0], (int)$parts[1]);
    }

    /**
     * @param string $abbreviation Example: Left, Down, Up or Right
     * @return Vector2D
     * @throws Vector2DInvalidArgumentException
     */
    public static function fromAbbreviation(string $abbreviation): Vector2D
    {
        $strtolower_abbreviation = mb_strtolower(trim($abbreviation));

        return match ($strtolower_abbreviation) {
            'down' => static::down(),
            'left' => static::left(),
            'right' => static::right(),
            'up' => static::up(),
            default => throw new Vector2DInvalidArgumentException(
                "Invalid abbreviation \"$abbreviation\". Abbreviation can be only \"down, left, right, up\"",
            ),
        };
    }

    public static function down(): Vector2D
    {
        return new Vector2D(0, -1);
    }

    public static function left(): Vector2D
    {
        return new Vector2D(-1, 0);
    }

    public static function right(): Vector2D
    {
        return new Vector2D(1, 0);
    }

    public static function up(): Vector2D
    {
        return new Vector2D(0, 1);
    }

    public static function zero(): Vector2D
    {
        return new Vector2D(0, 0);
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function add(Vector2D $other): Vector2D
    {
        return new Vector2D($this->x + $other->x, $this->y + $other->y);
    }

    public function subtract(Vector2D $other): Vector2D
    {
        return new Vector2D($this->x - $other->x, $this->y - $other->y);
    }

    public function equals(Vector2D $other): bool
    {
        return $this->x === $other->x && $this->y === $other->y;
    }

    public function isXNegative(): bool
    {
        return $this->x < 0;
    }

    public function isYNegative(): bool
    {
        return $this->y < 0;
    }

    public function isXGreaterThan(float $value): bool
    {
        return $this->x > $value;
    }

    public function isYGreaterThan(float $value): bool
    {
        return $this->y > $value;
    }

    public function isXLessThan(float $value): bool
    {
        return $this->x < $value;
    }

    public function isYLessThan(float $value): bool
    {
        return $this->y < $value;
    }

    public function toString(): string
    {
        return sprintf('%s%s%s', $this->x, 'x', $this->y);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toArray(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toJson();
    }

    public function toAbbreviation(): string
    {
        $abbreviation = '';

        if ($this->y > 0) {
            $abbreviation .= 'Up';
        } elseif ($this->y < 0) {
            $abbreviation .= 'Down';
        }

        if ($this->x < 0) {
            $abbreviation .= 'Left';
        } elseif ($this->x > 0) {
            $abbreviation .= 'Right';
        }

        return $abbreviation ?: 'Zero';
    }
}
