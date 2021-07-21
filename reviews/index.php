<?php
session_start();
// This is the reviews controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the uploads model
require_once '../model/uploads-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
// Get the functions file
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

$navList = getNavList($classifications);

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

 switch ($action) {
    case 'add-review':
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING);
        
        $invInfo = getInvItemInfo($invId);
        $thumbnailArray = getThumbnails($invId);

        if (isset($_SESSION['loggedin'])) {
            $clientEmail = $_SESSION['clientData']['clientEmail'];
            $clientInfo = getClient($clientEmail);
        }
        
        $thumbnails = buildThumbnailDisplay($thumbnailArray);
        $vehicle = vehicleDetailPage($invInfo);

        // Check for missing data
        if(empty($reviewText)){
            $message = '<p class="warning" >Please provide information for all empty form fields.</p>';
            include '../view/vehicle-detail.php';
            exit; 
        }

       $revOutcome = insertReview($reviewText, $invId, $clientId);

        // Check and report the result
        if($revOutcome === 1){
            $message = "<p class='success' >Your review was succesfully added!</p>";
            
            include '../view/vehicle-detail.php';
            exit;
        } else {
            $message = "<p class='warning' >Sorry, the review was not able to be added, please try again.</p>";
            header('Location: /phpmotors/reviews/index.php?action=add-review&invId=' . $invId);
            exit;
        }
    
    case 'update-review-page':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if(empty($reviewId)){
            $message = '<p class="warning" >Sorry, something went wrong. Please try again.</p>';
            include '../view/admin.php';
            exit; 
        }

        $review = getReview($reviewId);

        include '../view/review-update.php';
        break;
    
    case 'update-review':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        date_default_timezone_set('America/Denver');
        $reviewDate = date('Y-m-d H:i:s');
        
        $review = getReview($reviewId);
        // Check for missing data
        if(empty($reviewId) || empty($reviewText) || empty($reviewDate) ){
            $message = '<p class="warning" >Please provide information for all empty form fields</p>';
            include '../view/review-update.php';
            exit; 
        }

        $updateOutcome = updateReview($reviewId, $reviewText, $reviewDate);

        // Check and report the result
        if($updateOutcome === 1){
            $message = "<p class='success' >Update was succesful!</p>";
            
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p class='warning' >Unable to update the review, please try again.</p>";
            include '../view/review-update.php';
            exit;
        }
        break;

    case 'delete-review-page':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if(empty($reviewId)){
            $message = '<p class="warning" > Sorry, something went wrong. Please try again.</p>';
            include '../view/admin.php';
            exit; 
        }

        $review = getReview($reviewId);
        

        # Functions to display info in this views

        include '../view/review-delete.php';
        break;

    case 'delete-review':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if(empty($reviewId)){
            $message = '<p class="warning" >Sorry, something went wrong. Please try again.</p>';
            include '../view/admin.php';
            exit; 
        }

        $deleteResult = deleteReview($reviewId);
        
        // Check and report the result
        if($deleteResult === 1){
            $message = "<p class='success' >Delete was succesful!</p>";
            
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p class='warning' >Unable to delete the review, please try again.</p>";
            include '../view/review-delete.php';
            exit;
        }

        break;
     
    default:
        include '../view/home.php';
 }