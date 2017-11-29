<?php
defined('_JEXEC') or die;
require dirname(__FILE__) . '/tarifs.class.php';
// Import library dependencies
jimport('joomla.plugin.plugin');

class plgAjaxPlg_tarifs extends JPlugin {
  public function onAjaxPlg_tarifs() {
    $input = JFactory::getApplication()->input;
    $tarifs = new ReflectionClass( 'Tarifs' );
    if ($tarifs->hasMethod( $input->get( 'method' ) )) {
      $method = $tarifs->getMethod( $input->get( 'method' ) );
      return $method->invoke( new Tarifs( $this->params ) );
    } else {
      return false;
    }
  }
}