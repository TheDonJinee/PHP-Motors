<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?> | PHP Motors</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Teko&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/phpmotors/css/normalize.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/phpmotors/css/small.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/phpmotors/css/large.css?v=<?php echo time(); ?>">
    
</head>

<body>
    <div id="wrapper">
        <header>
            <div id="top-header">
            <img id="logo" src="/phpmotors/images/site/logo.png" alt="PHP Logo">

            <?php if(isset($_SESSION['loggedin'])) {
                    if ($_SESSION['loggedin'] === TRUE) {
                        echo '<a id="logout" class="acc" href="/phpmotors/accounts/index.php/?action=Logout">Logout</a>';}
            } else {
                echo '<a class="myaccount" href="/phpmotors/accounts/index.php/?action=login-page">My Account</a>';
                    } ?>
            
            <?php 
            if(isset($_SESSION['loggedin'])) {
                $user = $_SESSION['clientData']['clientFirstname'];
                echo "<a id='welcomeUser' class='acc' href='/phpmotors/accounts/'>Welcome $user</a>";
            }
            ?>
            </div>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>