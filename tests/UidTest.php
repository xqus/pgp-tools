<?php

use PHPUnit\Framework\TestCase;
use xqus\pgpTools\Publickey;
use xqus\pgpTools\Uid;

class UidTest extends TestCase {
  public function testUid() {
    $key = array(
      'fingerprint' => 'EAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80',
      'keylen'      => '2048',
      'created'     => '1484471359',
      'expires'     => '1565568000',
      'uids'        => array(
        'Audun Larsen (author) <larsen@xqus.com>',
        'Audun Larsen <larsen@xqus.com>',
        'Audun Larsen (author)',
      ),
    );

    $pub = new Publickey($key);

    $this->assertInstanceOf(Publickey::class, $pub);

    foreach($pub->uids as $uid) {
      $this->assertInstanceOf(Uid::class, $uid);
    }

    $this->assertEquals('Audun Larsen', $pub->uids[0]->name());
    $this->assertEquals('author', $pub->uids[0]->comment());
    $this->assertEquals('larsen@xqus.com', $pub->uids[0]->email());

    $this->assertEquals('Audun Larsen', $pub->uids[1]->name());
    $this->assertFalse($pub->uids[1]->comment());
    $this->assertEquals('larsen@xqus.com', $pub->uids[1]->email());

    $this->assertEquals('Audun Larsen', $pub->uids[2]->name());
    $this->assertEquals('author', $pub->uids[2]->comment());
    $this->assertFalse($pub->uids[2]->email());

  }

}
