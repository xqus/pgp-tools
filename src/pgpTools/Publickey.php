<?php

namespace xqus\pgpTools;

class Publickey {

  var $fingerprint = null;
  var $keylen      = null;
  var $created     = null;
  var $expires     = null;
  var $uids        = null;

  function __construct($key) {
    foreach($key as $k => $v) {
      if(!empty($this->$k)) {
        throw new \Exception($k .' is not allowed as a key in public key array');
      } else {
        $this->$k = $v;
      }
    }

    $this->setUids($this->uids);
  }

  function setUids($uids) {
    $this->uids = array();
    foreach($uids as $uid) {
      $this->uids[] = new Uid($uid);
    }
  }

  function uids() {

  }



}
