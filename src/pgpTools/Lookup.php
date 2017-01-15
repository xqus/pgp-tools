<?php

namespace xqus\pgpTools;

/**
 * @author    Audun Larsen <larsen@xqus.com>
 * @copyright Copyright (c) Audun Larsen, 2017
 * @link      https://github.com/xqus/pgp-tools
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Provides interface against SKS-Keyservers.
 */
class Lookup {

  /**
   * Find a key on the SKS-Keyservers.
   *
   * @param string $search
   *   String to search for, can be email, name, keyid or fingerprint.
   *
   * @return array
   *  Returns an array containing xqus\pgpTools\Publickey objects
   */
  public function find($search) {
    $keys = array();

    $result = $this->doSearch($search);

    if($result === false) {
      return array();
    }

    foreach(preg_split("/((\r?\n)|(\r\n?))/", $result) as $line) {
      $parts = explode(':', $line);
      if($parts[0] == 'pub') {
        $keyid = '0x'.substr($parts[1], -16);
        $keys[$keyid] = array(
          'fingerprint' => $parts[1],
          'keylen'      => $parts[3],
          'created'     => $parts[4],
          'expires'     => $parts[5],
          'uids'        => array(),
        );
      } elseif($parts[0] == 'uid') {
        $keys[$keyid]['uids'][] = $parts[1];
      }
    }

    foreach($keys as $key) {
      $keyObj[] = new Publickey($key);
    }

    return $keyObj;
  }

  /**
   * Connect to SKS-Keyservers and search for a key. Returns raw response from
   * the keyserver.
   *
   * @param string $search
   *
   * @return string
   */
  private function doSearch($search) {
    $data = array(
      'op'          => 'vindex',
      'options'     => 'mr',
      'search'      => $search,
      'fingerprint' => 'on',
      'hash'        => 'on',

    );

    $client = new \GuzzleHttp\Client();

    try {
      $r = $client->request('GET', 'https://hkps.pool.sks-keyservers.net/pks/lookup', [
        'verify' => __DIR__.'/../../sks-keyservers.netCA.pem',
        'query' => $data,
      ]);
    } catch(\GuzzleHttp\Exception\ServerException $e) {
      return false;
    }

    $response = $r->getBody();

    return (string) $response;
  }

}
