<?php

use PHPUnit\Framework\TestCase;
use xqus\pgpTools\Publickey;
use xqus\pgpTools\Uid;

class PublickeyTest extends TestCase {
  public function testPublicKey() {
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
    $this->assertEquals('EAB9F9186C7FE39EEBA3BAA8D775F42569CDDB80', $pub->fingerprint);
    $this->assertEquals('2048', $pub->keylen);
    $this->assertEquals('1484471359', $pub->created);
    $this->assertEquals('1565568000', $pub->expires);

    foreach($pub->uids as $uid) {
      $this->assertInstanceOf(Uid::class, $uid);
    }

  }

}
