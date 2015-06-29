<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nmeegama
 * Date: 3/26/15
 * Time: 10:15 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Box;


class BoxHTTPService {
  private $client;
  private $apiURL = 'https://api.box.com/2.0';
  public static $accessToken;
  public static $refreshToken;
  private $uploadURL = 'https://upload.box.com/api/2.0';
  public static $viewAPIKey;
  private $viewAPIURL = 'https://view-api.box.com/1';

  /**
   * @param string $apiURL
   */
  public function setApiURL($apiURL) {
    $this->apiURL = $apiURL;
  }

  /**
   * @return string
   */
  public function getApiURL() {
    return $this->apiURL;
  }

  /**
   * @param mixed $accessToken
   */
  public static function setAccessToken($accessToken) {
    self::$accessToken = $accessToken;
  }

  /**
   * @return mixed
   */
  public static function getAccessToken() {
    return self::$accessToken;
  }

  /**
   * @param mixed $refreshToken
   */
  public static function setRefreshToken($refreshToken) {
    self::$refreshToken = $refreshToken;
  }

  /**
   * @return mixed
   */
  public static function getRefreshToken() {
    return self::$refreshToken;
  }


  /**
   * @param \Guzzle\Http\Client $client
   */
  public function setClient($client) {
    $this->client = $client;
  }

  /**
   * @return \Guzzle\Http\Client
   */
  public function getClient() {
    return $this->client;
  }

  public function __construct() {
    $this->client = new \Guzzle\Http\Client();
  }

  public function post($url, $headers = array(), $params = array(), $call_type = 'content') {
    if($call_type == 'content') {
      $headers = $this->addAccessTokenHeader($headers);
    }else if($call_type == 'view') {
      $headers =$this->addViewAPIHeader($headers);
    }
    $response = $this->client->post($url, $headers, $params)->send();
    return $response->json();

  }

  public function get($url, $headers = array(), $is_oauth = FALSE, $json = TRUE ) {
    if(!$is_oauth) {
      $headers = $this->addAccessTokenHeader($headers);
    }
    $response = $this->client->get($url, $headers)->send();

    if($json) {
      return $response->json();
    } else {
      return $response;
    }
  }

  public function put($url, $headers = array(), $params = array(), $is_oauth = FALSE) {
    if(!$is_oauth) {
      $headers = $this->addAccessTokenHeader($headers);
    }
    $response = $this->client->put($url, $headers, $params)->send();
    return $response->json();
  }

  public function delete($url, $headers = array(), $params = array(), $is_oauth = FALSE) {
    if(!$is_oauth) {
      $headers = $this->addAccessTokenHeader($headers);
    }
    $response = $this->client->delete($url, $headers, $params)->send();
    return $response->json();
  }

  /* Builds the URL for the call */
  public function buildURL($api_func, $api_type = 'content', array $params = array()) {
    if($api_type == 'content'){
      $base = $this->apiURL . $api_func;
    } else if($api_type == 'upload') {
      $base = $this->uploadURL . $api_func;
    } else {
      $base = $this->viewAPIURL . $api_func;
    }
    if(!empty($params)) {
      $query_string = http_build_query($params);
      $base = $base . '?' . $query_string;
    }
    return $base;
  }

  /* Build the url for the upload  */
  public function buildUploadURL($api_func, array $params = array()) {
    $base = $this->uploadURL . $api_func . '?';
    $query_string = http_build_query($params);
    $base = $base . $query_string;
    return $base;
  }

  /* Sets the required before biulding the query */
  private function addAccessTokenHeader(array $headers) {
    if (!array_key_exists('Authorization', $headers)) {
      $headers['Authorization'] = "Bearer ".self::$accessToken;
    }
    return $headers;
  }

  /* Sets the View api key to header */
  private function addViewAPIHeader(array $headers) {
    if (!array_key_exists('Authorization', $headers)) {
      $headers['Authorization'] = "Token ".self::$viewAPIKey;
    }
    return $headers;
  }




}