<?php
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );
// Create or access a Session
session_start();    
// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';

// Get the functions library
require_once 'library/functions.php';
// Get the array of classifications
$classifications = getClassifications();

//var_dump($classifications);
//exit;
    
// Build a navigation bar using the $classifications array
$navList=getNav($classifications);
//exit;

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    default:
        include 'view/home.php';
        break;
}
