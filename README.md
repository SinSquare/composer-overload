A simple tool that is used to "overload" classes.

A simple example:

Lets say you have the following code

```php
use Random\Namespace\OriginalClass;

...

$class = new OriginalClass();
```
In this case composer will search the file, and load(include) it. But there might be a case when you want to load a dummy class instead of the original class, so your tests run for example.

To do it you have to use the ComposerOverload autoloader. 
Replace the original autoloader.

```php
//original autoloader
$loader = require __DIR__.'/vendor/autoload.php';

//ComposerAutoloader autoloader
require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/vendor/sinsquare/composer-overload/autoload_real.php';
$loader = ComposerOverLoaderInit::getLoader();
```

Then you can add the classes you want to overload

```php
//original autoloader
$loader->addOverloadedClass('Random\Namespace\OriginalClass', __DIR__.'/overloaded/OverloadedClass.php');
```

To run the tests you have to run the two tests separately
* vendor/bin/phpunit tests/OriginalTest.php 
* vendor/bin/phpunit tests/OverloadTest.php