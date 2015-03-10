<?php
namespace sklyukin\SmugMug\SmugMug;

use sklyukin\PhpSmugMug\SmugMug;

class SmugMugTest extends \PHPUnit_Framework_TestCase
{
    const API_KEY = 'nmskVhkO505MgCblOeMGIBPpOoF9BUPZ';

    public function testHasKey()
    {
        $smug = new SmugMug(self::API_KEY);
        $this->assertNotNull($smug->apiKey);
    }

    public function testReturnAlbums()
    {
        $smug = new SmugMug(self::API_KEY);
        $response = $smug->albums('fishska');
        $this->assertGreaterThan(0, sizeof($response['Album']));
    }
}