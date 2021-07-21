<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';

if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>

<h1>Vehicle Management</h1>
<div class="addCarInfo">
    <ul>
        <li><a href="../vehicles/index.php?action=add-classification-page">Add Classification</a></li>
        <li><a href="../vehicles/index.php?action=add-vehicle-page">Add Vehicle</a></li>
    </ul>
</div>


<div class="vehicleManagement">

    <?php
    if (isset($message)) {
        echo $message;
    }
    if (isset($classificationList)) {
        echo '<h2>Vehicles By Classification</h2>';
        echo '<p>Choose a classification to see those vehicles</p>';
        echo $classificationList;
    }
    ?>
    <noscript>
        <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>
    <table id="inventoryDisplay"></table>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
<?php unset($_SESSION['message']); ?>