<?php

use PHPUnit\Framework\TestCase;
use xqus\pgpTools\Lookup;


class LookupTest extends TestCase {

  public function testNonexistingKey() {
    $lookup = new Lookup();

    $this->assertEquals(0, sizeof($lookup->find('0xnonexistingkey')));
  }

  public function testSingleKeyLookup() {
    $lookup = new Lookup();
    $key = $lookup->find('0xEAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80');

    $this->assertTrue(isset($key[0])) ;

    $this->assertEquals('EAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80', $key[0]->fingerprint);
    $this->assertEquals('2048', $key[0]->keylen);
    $this->assertEquals('1477243182', $key[0]->created);
    $this->assertEquals('1513780678', $key[0]->expires);
    $this->assertEquals($key[0]->uids[0]->name(), 'Audun Larsen');


    }

    public function testMultipleKeyLookup() {
      $lookup = new Lookup();
      $key = $lookup->find('xqus@drup.no');

      $this->assertEquals(2, sizeof($key)) ;

      $this->assertEquals('EAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80', $key[0]->fingerprint);
      $this->assertEquals('9900AFE6933192998EF43C54F979D7A7B17233A1', $key[1]->fingerprint);
    }
}
