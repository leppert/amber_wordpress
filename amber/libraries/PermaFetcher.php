<?php

include_once dirname( __FILE__ ) . '/AmberFetcher.php';

class PermaFetcher implements iAmberFetcher {

  /**
   * @param $storage AmberStorage that will be used to save the item
   */
  function __construct(array $options) {
    $this->apiKey = $options['perma_api_key'];
  }

  /**
   * Fetch the URL and associated assets and pass it on to the designated Storage service
   * @param $url
   * @return
   */
	public function fetch($url) {
    $api_endpoint = 'http://api.perma.dev:8000/v1/archives/';
    $data = array('url' => $url);

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Authorization: ApiKey " . $this->apiKey . "\r\n" .
                     "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($api_endpoint, false, $context);

    return json_decode($result, true);
	}

}