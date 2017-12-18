<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator\Tests\Unit;

use PeeHaa\PHPComicGenerator\Comic;
use PHPUnit\Framework\TestCase;

class ComicTest extends TestCase
{
    public function testGetPath()
    {
        $this->assertSame('/foo/bar', (new Comic('/foo/bar'))->getPath());
    }
}
