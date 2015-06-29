<?php
/**
 * Created by PhpStorm.
 * User: sathukorala
 * Date: 3/19/15
 * Time: 10:26 AM
 */

namespace Box\Content\OAuth;


use Box\BoxAPI;
use Box\BoxHTTPService;

class OAuthService extends \Box\BoxAPI {

  private $clientId;
  private $clientSecret;
  private $redirectURI;
  private $authorizeURI = 'https://api.box.com/oauth2/authorize';
  private $tokenURL = 'https://api.box.com/oauth2/token';
  private $upload_URL = 'https://upload.box.com/api/2.0';

  public function __construct($client_id = '', $client_secret = '', $redirect_uri = '') {
    parent::__construct();
    if (empty($client_id) || empty($client_secret)) {
      drupal_set_message('Invalid CLIENT_ID or CLIENT_SECRET or REDIRECT_URL. Please provide CLIENT_ID, CLIENT_SECRET and REDIRECT_URL when creating an instance of the class.', 'warninig');
    }
    else {
      $this->clientId = $client_id;
      $this->clientSecret = $client_secret;
      $this->redirectURI = $redirect_uri;
    }
  }

  /**
   * @param string $clientId
   */
  public function setClientId($clientId) {
    $this->clientId = $clientId;
  }

  /**
   * @return string
   */
  public function getClientId() {
    return $this->clientId;
  }

  /**
   * @param string $clientSecret
   */
  public function setClientSecret($clientSecret) {
    $this->clientSecret = $clientSecret;
  }

  /**
   * @return string
   */
  public function getClientSecret() {
    return $this->clientSecret;
  }

  /**
   * @param string $redirectURI
   */
  public function setRedirectURI($redirectURI) {
    $this->redirectURI = $redirectURI;
  }

  /**
   * @return string
   */
  public function getRedirectURI() {
    return $this->redirectURI;
  }

  /* First step for authentication [Gets the code] */
  public function getCode() {
    if (array_key_exists('refresh_token', $_REQUEST)) {
      BoxHTTPService::setRefreshToken($_REQUEST['refresh_token']);
    }
    else {
      $url = $this->authorizeURI . '?' . http_build_query(array(
          'response_type' => 'code',
          'client_id' => $this->clientId,
          'redirect_uri' => $this->redirectURI
        ));
      drupal_goto($url);

    }
  }

  /* Second step for authentication [Gets the access_token and the refresh_token] */
  public function getTokens($code = NULL) {
    $url = $this->tokenURL;
    $refreshToken = BoxHTTPService::getRefreshToken();
    if (!empty($refreshToken)) {
      $params = array(
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken,
        'client_id' => $this->clientId,
        'client_secret' => $this->clientSecret
      );
    }
    else {
      $params = array(
        'grant_type' => 'authorization_code',
        'code' => $code,
        'client_id' => $this->clientId,
        'client_secret' => $this->clientSecret
      );
    }
    $response = $this->service->post($url, array(), $params, 'oauth');
    $this->setRequestTokens($response['access_token'], $response['refresh_token']);
    return $response;
  }


  /**
   * A function to Check if the access token is expired
   */
  public function isExpired($expires_in, $timestamp) {
    $ctimestamp = time(); //current time stamp

    if (($ctimestamp - $timestamp) >= $expires_in) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  public function setRequestTokens($accessToken, $refreshToken) {
    BoxHTTPService::$accessToken = $accessToken;
    BoxHTTPService::$refreshToken = $refreshToken;
  }

}