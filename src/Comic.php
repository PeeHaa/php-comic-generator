<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator;

class Comic
{
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getPath(): string
    {
        return $this->filename;
    }
}
