<?php
/**
 * Created by PhpStorm.
 * User: sathukorala
 * Date: 4/1/15
 * Time: 11:41 AM
 */

namespace Box\Content\Folders;


class Folders extends \Box\BoxAPI {

  /* Get the list of items in the mentioned folder */
  public function getFolderItems($folder) {
    $url = $this->service->buildURL("/folders/$folder/items");
    return $this->service->get($url);
  }

  /* Create new folder */
  public function createFolder($name, $parent_id) {
    $url = $this->service->buildUrl("/folders");
    $params = array('name' => $name, 'parent' => array('id' => $parent_id));
    return $this->service->post($url, array(), json_encode($params));
  }

  /* Get the details of the mentioned folder */
  public function getFolderDetails($folder) {
    $url = $this->service->buildURL("/folders/$folder");
    return $this->service->get($url);
  }

  /* Modifies the folder details as per the api */
  public function updateFolder($folder, $params) {
    $url = $this->service->buildURL("/folders/$folder");
    //return json_decode($this->put($url, $params), true);//
    return $this->service->put($url, array(), json_encode($params));
  }

  /* Deletes a folder */
  public function deleteFolder($folder, array $opts) {
    $url = $this->service->buildUrl("/folders/$folder", FALSE, $opts);
    return $this->service->delete($url, array(), $opts);
  }

  /* Copy a Folder - Used to create a copy of a folder in another folder.
  *  $destination - destination folder id
  */
  public function copyFolder($folder, $destination) {
    $url = $this->service->buildURL("/folders/$folder/copy");
    $params = array('parent' => array('id' => $destination));
    return $this->service->post($url, array(), json_encode($params));
  }

  /*
   * Create a Shared Link for a Folder
   */
  public function sharedLinkFolder($folder) {
    $url = $this->service->buildURL("/folders/$folder");
    $params = array('shared_link' => array('access' => 'open'));
    return $this->service->put($url, array(), json_encode($params));
  }

  /*
   * Get the list of collaborators in the mentioned folder
   */
  public function folderCollaborations($folder) {
    $url = $this->service->buildURL("/folders/$folder/collaborations");
    return $this->service->get($url);
  }

  /*
   * Get the Items in the Trash
   */
  public function getTrashItems($limit, $offset) {
    $params = array('limit' => $limit, 'offset' => $offset);
    $url = $this->service->buildURL("/folders/trash/items", FALSE, $params);
    return $this->service->get($url);
  }

  /*
   * Get a Trashed Folder - Retrieves an item that has been moved to the trash.
   */
  public function getTrashFolder($folder) {
    $url = $this->service->buildURL("/folders/$folder/trash");
    return $this->service->get($url);
  }

  /*
   * Permanently Delete a Trashed Folder
   */
  public function deleteTrashItem($folder) {
    $url = $this->service->buildURL("/folders/$folder/trash");
    return $this->service->delete($url);

  }

  /*
   * Restore a Trashed Folder
   */
  public function restoreTrashFolder($folder, $params) {
    $url = $this->service->buildURL("/folders/$folder");
    return $this->service->post($url, array(), json_encode($params));
  }


}
