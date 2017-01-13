<?php

namespace xqus\pgpTools;

class Lookup {

  function find($search) {
    $keys = array();

    $result = $this->doSearch($search);

    if($result === false) {
      return false;
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


  function all() {

  }

  function doSearch($search) {
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

  function filter() {

  }
}
