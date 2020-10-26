<?php
/* $Id: fckstyles.xml.php 3553 2009-10-29 09:11:39Z vadim $ */

if (!isset($_SERVER['DOCUMENT_ROOT'])) exit;

$NETCAT_FOLDER = join( strstr(__FILE__, "/") ? "/" : "\\", array_slice( preg_split("/[\/\\\]+/", __FILE__), 0, -3 ) ).( strstr(__FILE__, "/") ? "/" : "\\" );
include_once ($NETCAT_FOLDER."vars.inc.php");
require ($ROOT_FOLDER."connect_io.php");

header('Content-type: text/xml');

$q = $db->get_var("SELECT `EditorStyles` FROM `Settings`");
if ($db->num_rows != 0) {
  $editor_styles = $q;
  echo $editor_styles;
}

?>