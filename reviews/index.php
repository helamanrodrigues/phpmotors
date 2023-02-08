<?php
//Accounts Controller
// Create or access a Session
session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

require_once '../model/reviews-model.php';

// Get the functions library
require_once '../library/functions.php';

$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = getNav($classifications);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}
switch ($action) {
    case 'addReview':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        if (empty($reviewText) || empty($invId) || empty($clientId)) {
            $_SESSION['message'] = '<p class="red">Please provide information for all empty form fields.</p>';
            header("Location: /phpmotors/vehicles?action=vehicle&invMake=" . $invMake . "&invModel=" . $invModel);
            exit;
        }
        $_SESSION['messageVehicle'] = '<p class="red">Thank you for the review it is displayed below.</p>';
        $regOutcome = regReview(
            $reviewText,
            $invId,
            $clientId
        );
        header("Location: /phpmotors/vehicles?action=vehicle&invMake=" . $invMake . "&invModel=" . $invModel);
        break;
    case 'editReview':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $review = getReviewById($reviewId);
        include '../view/review-edit.php';
        break;
    case 'updateReview':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        if (empty($reviewText) || empty($reviewId)) {
            $message = '<p class="red">Please complete all information for the review.</p>';
            include '../view/review-edit.php';
            exit;
        }
        $review = getReviewById($reviewId);
        $updateResult = updateReview($reviewId, $reviewText);
        if ($updateResult) {
            $message = "<p class='red'>Congratulations, the review was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts');
            exit;
        } else {
            $message = "<p class='red'>Error. the review was not updated.</p>";
            include '../view/review-edit.php';
            exit;
        }
        break;
    case 'confirmDeleteReview':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $review = getReviewById($reviewId);
        include '../view/review-delete.php';        
        break;
    case 'deleteReview':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        if (empty($reviewId)) {
            $message = '<p class="red">Please complete all information for the review.</p>';
            include '../view/review-delete.php';
            exit;
        }
        $review = getReviewById($reviewId);
        $deleteResult = deleteReview($reviewId);
        if ($deleteResult) {
            $message = "<p class='red'>The review was deleted successfully.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts');
            exit;
        } else {
            $message = "<p class='red'>Error. the review was not deleted.</p>";
            include '../view/review-delete.php';
            exit;
        }
    default:
        include '../view/vehicle-man.php';
        exit;
        break;
}
