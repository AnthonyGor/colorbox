<?php
/* $Id: nc_cache_listener.class.php 2330 2008-10-15 16:33:02Z vadim $ */

class nc_cache_listener {

  private $examineObj;

  /**
   * Protected constructor, calling once
   *
   */
  protected function __construct () {
    
    $this->examineObj = array();
    
    $this->addExamine( nc_cache_browse::getObject() );
    $this->addExamine( nc_cache_full::getObject() );
    $this->addExamine( nc_cache_list::getObject() );
    $this->addExamine( nc_cache_function::getObject() );
    $this->addExamine( nc_cache_calendar::getObject() );
   
  }

  /**
   * Get or instance self object
   *
   * @return self object
   */
  public static function getObject () {
    // call as static
    static $storage;
    // check inited object
    if ( !isset($storage) ) {
      // init object
      $storage = new self();
    }    
    // return object
    return is_object($storage) ? $storage : false;
  }
  
  /**
   * Add object to listen mode
   *
   */
  private function addExamine (nc_cache $object) {
    // add object in array
    if ( !in_array($object, $this->examineObj) ) {
      $this->examineObj[] = $object;
    }
    return;
  }
  
  /**
   * Event processor
   * call objects function for current event
   * 
   * dropCatalogue arguments($catalogue)
   * dropSubdivision arguments($catalogue, $subdivision)
   * dropSubClass arguments($catalogue, $subdivision, $subclass)
   * dropClass arguments($class)
   * dropMessages arguments($class, $mesage)
   *
   */
  public function event () {
    // get function args
    $args = func_get_args();
    // check args
    if ( empty($args) ) return false;
    // event value if not setted
    $event = array_shift($args);
    // call objects functions
    foreach ($this->examineObj AS $object) {
      if ( isset($object->listenTable[$event]) ) {
        eval("call_user_func( ".$object->listenTable[$event]." );");
      }
    }
    return;
  }
  
}

?>