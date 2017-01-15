<?php

namespace xqus\pgpTools;

/**
 * @author    Audun Larsen <larsen@xqus.com>
 * @copyright Copyright (c) Audun Larsen, 2017
 * @link      https://github.com/xqus/pgp-tools
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Provides object that represents public keys.
 */
class Publickey {

  public $fingerprint = null;
  public $keylen      = null;
  public $created     = null;
  public $expires     = null;
  public $uids        = null;

  /**
   * Parse an array containging key-data and create the Publickey object.
   *
   * @param array $key
   *   Array containing key data.
   *   array(
   *     'fingerprint' => 'Key fingerprint',
   *     'keylen'      => 'Key length',
   *     'created'     => 'UNIX timestamp for key creation date',
   *     'expires'     => 'UNIX timestamp for key expire date',
   *     'uids'        => array( // Key user ids
   *                        'Name (comment) <email>'
   *                      ),
   *   )
   *
   * @return void
   */
  public function __construct($key) {
    foreach($key as $k => $v) {
      if(!empty($this->$k)) {
        throw new \Exception($k .' is not allowed as a key in public key array');
      } else {
        $this->$k = $v;
      }
    }

    $this->setUids($this->uids);
  }

  /**
   * Loop trough the raw user IDs and convert to a Uid object.
   *
   * @param array $uids
   * @return void
   */
  private function setUids($uids) {
    $this->uids = array();
    foreach($uids as $uid) {
      $this->uids[] = new Uid($uid);
    }
  }
}
