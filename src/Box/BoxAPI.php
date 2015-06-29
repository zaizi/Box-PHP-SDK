<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nmeegama
 * Date: 3/26/15
 * Time: 11:58 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Box;


class BoxAPI {
  protected $service;

  /**
   * @param \Box\BoxHTTPService $service
   */
  public function setService($service) {
    $this->service = $service;
  }

  /**
   * @return \Box\BoxHTTPService
   */
  public function getService() {
    return $this->service;
  }

  public function __construct() {
    $this->service = new \Box\BoxHTTPService();
  }
}