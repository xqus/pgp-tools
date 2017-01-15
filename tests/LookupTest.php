<?php

use PHPUnit\Framework\TestCase;
use xqus\pgpTools\Lookup;


class LookupTest extends TestCase {

  public function testKeyLookup() {
    $lookup = new Lookup();
    $key = $lookup->find('0xEAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80');

    $this->assertTrue(isset($key[0]));

    $this->assertEquals($key[0]->fingerprint, 'EAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80');

    $this->assertEquals($key[0]->uids[0]->raw, 'Audun Larsen <xqus@drup.no>');

    $this->assertEquals(0, sizeof($lookup->find('0xnonexistingkey')));

    }

    public function testUid() {
      $lookup = new Lookup();
      $key = $lookup->find('0xEAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80');

      $this->assertEquals($key[0]->uids[0]->name(), 'Audun Larsen');
      $this->assertFalse($key[0]->uids[0]->comment());
      $this->assertEquals($key[0]->uids[0]->email(), 'xqus@drup.no');

      $this->assertEquals($key[0]->uids[2]->name(), 'Audun Larsen');
      $this->assertEquals($key[0]->uids[2]->comment(), 'Born 1984-08-12 in Bergen, Norway');
      $this->assertFalse($key[0]->uids[2]->email());

    }


}
