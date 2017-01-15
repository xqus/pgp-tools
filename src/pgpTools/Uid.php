<?php

namespace xqus\pgpTools;

/**
 * @author    Audun Larsen <larsen@xqus.com>
 * @copyright Copyright (c) Audun Larsen, 2017
 * @link      https://github.com/xqus/pgp-tools
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

 /**
  * Provides object that represents user IDs.
  */
class Uid {

  private $raw = null;

  /**
   * Create the Uid object and define the raw UID string.
   */
  public function __construct($raw) {
    $this->raw = $raw;
  }

  /**
   * Returns the name of the user ID.
   * @return string
   */
  public function name() {
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

  /**
   * Returns the comment of the user ID.
   * @return string
   */
  public function comment() {
    $start = strpos($this->raw, '(');
    $stop  = strpos($this->raw, ')');

    if($start !== false) {
      return(substr($this->raw, $start+1, $stop-$start-1));
    }

    return false;
  }

  /**
   * Returns the email of the user ID.
   * @return string
   */
  public function email() {
    $start = strpos($this->raw, '<');
    $stop  = strpos($this->raw, '>');

    if($start !== false) {
      return(substr($this->raw, $start+1, $stop-$start-1));
    }

    return false;
  }

}
