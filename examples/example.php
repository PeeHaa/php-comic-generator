<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator\Examples;

use PeeHaa\PHPComicGenerator\Type;
use PeeHaa\PHPComicGenerator\Generator;
use PeeHaa\PHPComicGenerator\Image;
use Ramsey\Uuid\UuidFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$generator = new Generator(__DIR__ . '/../data/output', new UuidFactory());

$generator->generate(new Image(__DIR__ . '/../data', new Type(Type::NEUTRAL)), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget dictum nisi. Aenean non porta nulla. Morbi pharetra, ante eget malesuada imperdiet, tortor diam vulputate magna, vitae suscipit quam mi ut ex. Maecenas elementum congue dapibus. Sed aliquam mauris pulvinar semper feugiat. Duis consequat dapibus feugiat. Proin luctus suscipit ex in ornare. Suspendisse consectetur varius diam, et condimentum arcu tincidunt non. Nulla facilisi. Morbi a ultricies velit. Phasellus eget neque metus. Praesent condimentum, ipsum sed suscipit mattis, massa sem venenatis justo, sit amet luctus felis sem faucibus dolor. ');

$generator->generate(new Image(__DIR__ . '/../data', new Type(Type::NEUTRAL)), 'T');
