<?php

$DOCUMENT_ROOT = rtrim( getenv("DOCUMENT_ROOT"), "/\\" );
$HTTP_HOST = getenv("HTTP_HOST");

# подпапка в которой стоит NetCat
$SUB_FOLDER ='';
# Если NetCat стоит в подпапке, то раскомментируйте следующую строчку
#$SUB_FOLDER = str_replace( str_replace("\\", "/", $DOCUMENT_ROOT), "", str_replace("\\", "/", dirname(__FILE__)) );

# установка переменных окружения

error_reporting(E_ALL^E_NOTICE); 
@ini_set("register_globals","1"); 
@ini_set("magic_quotes_gpc","1"); 
@ini_set("session.auto_start","0"); 

@ini_set("session.use_trans_sid","0"); 
@ini_set("session.use_cookies","1"); 
@ini_set("session.use_only_cookies","1"); 
@ini_set("url_rewriter.tags", ''); // to disable trans_sid on PHP < 5.0 
if ($HTTP_HOST!="localhost") @ini_set("session.cookie_domain", str_replace("www.", "", $HTTP_HOST)); 

@ini_set("session.gc_probability", "1");
@ini_set("session.gc_maxlifetime", "1800");
@ini_set("session.hash_bits_per_character", "5");
@ini_set("mbstring.internal_encoding", "UTF-8");
@ini_set("default_charset", "UTF-8");
@ini_set("session.name", ini_get("session.hash_bits_per_character")>=5 ? "sid" : "ced");

# параметры доступа к базе данных

$MYSQL_HOST = "localhost";
$MYSQL_USER = "bg2";
$MYSQL_PASSWORD = "P1k5M6g3";
$MYSQL_DB_NAME = "bg2";
$MYSQL_CHARSET = "utf8";

$MYSQL_HOST = "78.108.81.240";
$MYSQL_USER = "u19933";
$MYSQL_PASSWORD = "egjer95y7";//6eQb4yTQ";
$MYSQL_DB_NAME = "b19933";
$MYSQL_CHARSET = "utf8";


$MYSQL_HOST = "localhost";
$MYSQL_USER = "boxcolor";
$MYSQL_DB_NAME = "boxcolor";
$MYSQL_CHARSET = "utf8";
$MYSQL_PASSWORD = "os16LX06";

/*$MYSQL_HOST = "localhost";
$MYSQL_USER = "box2";
$MYSQL_DB_NAME = "box2";
$MYSQL_CHARSET = "cp1251";
$MYSQL_PASSWORD = "123456";*/

# кодировка
$NC_UNICODE = 1;
$NC_CHARSET = "utf-8";

# настройки авторизации

$AUTHORIZE_BY = "Login";
$AUTHORIZATION_TYPE = "cookie"; # 'http', 'session' or 'cookie'

# серверные настройки

$PHP_TYPE = "module"; # 'module' or 'cgi'
$REDIRECT_STATUS = "on"; # 'on' or 'off'

# security
$SECURITY_XSS_CLEAN = false;

$ADMIN_LANGUAGE = "Russian"; # Язык административной части NetCat "по-умолчанию"
$FILECHMOD = 0644; # Права на файл при добавлении через систему
$DIRCHMOD = 0755; # Права на директории для закачки пользовательских файлов
$SHOW_MYSQL_ERRORS = 'off'; # Показ ошибок MySQL на страницах сайта
$ADMIN_AUTHTIME = 86400; # Время жизни авторизации в секундах (при $AUTHORIZATION_TYPE = session, cookie)
$ADMIN_AUTHTYPE = "manual"; # Выбор типа авторизации: 'session', 'always' or 'manual'
#$CHARSET = "windows-1251";
#$SOURCE_CHARSET = "koi8-r";

$use_gzip_compression = false; # Для включения сжатия вывода установите true

# настройки проекта

$DOMAIN_NAME = $HTTP_HOST; # $HTTP_HOST is server environment variable

#$DOCUMENT_ROOT = "/usr/local/etc/httpd/htdocs/www";

$HTTP_IMAGES_PATH = "/images/";
$HTTP_ROOT_PATH = "/netcat/";
$HTTP_FILES_PATH = "/netcat_files/";
$HTTP_DUMP_PATH = "/netcat_dump/";
$HTTP_CACHE_PATH = "/netcat_cache/";
$HTTP_TRASH_PATH = "/netcat_trash/";

# относительный путь в админку сайта, для ссылок
$ADMIN_PATH = $SUB_FOLDER.$HTTP_ROOT_PATH."admin/";
# относительный путь к теме админки, для изображений и .css файлов
$ADMIN_TEMPLATE = $ADMIN_PATH."skins/default/";
# полный путь к теме сайта, например для функции file_exists()
$ADMIN_TEMPLATE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$ADMIN_TEMPLATE;

$HTTP_TEMPLATE_PATH = "/netcat_template/";

$SYSTEM_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_ROOT_PATH."system/";
$ROOT_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_ROOT_PATH;
$FILES_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_FILES_PATH;
$DUMP_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_DUMP_PATH;
$CACHE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_CACHE_PATH;
$TRASH_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_TRASH_PATH;
$INCLUDE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_ROOT_PATH."require/";
$TMP_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_ROOT_PATH."tmp/";
$MODULE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_ROOT_PATH."modules/";
$ADMIN_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_ROOT_PATH."admin/";
$TEMPLATE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_TEMPLATE_PATH."template/";
$CLASS_TEMPLATE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_TEMPLATE_PATH."class/";
$WIDGET_TEMPLATE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_TEMPLATE_PATH."widget/";
$JQUERY_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_TEMPLATE_PATH."jquery/";
$MODULE_TEMPLATE_FOLDER = $DOCUMENT_ROOT.$SUB_FOLDER.$HTTP_TEMPLATE_PATH."module/";
$EDIT_DOMAIN = $DOMAIN_NAME;
$DOC_DOMAIN = "docs.netcat.ru/24";

// add require/lib folder (PEAR libraries) to the include_path
ini_set("include_path", "{$INCLUDE_FOLDER}lib/").(substr_count(strtolower(php_uname()),'windows') ? ';' : ':').ini_get("include_path"); 
# название разработчика, отображаемое на странице О программе

//$DEVELOPER_NAME='"AIST" JSC';
//$DEVELOPER_URL='http://www.aist.ru/';
require_once 'base.inc.php';
require_once 'my.inc.php';
?>
