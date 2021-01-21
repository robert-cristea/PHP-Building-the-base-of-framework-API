<?php

    //autoload function
    spl_autoload_register(function($class_name){
        require_once APPROOT."/libraries/".$class_name.".php";
    });
  //Require libraries from folder libraries
//  require_once 'libraries/Core.php';
  require_once 'libraries/Database.php';
  require_once 'libraries/Controller.php';

  require_once 'models/Session.php';

  require_once 'config/config.php';

  //Instantiate core class
  $init = new Core();