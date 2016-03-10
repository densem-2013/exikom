<?php

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

// Set flag that this is a parent file

define('_JEXEC', 1);
defined( '_JEXEC' ) or die('Restricted ');

define('JPATH_BASE', __DIR__ );

define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$mainframe = JFactory::getApplication('administrator');
$mainframe->initialise();
$db =& JFactory::getDBO();


$table_name="ne2_project_".$_POST['tablepref']."s";
$sql=null;

$column=$_POST['tablepref'];
$val=$_POST['newvalue'];
$oldval = null;
if(isset($_POST["oldvalue"]))
    {
		$oldval=$_POST["oldvalue"];
	}
// Create a new query object.
$resp = null;

switch ($_POST['operation']) {
    case "add":
		$query= "insert into $table_name ($column) values ('$val') "; 
		$resp= " Вы добавили одну запись в таблицу $table_name.";
        break;
    case "edit":
		$query = "update $table_name set $column=('$val') where $column=('$oldval')" ;
		$resp= " Вы обновили одну запись в таблице $table_name.";
        break;
    case "delete":
		$query = "delete from $table_name where $column=('$val')" ;
		$resp= " Вы удалили одну запись из таблицы $table_name.";
        break;
}

// Set the query using our newly populated query object and execute it.
$db->setQuery($query);
$rezult= $db->execute();
echo $resp;
