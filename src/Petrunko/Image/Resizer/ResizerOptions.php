<?php

declare(strict_types=1);

namespace Petrunko\Image\Resizer;

use Petrunko\Image\Size\Size;

class ResizerOptions
{
    private const DEFAULT_QUALITY = 90;

    private Size $destinationSize;
    private int $quality;

    public function __construct(
        Size $destinationSize,
        int $quality = self::DEFAULT_QUALITY
    ) {
        $this->destinationSize = $destinationSize;
        $this->quality = $quality;
    }

    public function getDestinationSize(): Size
    {
        return $this->destinationSize;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }
}
