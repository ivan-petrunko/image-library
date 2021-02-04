<?php

declare(strict_types=1);

namespace Petrunko\Image\Size\Calculator;

use Petrunko\Image\Size\Size;

interface CalculatorInterface
{
    public function calculate(Size $source, Size $destination): Size;
}
