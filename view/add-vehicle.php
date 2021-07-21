<?php 

    $classificationList = '<select name="classificationId" id="classificationId">';
    $classificationList .= '<option value="0">Choose Car Classification</option>';
    foreach ($classifications as $classification){
          $classificationList .= "<option value='$classification[classificationId]'";
          if(isset($classificationId)){
              if($classification['classificationId'] === $classificationId){
                  $classificationList .= ' selected ';
              }
          }
          $classificationList .= ">$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';

?><?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/header.php';
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
   }
  ?>



<h1>Add Vehicle</h1>

<?php
if(isset($message)){
    echo $message;
}
?>

<div class="addVehicleForm">
<h3>Note all Fields are Required</h3>

<form action="/phpmotors/vehicles/index.php" method="post">
    <label for="classificationId" class="classList"></label>
    <?php echo $classificationList; ?><br><br>
    
    <label for="invMake">Make</label><br>
    <input type="text" name="invMake" id="invMake" required  <?php
    if (isset($invMake)){
        echo "value='$invMake'";
    }
    ?>><br><br>

    <label for="invModel">Model</label><br>
    <input type="text" name="invModel" id="invModel" required  <?php
    if (isset($invModel)){
        echo "value='$invModel'";
    }
    ?>><br><br>

    <label for="invDescription">Description</label><br>
    <textarea name="invDescription" id="invDescription" required><?php if(isset($invDescription)){echo "$invDescription";}?></textarea><br><br>
    
    <label for="invImage">Image Path</label><br>
    <input type="text" name="invImage" id="invImage" required  <?php
    if (isset($invImage)){
        echo "value='$invImage'";
    }
    ?>><br><br>

    <label for="invThumbnail">Thumbnail Path</label><br>
    <input type="text" name="invThumbnail" id="invThumbnail" required  <?php
    if (isset($invThumbnail)){
        echo "value='$invThumbnail'";
    }
    ?>><br><br>

    <label for="invPrice">Price</label><br>
    <input type="number" id="invPrice" name="invPrice" min="1" required  <?php
    if (isset($invPrice)){
        echo "value='$invPrice'";
    }
    ?>><br><br>

    <label for="invStock"># In Stock</label><br>
    <input type="number" id="invStock" name="invStock" min="1" required  <?php
    if (isset($invStock)){
        echo "value='$invStock'";
    }
    ?>><br><br>
    
    <label for="invColor">Color</label><br>
    <input type="text" name="invColor" id="invColor" required  <?php
    if (isset($invColor)){
        echo "value='$invColor'";
    }
    ?>><br><br>

    <input type="submit" name="submit" value="Add Vehicle">
    <input type="hidden" name="action" value="add-vehicle">
</form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php' ?>