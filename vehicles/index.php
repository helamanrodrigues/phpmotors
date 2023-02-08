<?php
//Accounts Controller
// Create or access a Session
session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

require_once '../model/vehicles-model.php';

require_once '../model/reviews-model.php';

// Get the functions library
require_once '../library/functions.php';


$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = getNav($classifications);

$action = filter_input(INPUT_POST, 'action');
$method = 'POST';
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
  $method = "GET";
}
switch ($action) {
  case 'login':
    include '../view/login.php';
    break;
  case 'addClassification':
    if ($method == 'GET') {
      include '../view/add-classification.php';
      exit;
    }
    $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);
    if (empty($classificationName)) {
      $message = '<p class="red">Please provide information for all empty form fields.</p>';
      include '../view/add-classification.php';
      exit;
    }

    $regOutcome = regClassification($classificationName);

    if ($regOutcome === 1) {
      $message = "";
      header("Refresh:0");
      exit;
    } else {
      $message = "<p class='red'>The registration failed. Please try again.</p>";
      include '../view/add-classification.php';
      exit;
    }
    break;
  case 'addVehicle':
    $classificationSelect = '';
    foreach ($classifications as $classification) {
      $classificationSelect .= "<option value='$classification[classificationId]'>$classification[classificationName] </option>";
    }

    if ($method == 'GET') {
      include '../view/add-vehicle.php';
      exit;
    }
    $carClassification = trim(filter_input(INPUT_POST, 'carClassification', FILTER_SANITIZE_STRING));
    $vehicleMake = trim(filter_input(INPUT_POST, 'vehicleMake', FILTER_SANITIZE_STRING));
    $vehicleModel = trim(filter_input(INPUT_POST, 'vehicleModel', FILTER_SANITIZE_STRING));
    $vehicleDescription = trim(filter_input(INPUT_POST, 'vehicleDescription', FILTER_SANITIZE_STRING));
    $vehicleImagePath = trim(filter_input(INPUT_POST, 'vehicleImagePath', FILTER_SANITIZE_STRING));
    $vehicleThumbnailPath = trim(filter_input(INPUT_POST, 'vehicleThumbnailPath', FILTER_SANITIZE_STRING));
    $vehiclePrice = trim(filter_input(INPUT_POST, 'vehiclePrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    $vehicleInStock = trim(filter_input(INPUT_POST, 'vehicleInStock', FILTER_SANITIZE_NUMBER_INT));
    $vehicleColor = trim(filter_input(INPUT_POST, 'vehicleColor', FILTER_SANITIZE_STRING));
    if (
      $carClassification == '' ||
      empty($vehicleMake) ||
      empty($vehicleModel) ||
      empty($vehicleDescription) ||
      empty($vehicleImagePath) ||
      empty($vehicleThumbnailPath) ||
      empty($vehiclePrice) ||
      empty($vehicleInStock) ||
      empty($vehicleColor)
    ) {
      $message = '<p class="red">Please provide information for all empty form fields.</p>';
      include '../view/add-vehicle.php';
      exit;
    }

    $regOutcome = regVehicle(
      $carClassification,
      $vehicleMake,
      $vehicleModel,
      $vehicleDescription,
      $vehicleImagePath,
      $vehicleThumbnailPath,
      $vehiclePrice,
      $vehicleInStock,
      $vehicleColor
    );
    if ($regOutcome === 1) {
      $message = "<p>The $vehicleMake $vehicleModel was added successfully!</p>";
      include '../view/add-vehicle.php';
      exit;
    } else {
      $message = "<p class='red'>The registration failed. Please try again.</p>";
      include '../view/add-vehicle.php';
      exit;
    }
    break;
  case 'getInventoryItems':
    // Get the classificationId 
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    // Fetch the vehicles by classificationId from the DB 
    $inventoryArray = getInventoryByClassification($classificationId);
    // Convert the array to a JSON object and send it back 
    echo json_encode($inventoryArray);
    break;
  case 'mod':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-update.php';
    exit;
    break;
  case 'updateVehicle':
    $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
    $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
    $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
    $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
    $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    if (
      empty($classificationId) || empty($invMake) || empty($invModel)
      || empty($invDescription) || empty($invImage) || empty($invThumbnail)
      || empty($invPrice) || empty($invStock) || empty($invColor)
    ) {
      $message = '<p>Please complete all information for the item! Double check the classification of the item.</p>';
      include '../view/vehicle-update.php';
      exit;
    }

    $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
    if ($updateResult) {
      $message = "<p class='notice'>Congratulations, the $invMake $invModel was successfully updated.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p class='notice'>Error. the $invMake $invModel was not updated.</p>";
      include '../view/vehicle-update.php';
      exit;
    }
    break;
  case 'del':
    $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-delete.php';
    exit;
    break;
  case 'deleteVehicle':
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    $deleteResult = deleteVehicle($invId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p class='notice'>Error: $invMake $invModel was not
                      deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    }
    break;
  case 'classification':
    $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
    $vehicles = getVehiclesByClassification($classificationName);
    if (!count($vehicles)) {
      $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
      $vehicleDisplay = buildVehiclesDisplay($vehicles);
    }
    include '../view/classification.php';
    break;
  case 'vehicle':
    $invMake = filter_input(INPUT_GET, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_GET, 'invModel', FILTER_SANITIZE_STRING);
    $vehicle = getVehicle($invMake, $invModel);
    if (!count($vehicle)) {
      $message = "<p class='notice'>Sorry, no vehicle $invMake $invModel could be found.</p>";
    } else {
      $thumbnail = getVehicleThumbnail($vehicle['invId']);
      $vehicleDetailDisplay = buildVehicleDetailDisplay($vehicle, $thumbnail);
    }
    if (isset($_SESSION['loggedin'])) {
      if ($_SESSION['loggedin']) {
        $screenName = getScreenName($_SESSION['clientData']['clientFirstname'], $_SESSION['clientData']['clientLastname']);
      }
    }
    $reviews = getReviewByInv($vehicle['invId']);
    $firstReview = '';
    if (count($reviews) < 1) {
      $firstReview = '<h3>Be the first to write a review.</h3>';
    }
    $reviewsDetailDisplay = '';
    foreach ($reviews as $key => $review) {
      $reviewsDetailDisplay .= getReviewsView($review);
    }
    include '../view/view-detail.php';
    break;
  default:
    $classificationList = buildClassificationList($classifications);

    include '../view/vehicle-man.php';
    break;
}
