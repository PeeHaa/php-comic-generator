<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator\Tests\Integration;

use PeeHaa\PHPComicGenerator\Generator;
use PeeHaa\PHPComicGenerator\Image;
use PeeHaa\PHPComicGenerator\Type;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidFactory;

class GenerateTest extends TestCase
{
    /** @var Generator */
    private $generator;

    public function setUp()
    {
        $this->generator = new Generator(GENERATED_IMAGE_PATH, new UuidFactory());
    }

    public function testWithOnlyASingleLetterT()
    {
        $comic = $this->generator->generate(new Image(DATA_PATH, new Type(Type::NEUTRAL)), 'T');

        $this->assertSame(sha1_file(ORIGINAL_IMAGE_PATH . '/T.png'), sha1_file($comic->getPath()));

        unlink($comic->getPath());
    }

    public function testWithFooBar()
    {
        $comic = $this->generator->generate(new Image(DATA_PATH, new Type(Type::NEUTRAL)), 'foobarbazqux testing 123');

        $this->assertSame(sha1_file(ORIGINAL_IMAGE_PATH . '/foobar.png'), sha1_file($comic->getPath()));

        unlink($comic->getPath());
    }

    public function testWithLipsum()
    {
        $comic = $this->generator->generate(new Image(DATA_PATH, new Type(Type::NEUTRAL)), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget dictum nisi. Aenean non porta nulla. Morbi pharetra, ante eget malesuada imperdiet, tortor diam vulputate magna, vitae suscipit quam mi ut ex. Maecenas elementum congue dapibus. Sed aliquam mauris pulvinar semper feugiat. Duis consequat dapibus feugiat. Proin luctus suscipit ex in ornare. Suspendisse consectetur varius diam, et condimentum arcu tincidunt non. Nulla facilisi. Morbi a ultricies velit. Phasellus eget neque metus. Praesent condimentum, ipsum sed suscipit mattis, massa sem venenatis justo, sit amet luctus felis sem faucibus dolor. ');

        $this->assertSame(sha1_file(ORIGINAL_IMAGE_PATH . '/lipsum.png'), sha1_file($comic->getPath()));

        unlink($comic->getPath());
    }
}
