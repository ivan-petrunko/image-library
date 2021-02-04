<?php

declare(strict_types=1);

namespace Petrunko\Image\Resizer;

use Petrunko\Image\Size\Calculator\CalculatorInterface;

interface ResizerInterface
{
    /**
     * @param string $sourceFilePath
     * @param string $destFilePath
     * @param CalculatorInterface $calculator
     * @param ResizerOptions $options
     *
     * @throws ResizerException
     */
    public function resize(
        string $sourceFilePath,
        string $destFilePath,
        CalculatorInterface $calculator,
        ResizerOptions $options
    ): void;
}
