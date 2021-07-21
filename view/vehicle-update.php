<?php

$classificationList = '<select name="classificationId" id="classificationId">';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if (isset($classificationId)) {
        if ($classification['classificationId'] === $classificationId) {
            $classificationList .= ' selected ';
        }
    } elseif (isset($invInfo['classificationId'])) {
        if ($classification['classificationId']  === $invInfo['classificationId']) {
            $classificationList .= ' selected ';
        }
    }
    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>';
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header('location: /phpmotors/');
        exit;
    }
    ?>

<h1><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
        echo "Modify $invInfo[invMake] $invInfo[invModel]";
    } elseif (isset($invMake) && isset($invModel)) {
        echo "Modify$invMake $invModel";
    } ?></h1>

<?php
if (isset($message)) {
    echo $message;
}
?>

<div class="updateVehicle">

    <h3>Note all Fields are Required</h3>

    <form action="/phpmotors/vehicles/" method="post">
        <?php echo $classificationList; ?><br><br>

        <label for="invMake">Make</label><br>
        <input type="text" name="invMake" id="invMake" required <?php
                                                                if (isset($invMake)) {
                                                                    echo "value='$invMake'";
                                                                } elseif (isset($invInfo['invMake'])) {
                                                                    echo "value='$invInfo[invMake]'";
                                                                }
                                                                ?>><br><br>

        <label for="invModel">Model</label><br>
        <input type="text" name="invModel" id="invModel" required <?php
                                                                    if (isset($invModel)) {
                                                                        echo "value='$invModel'";
                                                                    } elseif (isset($invInfo['invModel'])) {
                                                                        echo "value='$invInfo[invModel]'";
                                                                    }
                                                                    ?>><br><br>

        <label for="invDescription">Description</label><br>
        <textarea id="invDescription" name="invDescription" required><?php
                                                                        if (isset($invDescription)) {
                                                                            echo $invDescription;
                                                                        } elseif (isset($invInfo['invDescription'])) {
                                                                            echo $invInfo['invDescription'];
                                                                        } ?></textarea><br><br>

        <label for="invImage">Image Path</label><br>
        <input type="text" name="invImage" id="invImage" value="/php_motors/images/no-image.png" required <?php
                                                                                                            if (isset($invImage)) {
                                                                                                                echo "value='$invImage'";
                                                                                                            } elseif (isset($invInfo['invImage'])) {
                                                                                                                echo "value='$invInfo[invImage]'";
                                                                                                            }
                                                                                                            ?>><br><br>

        <label for="invThumbnail">Thumbnail Path</label><br>
        <input type="text" name="invThumbnail" id="invThumbnail" required <?php
                                                                            if (isset($invThumbnail)) {
                                                                                echo "value='$invThumbnail'";
                                                                            } elseif (isset($invInfo['invThumbnail'])) {
                                                                                echo "value='$invInfo[invThumbnail]'";
                                                                            }
                                                                            ?>><br><br>

        <label for="invPrice">Price</label><br>
        <input type="text" id="invPrice" name="invPrice" required <?php
                                                                    if (isset($invPrice)) {
                                                                        echo "value='$invPrice'";
                                                                    } elseif (isset($invInfo['invPrice'])) {
                                                                        echo "value='$invInfo[invPrice]'";
                                                                    }
                                                                    ?>><br><br>

        <label for="invStock"># In Stock</label><br>
        <input type="text" id="invStock" name="invStock" required <?php
                                                                    if (isset($invStock)) {
                                                                        echo "value='$invStock'";
                                                                    } elseif (isset($invInfo['invStock'])) {
                                                                        echo "value='$invInfo[invStock]'";
                                                                    }
                                                                    ?>><br><br>

        <label for="invColor">Color</label><br>
        <input type="text" name="invColor" id="invColor" required <?php
                                                                    if (isset($invColor)) {
                                                                        echo "value='$invColor'";
                                                                    } elseif (isset($invInfo['invColor'])) {
                                                                        echo "value='$invInfo[invColor]'";
                                                                    }
                                                                    ?>><br><br>

        <input type="submit" value="Update Vehicle">
        <input type="hidden" name="action" value="updateVehicle">
        <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                        echo $invInfo['invId'];
                                                    } elseif (isset($invId)) {
                                                        echo $invId;
                                                    } ?>">
    </form>

</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>