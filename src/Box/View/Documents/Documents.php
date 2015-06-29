<?php
/**
 * Created by PhpStorm.
 * User: sathukorala
 * Date: 6/23/15
 * Time: 4:22 PM
 */

namespace Box\View\Documents;


use Box\BoxHTTPService;

class Documents extends \Box\BoxAPI {

  /*
   * Send The Temporary Download URL to the View API
   */
  public function URLUpload($downloadURL) {
    $attributes = array('url' => $downloadURL);
    $url = $this->service->buildURL("/documents", 'view');
    $header = array('Content-type' => 'application/json');
    $document_details =  $this->service->post($url, $header, json_encode($attributes), 'view');
    return $document_details;


  }

}