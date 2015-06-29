<?php
/**
 * Created by PhpStorm.
 * User: nmeegama
 * Date: 6/29/15
 * Time: 9:51 AM
 */

namespace Box\View\Sessions;


class Sessions  extends \Box\BoxAPI {

    public function createSession($document_id) {
        $attributes = array('document_id' => $document_id);
        $url = $this->service->buildURL("/sessions", 'view');
        $header = array('Content-type' => 'application/json');
        $session_details = $this->service->post($url, $header, json_encode($attributes), 'view');
        if(empty($session_details)) {
            return null;
        }  else {
            return $session_details;
        }

    }
}