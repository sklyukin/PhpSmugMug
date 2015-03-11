[![Build Status](https://travis-ci.org/sklyukin/PhpSmugMug.svg?branch=master)](https://travis-ci.org/sklyukin/PhpSmugMug)
# PhpSmugMug
PHP library for SmugMug API v2.0

#Installing
`composer.phar require sklyukin/php_smugmug`

#Example
```php
$smug = new SmugMug('YOUR_API_KEY');
$albumsResponse = $smug->userAlbums($username);
$albums = $albumsResponse['Album'];
```

#Methods available
* userAlbums
* albumImages
* album
