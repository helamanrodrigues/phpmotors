<?php
//Accounts Controller
// Create or access a Session
session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

require_once '../model/accounts-model.php';

require_once '../model/reviews-model.php';

// Get the functions library
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

//var_dump($classifications);
//exit;

// Build a navigation bar using the $classifications array
$navList = getNav($classifications);

//echo $navList;
//exit;
// Check if the firstname cookie exists, get its value
if (isset($_COOKIE['firstname'])) {
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

$action = filter_input(INPUT_POST, 'action');
$method = 'POST';
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
  $method = 'GET';
}
switch ($action) {
  case 'login':
    include '../view/login.php';
    break;
  case 'register':
    if ($method == 'GET') {
      include '../view/registration.php';
      exit;
    }
    // Filter and store the data
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    $existingEmail = checkExistingEmail($clientEmail);

    // Check for existing email address in the table
    if ($existingEmail) {
      $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
      include '../view/login.php';
      exit;
    }
    // Check for missing data
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
      $message = '<p class="red">Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit;
    }
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    // Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

    // Check and report the result
    if ($regOutcome === 1) {
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
      header('Location: /phpmotors/accounts/?action=login');
      exit;
    } else {
      $message = "<p class='red'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
      include '../view/registration.php';
      exit;
    }
    break;
  case 'Login':
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);
    if (empty($clientEmail) || empty($checkPassword)) {
      $message = '<p class="red">Please provide information for all empty form fields.</p>';
      include '../view/login.php';
      exit;
    }
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against
    // the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if (!$hashCheck) {
      $_SESSION['message'] = '<p class="red">Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
    }
    unset($_SESSION['message']);
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    $clientId = $_SESSION['clientData']['clientId'];
    $reviews = getReviewByClient($clientId);
    $reviewsDisplay = "";
    foreach ($reviews as $key => $review) {
      $reviewsDisplay .= getReviewListView($review);
    }
    if($reviewsDisplay==""){
      $reviewsDisplay = '<p>There are no reviews <p>';
    }
    include '../view/admin.php';
    exit;
    break;
  case 'Logout':
    unset($_SESSION['loggedin']);
    unset($_SESSION['clientData']);
    unset($_SESSION['message']);
    unset($_SESSION['messageVehicle']);
    session_destroy();
    header('Location: /phpmotors/');
    break;
  case 'client':
    $invInfo = getClientById($_SESSION['clientData']['clientId']);
    include '../view/client-update.php';
    exit;
    break;
  case 'updateClient':
    $clientId = $_SESSION['clientData']['clientId'];
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientEmail = checkEmail($clientEmail);

    $existingEmail = checkExistingEmail($clientEmail);
    // // Check for existing email address in the table
    // if ($_SESSION['clientData']['clientEmail'] != $clientEmail) {
    //   if ($existingEmail) {
    //     $message = '<p class="red">That email address already exists</p>';
    //     include '../view/client-update.php';
    //     exit;
    //   }
    // }

    // Check for missing data
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
      $message = '<p class="red">Please provide information for all empty form fields.</p>';
      include '../view/client-update.php';
      exit;
    }
    // Send the data to the model
    $regOutcome = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);

    // Check and report the result
    if ($regOutcome === 1) {
      $clientData = getClientById($clientId);
      $_SESSION['clientData'] = $clientData;
      $_SESSION['message'] = "The user information was updated successfully.";
      header('Location: /phpmotors/accounts');
      exit;
    } else {
      $message = "<p class='red'>Sorry, updated failed. Please try again.</p>";
      include '../view/client-update.php';
      exit;
    }
    break;
  case 'updatePassword':
    $clientId = $_SESSION['clientData']['clientId'];
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
    $checkPassword = checkPassword($clientPassword);

    // Check for missing data
    if (empty($checkPassword)) {
      $message = '<p class="red">Please provide a valid new password</p>';
      include '../view/client-update.php';
      exit;
    }
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    // Send the data to the model
    $regOutcome = updatePassword($clientId, $hashedPassword);

    // Check and report the result
    if ($regOutcome === 1) {
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = "The password was updated successfully.";
      header('Location: /phpmotors/accounts');
      exit;
    } else {
      $message = "<p class='red'>Sorry, error updating password. Please try again.</p>";
      include '../view/client-update.php';
      exit;
    }
    break;
  default:
    $clientId = $_SESSION['clientData']['clientId'];
    $reviews = getReviewByClient($clientId);
    $reviewsDisplay = "";
    foreach ($reviews as $key => $review) {
      $reviewsDisplay .= getReviewListView($review);
    }
    if($reviewsDisplay==""){
      $reviewsDisplay = '<p>There are no reviews <p>';
    }
    include '../view/admin.php';
    break;
}
