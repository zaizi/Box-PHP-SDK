<?php
/**
 * Created by PhpStorm.
 * User: sathukorala
 * Date: 4/9/15
 * Time: 9:49 AM
 */

namespace Box\Content\Files;

use Box\BoxHTTPService;

class Files extends \Box\BoxAPI {

    /**
     * @param $file
     * @return array|bool|float|int|string
     * Get details (Metadata) of a file
     */
  public function getFileDetals($file) {
    $url = $this->service->buildURL("/files/$file");
    return $this->service->get($url);
  }

    /**
     * @param $file
     * @param $params
     * @return array|bool|float|int|string
     * Update a file
     */
  public function updateFile($file, $params) {
    $url = $this->service->buildURL("/files/$file");
    return $this->service->put($url, array(), json_encode($params));
  }

    /**
     * @param $file
     * @return array|bool|float|int|string
     * Delete a file
     */
  public function deleteFile($file) {
    $url = $this->service->buildURL("/files/$file");
    return $this->service->delete($url);
  }

    /**
     * @param $path
     * @param $parentId
     * @return array|bool|float|int|string
     * Function to upload files
     */
  public function uploadFile($path, $parentId) {
    $url = $this->service->buildURL("/files/content", TRUE);
    $params = array('attributes' => json_encode(array('name'=>drupal_basename($path), 'parent'=> array('id'=> $parentId))), 'file' => '@'.$path);
    return $this->service->post($url, array(), $params);
  }

    /* Get Information About a File */
    public function getFileInfo($file)
    {
        $url = $this->service->buildURL("/files/$file/content");
        return $this->service->get($url,array(), FALSE, FALSE);
    }
}