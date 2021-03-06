<?php

declare(strict_types=1);

namespace Petrunko\Image\Size\Calculator;

use Petrunko\Image\Size\Size;

/**
 * @see \Tests\Petrunko\Image\Size\Calculator\FitCalculatorTest
 */
class FitCalculator implements CalculatorInterface
{
    public function calculate(Size $source, Size $destination): Size
    {
        $aspectRatio = $source->getWidth() / $source->getHeight();
        $newHeight = (int)round($destination->getWidth() / $aspectRatio);
        if ($newHeight > $destination->getHeight()) {
            $newWidth = (int)round($destination->getHeight() * $aspectRatio);
            return new Size($newWidth, $destination->getHeight());
        }
        return new Size($destination->getWidth(), $newHeight);
    }
}
