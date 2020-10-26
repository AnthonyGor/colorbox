<?
//ob_start();
//require_once '../index.php';
//ob_clean();
//print 150;

include_once '../vars.inc.php';

//ini_set('display_errors', true);
mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWORD);
mysql_select_db($MYSQL_DB_NAME);
mysql_query("SET NAMES $MYSQL_CHARSET");

$calc = $_GET['calc'];
  $color = intval($_GET['color']);
  $sides = intval($_GET['sides']);
  $format = intval($_GET['format']);
  $formatvizitki = intval($_GET['formatvizitki']);
  $formatconverta = intval($_GET['formatconverta']);
  $count = intval($_GET['count']);
  $lamin = intval($_GET['lamin']);
  $lamincalendar = intval($_GET['lamincalendar']);
  $density = intval($_GET['density']);
  $paper = intval($_GET['paper']);
  
  if ('' == $lamin)
    $lamin = 2;
    
$out = '';
$sql = '';

switch ($calc) 
{
case 'presentation':
  
  $lam_price = 15;
  $pruj_price = 25;
  $sides_mul = array(
    3 => array(40 => 1, 44 => 0.5),
    4 => array(40 => 0.5, 44 => 0.25),
    5 => array(40 => 0.25, 44 => 0.125),
  );
      
  //print $count.'<br>';
  if ($count % 4)
    $count += 4 - $count % 4;
  //print $count;
  
  $sb = get_var("SELECT P$color FROM Message88 WHERE Density = $density");
  
  $discount = get_var("SELECT MIN(K) FROM Message89 WHERE $count > TirFrom");
  
  $total = (($sb + $lamin * $lam_price) * $sides * $sides_mul[$format][$color]
              + $pruj_price) * $count * $discount;
              
  $sql = "SELECT $total";
  break;
case 'broshura':

  
  $sql = "SELECT Print$count FROM Message85 WHERE Subdivision_ID = 172
              AND Format = $format AND Color = $color
                  AND Sides = $sides";
  //$out = 'Брошюры';
  break;

case 'vizitka':

  
  $sql = "SELECT Print$count FROM Message85 WHERE Subdivision_ID = 174
              AND FormatVizitki = $formatvizitki AND Color = $color
                  AND Paper = $paper AND 
                    (Lamin = $lamin OR 
                      ($lamin = 2 AND 
                          (Lamin IS NULL OR Lamin = 0)
                      )
                    )
                  ";
  //print $sql;
  break;

case 'buklet':

  
  $sql = "SELECT Print$count FROM Message85 WHERE Subdivision_ID = 175
              AND Format = $format AND Density = $density
                  AND 
                    (Lamin = $lamin OR 
                      ($lamin = 2 AND 
                          (Lamin IS NULL OR Lamin = 0)
                      )
                    )
                  ";
  //print $sql;
  
  break;

case 'convert':

  
  $sql = "SELECT Print$count FROM Message85 WHERE Subdivision_ID = 176
              AND FormatConverta = $formatconverta AND Color = $color";
  //print $sql;
  
  break;

case 'calendar':

  
  $sql = "SELECT Print$count FROM Message85 WHERE Subdivision_ID = 177
                    AND LaminCalendar = $lamincalendar";
  //print $sql;
  
  break;
  
default:
	$sql = '';
	break;
}

if ($sql != '')
{
  //print $sql;
  $q = mysql_query($sql);
  
  if (mysql_num_rows($q))
    $out = mysql_result($q, 0, 0).' руб.*';
}

if ('' == $out)
    $out = 'Этот вид печати отсутствует';


print $out;










//print nc_captcha_formfield();

/*global $nc_core;    
global $GLOBALS;

require_once($nc_core->INCLUDE_FOLDER."classes/nc_imagetransform.class.php");*/


?>