<?php

/**
 * Library for making curl Requests
 *
 * @todo More robust error management
 */
class CurlJson {


  /**
   * GET from json endpoint using cURL
   *
   * Send get request and convert the resulting json data into php object
   *
   * @param string $endpoint    The URL that is being requested
   * @param mixed $queryData   The query data that is sent
   *
   * @return object             Response from sent request or empty object if
   *                            something fails
   */
  public function get($endpoint, $queryData = false) {
    $queryString = $queryData ? '?' . http_build_query($queryData) : '';
    $url = $endpoint . $queryString; // http://foo.com?fizz=buzz
    // Initialise a new curl session
    $ch = curl_init();

    // Set request options
    curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => 1,  // Return response instead of echoing
      CURLOPT_URL => $url,          // Set url
      CURLOPT_FAILONERROR => true,  // Error with HTTP Error codes
    ));

    // Send request
    $resp = curl_exec($ch);

    // Check for errors
    $err = $this->handleRequestError($ch);

    // Clean up
    curl_close($ch);

    return $err ? (object)[] : json_decode($resp);
  }


  /**
   * POST to json endpoint using cURL
   *
   * Send post request with json data, get json data back and convert it to
   * an object
   *
   * @param string $url   The URL that is being requested
   * @param mixed $data   The post data that is sent
   *
   * @return object       Response from sent request or empty object if
   *                      something fails
   */
  public function post($endpoint, $postData = []) {
    $json = json_encode($postData);

    // Initialise a new curl session
    $ch = curl_init();

    // Set request options
    curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => 1,  // Return response instead of echoing
      CURLOPT_URL => $endpoint,     // Set url
      CURLOPT_POST => 1,            // Make POST request
      CURLOPT_POSTFIELDS => $json,  // Set data sent
      CURLOPT_FAILONERROR => true,  // Error with HTTP Error codes
    ));

    // Send request
    $resp = curl_exec($ch);

    // Check for errors
    $err = $this->handleRequestError($ch);

    // Clean up
    curl_close($ch);

    return $err ? $err : json_decode($resp);
  }


  /**
   * Handle the errors that a request could create
   *
   * @param object $ch    Curl Handle
   *
   * @return string|bool  The error message or false if no error found
   */
  private function handleRequestError($ch) {
    return curl_error($ch) ? curl_error($ch) : false;
  }
}
