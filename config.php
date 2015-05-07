<?php
// Database config
define('DB_HOST', 'localhost');
define('DB_NAME', 'api_db');
define('DB_USER', 'api_user');
define('DB_PASS', 'password');
define('PASSPHRASE', 'were#all#mad#here');

include('database.php');
include('security.php');
include('constructor.php');

$dbfun = new get_api();
?>
