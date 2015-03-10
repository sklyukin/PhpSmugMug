<?php
namespace sklyukin\SmugMug\SmugMug;

use sklyukin\PhpSmugMug\SmugMug;

class SmugMugTest extends \PHPUnit_Framework_TestCase
{
    const API_KEY = 'nmskVhkO505MgCblOeMGIBPpOoF9BUPZ';
    const USER_NAME = 'fishska';

    public function testHasKey()
    {
        $smug = new SmugMug(self::API_KEY);
        $this->assertNotNull($smug->apiKey);
    }

    public function testReturnAlbums()
    {
        $smug = new SmugMug(self::API_KEY);
        $response = $smug->userAlbums(self::USER_NAME);
        $this->assertGreaterThan(0, sizeof($response['Album']));
    }

    public function testOneAlbum()
    {
        $smug = new SmugMug(self::API_KEY);
        $response = $smug->userAlbums(self::USER_NAME);
        $uri = $response['Album'][0]['Uri'];
        preg_match('#/api/v2/album/(.+)#', $uri, $matches);
        $albumKey = $matches[1];
        $response = $smug->albumImages($albumKey);
        $this->assertGreaterThan(0, sizeof($response['AlbumImage']));
    }
}