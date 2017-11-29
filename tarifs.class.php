<?php
defined('_JEXEC') or die;

class Tarifs {
  protected $db = '#__ortana_articles';
  protected $user;
  public $fields;
  public $app;
  public function __construct( $params ) {
    $this->fields = &$params;
    $this->app = JFactory::getApplication();
    $this->user = JFactory::getUser();
  }
  
  /**
   * Afficher tous les articles dans la base de donnée
   * @return {object} Liste de tous les articles
   */
  public function selectAll(){
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('title', 'id', 'description', 'cost', 'fields')))
          ->from($db->quoteName($this->db));
    $db->setQuery($query);
    return $db->loadObjectList();
  }

  /**
   * Ajouter une article dans la base de donnée
   * @return {object} 
   */
  public function insert() {
    if ( ! $this->user->get( "isRoot" )) 
      return (object)['success' => false, 'msg' => 'You don\'t have permission'];
    $input = $this->app->input;
    $title = $input->getString( 'title', '', 'STRING' );
    $cost = $input->get( 'cost' );
    $desc = $input->getString( 'desc', '', 'STRING' );
    $profile = new stdClass();
    $profile->title = $title;
    $profile->description = $desc;
    $profile->cost = $cost;

    $result = JFactory::getDbo()->insertObject($this->db, $profile);
    return $result;
  }

  /**
   * Mettre à jour la colonne `fields` dans la base de donnée
   * @return {object}
   */
  public function updateFields() {
    $input = $this->app->input;
    $object = new stdClass();

    $object->id = $input->getInt('id');
    $object->fields = $input->getString('fields', '', 'STRING');
    // Update their details in the users table using id as the primary key.
    $result = JFactory::getDbo()->updateObject($this->db, $object, 'id');
    return $result;
  }

  /**
   * Mise à jours de l'article (e.g cost, description and title)
   * @return {object}
   */
  public function updateTarifs() {
    $input = $this->app->input;
    $object = new stdClass();

    $object->id = $input->getInt('id');
    $object->title = $input->getString('title', '', 'STRING');
    $object->description = $input->getString('description', '', 'STRING');
    $object->cost = $input->getInt('cost');
    // Update their details in the users table using id as the primary key.
    $result = JFactory::getDbo()->updateObject($this->db, $object, 'id');
    return $result;
  }
  
  /**
   * Effacer une article dans la base de donnée
   * @return {object}
   */
  public function delete() {
    if ( ! $this->user->get( "isRoot" )) 
      return (object)['success' => false, 'msg' => 'You don\'t have permission'];
    $input = $this->app->input;
    $id = $input->get( 'id' );

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    
    // delete all custom keys for user 1001.
    $conditions = array($db->quoteName( 'id' ) . ' = ' . (int)$id);
    
    $query->delete($db->quoteName($this->db));
    $query->where($conditions);
    $db->setQuery($query);
    return $result = $db->execute();
  }

  public function getmail() {
    return $this->fields['ortana_mail'];
  }

}