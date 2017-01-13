<?php

namespace xqus\pgpTools;

class Uid {

  var $raw = null;

  function __construct(string $raw) {
    $this->raw = $raw;
  }

  function name() {
    $pos = strpos($this->raw, '(');
    if($pos === false) {
      $pos = strpos($this->raw, '<');
    }

    if($pos === false) {
      return false;
    }

    $pos--;

    return(substr($this->raw, 0, $pos));
  }

  function comment() {
    $start = strpos($this->raw, '(');
    $stop  = strpos($this->raw, ')');

    if($start !== false) {
      return(substr($this->raw, $start+1, $stop-$start-1));
    }

    return false;
  }

  function email() {
    $start = strpos($this->raw, '<');
    $stop  = strpos($this->raw, '>');

    if($start !== false) {
      return(substr($this->raw, $start+1, $stop-$start-1));
    }

    return false;
  }

}
