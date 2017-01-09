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
        $keys[$keyid]['uids'][] = array(
          'uid' => $parts[1],
        );

      }
    }

    return $keys;
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


    /* Convert the array with data to a request string. */
    $query = http_build_query($data);
    /* Set up array with options for the context used by file_get_contents(). */
    $opts = array(
      'http'=>array(
        'method'  => 'GET',
        'timeout' => 2,
        'header'  => "Accept-language: en\r\n" .
                     "User-Agent: whoop\r\n"
      )
    );
    /* Create context. */
    $context = stream_context_create($opts);
    /* Try to get response from key server. */
    $attempts = 0;
    $response = false;
    while($response === false && $attempts < 3) {
      /* select a Yubico API server. */

      $response = @file_get_contents('https://keys.drup.no/pks/lookup'.'?'.$query, null, $context);
      $attempts++;
    }

    return $response;
  }

  function filter() {

  }
}
