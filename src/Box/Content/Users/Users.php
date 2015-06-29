<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nmeegama
 * Date: 3/25/15
 * Time: 5:15 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Box\Content\Users;


class Users extends \Box\BoxAPI {
  /* Gets the current user details */
  public function getUser() {
    $url = $this->service->buildURL('/users/me');
    return $this->service->get($url);
  }

}