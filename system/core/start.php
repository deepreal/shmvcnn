<?php
if(!isset($_SESSION)){session_start();}
require_once SYS_PATH.'core/shmvc_functions.php';
require_once SYS_PATH.'core/shmvc_class.php';
require_once SYS_PATH.'core/model_class.php';
require_once SYS_PATH.'core/view_class.php';
require_once SYS_PATH.'core/controller_class.php';
require_once SYS_PATH.'core/router_class.php';
require_once SYS_PATH.'core/cache_class.php';
require_once SYS_PATH.'core/dbconnection_class.php';
require_once SYS_PATH.'core/auth_class.php';
require_once SYS_PATH.'core/auto_loader.php';

$SHMVC = new SHMVC();

$Router = new SHMVC_Router(shmvc_load_config('routes','routes'),shmvc_load_config('config','app_languages'));
$Router->go();

echo '<div style="padding:20px; background-color:#dedede">Total execution time in seconds: ' . (microtime(true) - $time_start)."</div>";



