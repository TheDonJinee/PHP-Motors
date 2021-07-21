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

<h1><?php if (isset($invInfo['invMake'])) {
        echo "Delete $invInfo[invMake] $invInfo[invModel]";
    } ?></h1>

<?php
if (isset($message)) {
    echo $message;
}
?>

<div class="deleteVehicle">

    <h3 class="center red">Confirm Vehicle Deletion. The delete is permanent.</h3>
    <form method="post" action="/phpmotors/vehicles/">
        <label for="invMake">Vehicle Make</label><br>
        <input type="text" readonly name="invMake" id="invMake" <?php if (isset($invInfo['invMake'])) {
                                                                    echo "value='$invInfo[invMake]'";
                                                                } ?>><br><br>

        <label for="invModel">Vehicle Model</label><br>
        <input type="text" readonly name="invModel" id="invModel" <?php if (isset($invInfo['invModel'])) {
                                                                        echo "value='$invInfo[invModel]'";
                                                                    } ?>><br><br>

        <label for="invDescription">Vehicle Description</label><br>
        <textarea name="invDescription" readonly id="invDescription"><?php if (isset($invInfo['invDescription'])) {
                                                                            echo $invInfo['invDescription'];
                                                                        } ?></textarea><br><br>

        <input type="submit" class="regbtn" value="Delete Vehicle">
        <input type="hidden" name="action" value="deleteVehicle">
        <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                        echo $invInfo['invId'];
                                                    } ?>">

    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>