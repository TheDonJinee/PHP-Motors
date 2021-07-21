<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/header.php'; ?>

<h1 class="classificationTitle"><?php echo $classificationName; ?> vehicles</h1>
<?php if(isset($message)){
 echo $message; }
 ?>
<?php if(isset($vehicleDisplay)){
 echo $vehicleDisplay;
} ?>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php' ?>