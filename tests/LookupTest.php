<?php

use PHPUnit\Framework\TestCase;
use xqus\pgpTools\Lookup;


class LookupTest extends TestCase {


    public function testKeyLookup()
    {
        // Arrange
        $lookup = new Lookup();

        $key = $lookup->find('0xEAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80');

        $this->assertTrue(isset($key['0xD775F42569CDDB80']));

        $this->assertEquals($key['0xD775F42569CDDB80']['fingerprint'], 'EAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80');

        $this->assertFalse($lookup->find('0xnonexistingkey'));

    }


}
