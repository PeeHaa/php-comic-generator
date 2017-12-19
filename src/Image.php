<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator;

use PeeHaa\PHPComicGenerator\Exception\FileNotFoundException;
use PeeHaa\PHPComicGenerator\Exception\InvalidSourceImageException;

class Image
{
    private const MAXIMUM_FONT_SIZE = 128;
    private const MINIMUM_FONT_SIZE = 8;

    private const QUOTE_OFFSET_X = 35;
    private const QUOTE_OFFSET_Y = 35;

    private const MAXIMUM_WIDTH  = 345;
    private const MAXIMUM_HEIGHT = 390;

    private $sourcePath;

    private $image;

    public function __construct(string $sourcePath, Type $type)
    {
        $this->sourcePath = $sourcePath;

        $filename = sprintf('%s/images/%s', $sourcePath, $type);

        if (!file_exists($filename)) {
            throw new FileNotFoundException(sprintf('The source file (%s) could not be found.', $filename));
        }

        $this->image = @imagecreatefrompng($filename);

        if (!$this->image) {
            throw new InvalidSourceImageException(sprintf('The source file (%s) could not be loaded.', $filename));
        }
    }

    public function addText(string $text): void
    {
        $fontSize      = $this->calculateFontSize($text);
        $formattedText = $this->splitTextOverLines($fontSize, $text);
        $position      = $this->calculatePosition($fontSize, $formattedText);

        imagettftext(
            $this->image,
            $fontSize,
            0,
            $position['x'],
            $position['y'],
            imagecolorallocate($this->image, 0, 0, 0),
            sprintf('%s/fonts/%s', $this->sourcePath, 'Pangolin-Regular.ttf'),
            $formattedText
        );
    }

    private function calculateFontSize(string $text): int
    {
        $fontSize = self::MAXIMUM_FONT_SIZE;

        while($fontSize >= self::MINIMUM_FONT_SIZE) {
            if ($this->doesTextFit($fontSize, $text)) {
                break;
            }

            $fontSize--;
        }

        return $fontSize;
    }

    private function doesTextFit(int $fontSize, string $text): bool
    {
        $formattedText = $this->splitTextOverLines($fontSize, $text);

        $positions = imagettfbbox($fontSize, 0, sprintf('%s/fonts/%s', $this->sourcePath, 'Pangolin-Regular.ttf'), $formattedText);

        if (abs($positions[4] - $positions[6]) > self::MAXIMUM_WIDTH) {
            return false;
        }

        if (abs($positions[7] - $positions[1]) > self::MAXIMUM_HEIGHT) {
            return false;
        }

        return true;
    }

    private function splitTextOverLines(int $fontSize, string $text): string
    {
        $textParts = explode(' ', $text);

        $formattedText = array_shift($textParts);

        while($textPart = array_shift($textParts)) {
            if ($this->isTextWithinWidthLimit($fontSize, sprintf('%s %s', $formattedText, $textPart))) {
                $formattedText = sprintf('%s %s', $formattedText, $textPart);
            } else {
                $formattedText = sprintf("%s\n%s", $formattedText, $textPart);
            }
        }

        return $formattedText;
    }

    private function isTextWithinWidthLimit(int $fontSize, string $text): bool
    {
        $positions = imagettfbbox(
            $fontSize,
            0,
            sprintf('%s/fonts/%s', $this->sourcePath, 'Pangolin-Regular.ttf'),
            $text
        );

        if (abs($positions[4] - $positions[6]) > self::MAXIMUM_WIDTH) {
            return false;
        }

        return true;
    }

    private function calculatePosition(int $fontSize, string $text): array
    {
        $positions = imagettfbbox($fontSize, 0, sprintf('%s/fonts/%s', $this->sourcePath, 'Pangolin-Regular.ttf'), $text);

        $textWidth  = abs($positions[4] - $positions[6]);
        $textHeight = abs($positions[7] - $positions[1]);

        return [
            'x' => (int) abs(((self::MAXIMUM_WIDTH / 2) - ($textWidth / 2) + self::QUOTE_OFFSET_X)),
            'y' => (int) abs(((self::MAXIMUM_HEIGHT / 2) - ($textHeight / 2) + self::QUOTE_OFFSET_Y)) + self::QUOTE_OFFSET_Y,
        ];
    }

    public function getResource()
    {
        return $this->image;
    }
}
