<?php

namespace App\ValueObjects;

use App\Exceptions\ValueObjects\Vector2DInvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Vector2D implements Arrayable, Jsonable, JsonSerializable
{
    public static Vector2D $down;
    public static Vector2D $left;
    public static Vector2D $right;
    public static Vector2D $up;
    public static Vector2D $zero;

    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;

        static::$down = new Vector2D(0, -1);
        static::$left = new Vector2D(-1, 0);
        static::$right = new Vector2D(1, 0);
        static::$up = new Vector2D(0, 1);
        static::$zero = new Vector2D(0, 0);
    }

    /**
     * @param string $string Example: 1x1 or 0x1
     * @param string $separator
     * @return Vector2D
     */
    public function fromString(string $string, string $separator = 'x'): Vector2D
    {
        $parts = explode($separator, $string);

        return new Vector2D((int) $parts[0], (int) $parts[1]);
    }

    /**
     * @param string $abbreviation Example: Left, Down, Up or Right
     * @return Vector2D
     * @throws Vector2DInvalidArgumentException
     */
    public function fromAbbreviation(string $abbreviation): Vector2D
    {
        $strtolower_abbreviation = mb_strtolower($abbreviation);

        return match ($strtolower_abbreviation) {
            'down' => static::$down,
            'left' => static::$left,
            'right' => static::$right,
            'up' => static::$up,
            default => throw new Vector2DInvalidArgumentException('Invalid abbreviation' . $abbreviation),
        };
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
