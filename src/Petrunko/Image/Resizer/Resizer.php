<?php

declare(strict_types=1);

namespace Petrunko\Image\Resizer;

use Petrunko\Image\Size\Calculator\CalculatorInterface;
use Petrunko\Image\Size\Size;

class Resizer implements ResizerInterface
{
    private const JPG = 'image/jpeg';
    private const PNG = 'image/png';
    private const GIF = 'image/gif';

    private const SUPPORTED_MIME_TYPES = [
        self::JPG,
        self::PNG,
        self::GIF,
    ];

    private const TRANSPARENT_MIME_TYPES = [
        self::PNG,
        self::GIF,
    ];

    /**
     * @inheritDoc
     */
    public function resize(
        string $sourceFilePath,
        string $destFilePath,
        CalculatorInterface $calculator,
        ResizerOptions $options
    ): void {
        $mimeType = mime_content_type($sourceFilePath);
        if (!\in_array($mimeType, self::SUPPORTED_MIME_TYPES, true)) {
            throw new ResizerException("Unsupported mime-type: {$mimeType}.");
        }
        $contents = file_get_contents($sourceFilePath);
        if ($contents === false) {
            throw new ResizerException("File {$sourceFilePath} is unreadable.");
        }
        $srcImage = imagecreatefromstring($contents);
        if ($srcImage === false) {
            throw new ResizerException("Cannot read image {$sourceFilePath}.");
        }
        [$srcWidth, $srcHeight] = getimagesize($sourceFilePath);
        if ($srcWidth <= 0 || $srcHeight <= 0) {
            throw new ResizerException("Image {$sourceFilePath} is empty.");
        }
        $srcSize = new Size($srcWidth, $srcHeight);
        $destSize = $calculator->calculate($srcSize, $options->getDestinationSize());

        $destImage = imagecreatetruecolor($destSize->getWidth(), $destSize->getHeight());

        if (\in_array($mimeType, self::TRANSPARENT_MIME_TYPES, true)) {
            // save transparency
            $background = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
            imagecolortransparent($destImage, $background);
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
        }

        imagecopyresampled(
            $destImage,
            $srcImage,
            0,
            0,
            0,
            0,
            $destSize->getWidth(),
            $destSize->getHeight(),
            $srcSize->getWidth(),
            $srcSize->getHeight()
        );
        $result = false;
        if ($mimeType === self::JPG) {
            $result = imagejpeg($destImage, $destFilePath, $options->getQuality());
        } elseif ($mimeType === self::PNG) {
            $result = imagepng($destImage, $destFilePath);
        } elseif ($mimeType === self::GIF) {
            $result = imagegif($destImage, $destFilePath);
        }
        if ($result === false) {
            throw new ResizerException("Cannot output image {$destFilePath}.");
        }
    }
}
