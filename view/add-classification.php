<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/header.php';

if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>

<h1>Add Car Classification</h1>

<?php
if(isset($message)){
    echo $message;
}
?>
<div class="addClassification">
<form action="/phpmotors/vehicles/index.php" method="post">
    <label for="classificationName">Classification Name</label><br>
    <input type="text" name="classificationName" id="classificationName" required  <?php
    if (isset($classificationName)){
        echo "value='$classificationName'";
    }
    ?>><br><br>
    <input type="submit" name="submit" value="Add Car Classification">
    <input type="hidden" name="action" value="add-car-classification">
</form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php' ?>