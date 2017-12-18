<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator;

use Ramsey\Uuid\UuidFactory;

class Generator
{
    private $outputDirectory;

    private $uuidFactory;

    public function __construct(string $outputDirectory, UuidFactory $uuidFactory)
    {
        $this->outputDirectory = $outputDirectory;
        $this->uuidFactory     = $uuidFactory;
    }

    public function generate(Image $image, string $text): Comic
    {
        $image->addText($text);

        $filename = sprintf('%s/%s.png', $this->outputDirectory, $this->uuidFactory->uuid4());

        imagepng($image->getResource(), $filename);

        return new Comic($filename);
    }
}
