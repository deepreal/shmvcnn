<?php
$time_start = microtime(true);
define(BASE_PATH,rtrim(str_replace("\\", "/", dirname(__FILE__)), "/").'/');
define(APP_PATH,BASE_PATH."app/");
define(VIEW_PATH,APP_PATH."views/");
define(SYS_PATH,BASE_PATH."system/");
define(APP_NAME,'shmvcnn');
define(PUBLIC_PATH,BASE_PATH."public/");
define(SUB_FOLDER,'shframeworknn/');
define(ROOT,"/".SUB_FOLDER);
define(PL,"/".SUB_FOLDER.'public/');
define(ORTAM,'test'); 
echo PUBLIC_PATH;
require_once SYS_PATH.'core/start.php';