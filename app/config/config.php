<?php
  //APPROOT
  define('APPROOT', dirname(dirname(__FILE__)));
  echo APPROOT;

  $ini = parse_ini_file(APPROOT."/app.ini");
  

  //URLROOT (Dynamic Links)
  define('URLROOT', 'http://localhost/kf6012');

  //Sitename
  define('SITENAME', 'MyUniCourseWork');

  //Database params
  define('DB_USER', $ini['db_user']);
  define('DB_PASS', $ini['db_password']);
  define('DB_NAME', APPROOT.'/'.$ini['db_name']);
