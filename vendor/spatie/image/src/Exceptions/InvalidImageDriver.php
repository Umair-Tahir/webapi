<?php

namespace Spatie\Image\Exceptions;

use Exception;

class InvalidImageDriver extends Exception
{
    public static function driver(string $driver): self
    {
        return new self("Client must be `gd` or `imagick`. `{$driver}` provided.");
    }
}
