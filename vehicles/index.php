<?php
session_start();
// This is the main controller

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

 switch ($action){
   case 'add-car-classification':
            // Get data from forms
         $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);

         // Check for missing data
         if(empty($classificationName)){
         $message = '<p class="warning" >Please provide information for all empty form fields.</p>';
         include '../view/add-classification.php';
         exit; 
         }

         // Send the data to the model
         $regOutcome = regCarClass($classificationName);

         // Check and report the result
         if($regOutcome === 1){
         $message = "<p class='success' >The new car $classificationName classification was succesfully added!</p>";
         include '../view/add-classification.php';
         exit;
      } else {
         $message = "<p class='warning' >Sorry the car $classificationName classification failed to be added </p>";
         include '../view/add-classification.php';
         exit;
      }
   case 'add-vehicle':
            // Get Data Formds
      $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
      $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
      $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
      $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
      $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
      $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
      $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
      $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);

      // Check for missing data
      if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) ||
            empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)){
         $message = '<p class="warning" >Please provide information for all empty form fields.</p>';
         include '../view/add-vehicle.php';
         exit; 
         }
         
      // Send the data to the model
      $regOutcome = regVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

      
      // Check and report the result
      if($regOutcome === 1){
         $message = "<p class='success'>The $invModel $invMake was added succesfully!</p>";
         include '../view/add-vehicle.php';
         exit;
      } else {
         $message = "<p class='warning' >Sorry the vehicle $invModel $invMake failed to register. Please try again.</p>";
         include '../view/add-vehicle.php';
         exit;
      }
   case 'add-classification-page':
     include '../view/add-classification.php';
     break;
   case 'add-vehicle-page':
      include '../view/add-vehicle.php';
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
      $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
      $invInfo = getInvItemInfo($invId);
      if(count($invInfo)<1){
         $message = '<p class="warning" >Sorry, no vehicle information could be found. </p>';
        }
      include '../view/vehicle-update.php';
      exit;
      break;
   case 'updateVehicle':
      $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
      $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
      $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
      $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
      $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
      $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
      $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
      $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
      $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
      
      if (empty($classificationId) || empty($invMake) || empty($invModel) 
         || empty($invDescription) || empty($invImage) || empty($invThumbnail)
         || empty($invPrice) || empty($invStock) || empty($invColor)) {
      $message = '<p class="warning" >Please complete all information for the item! Double check the classification of the item.</p>';
         include '../view/vehicle-update.php';
      exit;
      }
      
      $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
      if ($updateResult) {
         $message = "<p class='success' >Congratulations, the $invMake $invModel was successfully updated.</p>";
         $_SESSION['message'] = $message;
         header('location: /phpmotors/vehicles/');
         exit;
      } else {
         $message = "<p class='warning' >Error. the $invMake $invModel was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
      }
      break;
   case 'del':
      $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
      $invInfo = getInvItemInfo($invId);
      if (count($invInfo) < 1) {
            $message = '<p class="warning" >Sorry, no vehicle information could be found.</p>';
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
         $message = "<p class='success'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
         $_SESSION['message'] = $message;
         header('location: /phpmotors/vehicles/');
         exit;
      } else {
         $message = "<p class='warning' >Error: $invMake $invModel was not deleted.</p>";
         $_SESSION['message'] = $message;
         header('location: /phpmotors/vehicles/');
         exit;
      }
      break;
   
   case 'classification':
      $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
      $vehicles = getVehiclesByClassification($classificationName);
      if(!count($vehicles)){
      $message = "<p class='warning' >Sorry, no $classificationName could be found.</p>";
      } else {
      $vehicleDisplay = buildVehiclesDisplay($vehicles);
      }
      include '../view/classification.php';
      break;
   case 'pullVehicleData':
      $invId = filter_input(INPUT_GET, 'vehicleId', FILTER_SANITIZE_NUMBER_INT);
      $invInfo = getInvItemInfo($invId);
      $thumbnailArray = getThumbnails($invId);

      if (isset($_SESSION['loggedin'])) {
         $clientEmail = $_SESSION['clientData']['clientEmail'];
         $clientInfo = getClient($clientEmail);
     }
      

      $_SESSION['message'] = null;
      if (!$invInfo) {
         $_SESSION['message'] = '<p class"warning" >Sorry, no vehicle information could be found.</p>';
         } else {
            $thumbnails = buildThumbnailDisplay($thumbnailArray);

            $vehicle = vehicleDetailPage($invInfo);
         }
         include '../view/vehicle-detail.php';
         break;
   default:
      $classificationList = buildClassificationList($classifications);

      include '../view/vehicle-main.php';
      break;

   }