<?php
session_start();
// This is the accounts controller

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
   case 'register':
      // Get data from forms
      $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
      $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
      $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
      $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);

      // Check for existing email
      $existingEmail = checkExistingEmail($clientEmail);

      // Check for existing email address in the table
      if($existingEmail){
         $message = '<p class="warning" >That email address already exists. Do you want to login instead?</p>';
         include '../view/login.php';
         exit;
      }

      // Check for missing data
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
         $message = '<p class="warning" >Please provide information for all empty form fields.</p>';
         include '../view/registration.php';
         exit; 
        }

      // Hash the checked password
      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

      // Send the data to the model
      $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

      // Check and report the result
      if ($regOutcome === 1) {
         setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
         $message = "<p class='success'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
         include '../view/login.php';
         exit;
      }

      // Check and report the result
      if($regOutcome === 1){
         $message = "<p class='success' >Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
         include '../view/login.php';
         exit;
      } else {
         $message = "<p class='warning'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
         include '../view/registration.php';
         exit;
      }

   case 'registration-page':
      include '../view/registration.php';
      break;
   case 'login-page':
      include '../view/login.php';
      break;
   case 'Login':
      $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
      $clientEmail = checkEmail($clientEmail);
      $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
      $passwordCheck = checkPassword($clientPassword);

      // Run basic checks, return if errors
      if (empty($clientEmail) || empty($passwordCheck)) {
      $message = '<p class="warning" >Please provide a valid email address and password.</p>';
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
      if(!$hashCheck) {
      $message = '<p class="warning" >Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
      }
      // A valid user exists, log them in
      $_SESSION['loggedin'] = TRUE;
      // Remove the password from the array
      // the array_pop function removes the last
      // element from an array
      array_pop($clientData);
      // Store the array into the session
      $_SESSION['clientData'] = $clientData;
      // Send them to the admin view
      include '../view/admin.php';
      exit;
      break;

   case 'Logout':
      session_unset();
      session_destroy();
      $_SESSION = array();
      include '../index.php' ;
      exit;
      break;
   
   case 'client-update':
      $clientId = $_SESSION['clientData']['clientId'];
      $clientInfo = getClientInfo($clientId);
      include '../view/client-update.php';
      break;
   case 'updateInfo':
      // A valid password exists, proceed with the login process
      // Query the client data based on the email address
      $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
      $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
      $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING);

      $clientEmail = checkEmail($clientEmail);
      $currentEmail = $_SESSION['clientData']['clientEmail'];

      // Check for existing email
      $existingEmail = checkExistingEmail($clientEmail);

      // Check for existing email address in the table
      if ($currentEmail != $clientEmail) {
         if($existingEmail){
            $message = '<p class="warning" >That email address already exists. Do you want to login instead?</p>';
            include '../view/client-update.php';
            exit;
         }
      }
      
      // Check for missing data
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)){
         $message = '<p class="warning" >Please provide information for all empty form fields.</p>';
         include '../view/client-update.php';
         exit; 
        }
      $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
      $clientId = $_SESSION['clientData']['clientId'];
      $clientInfo = getClientInfo($clientId);
      array_pop($clientInfo);
      $_SESSION['clientData'] = $clientInfo;
      if ($updateOutcome === 1) {
         setcookie('firstname', $clientFirstname, 0, '/');
         $_SESSION['message'] = "<p class='success' > $clientFirstname, your information has been updated. </p>";
         header('Location: /phpmotors/accounts');
         exit;
      } else {
         $message = "<p class='warning'> Sorry $clientFirstname, we could not update your account information. Please try again.</p>";
         include '../view/client-update.php';
         exit;
      }
      
      break;
   case 'updatePassword':
      $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
      $passwordCheck = checkPassword($clientPassword);
      $clientInfo = getClientInfo($clientId);
      // Run basic checks, return if errors
      if (empty($passwordCheck)) {
      $message = '<p class="warning" >Please provide a valid password.</p>';
      include '../view/client-update.php';
      exit;
      }

      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
      $updateOutcome = updateClientPassword($hashedPassword, $clientId);
      if ($updateOutcome === 1) {
         setcookie('firstname', $clientInfo['clientFirstname'], 0, '/');
         $_SESSION['message'] = "<p class='success'> $clientInfo[clientFirstname], your password has been updated </p>";
         header('Location: /phpmotors/accounts');
         exit;
      } else {
         $message = "<p class='warning'> Sorry $clientFirstname, the password failed to update. Please try again.</p>";
         include '../view/client-update.php';
         exit;
      }


   default:
      include '../view/admin.php';
   }