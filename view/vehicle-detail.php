<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<?php
echo $vehicle;
echo $thumbnails; ?>

<h2 class="reviewsHeader">Customers Reviews</h2>

<?php

if (isset($message)) {
    echo $message;
}

if (isset($_SESSION['loggedin'])) {
    echo "<h3 class='reviewVehicle' >Review the $invInfo[invMake] $invInfo[invModel]</h3>";
    $firstLetter = substr($clientInfo['clientFirstname'], 0, 1);
    $userName = $firstLetter . $clientInfo['clientLastname'];
    $addForm = displayAddForm($userName, $clientInfo, $invInfo);

    echo $addForm;
} else {
    echo "<p class='invitation' >You must <a href='../accounts/index.php?action=login-page'>login</a> to write a review.</p>";
}
?>

<?php

$reviews = getReviewItem($invInfo['invId']);

if (!empty($reviews)) {
    foreach ($reviews as $review) {

        $firstLetter = substr($review['clientFirstname'], 0, 1);
        $userName = $firstLetter . $review['clientLastname'];
        $dateReview = $review['reviewDate'];
        $dateFormat = date("F d, Y", strtotime($dateReview));

        $reviewData = "<div class='reviewData'>";
        $reviewData .= "<label for='reviewData' >$userName wrote on $dateFormat: </label>";
        $reviewData .= "<textarea name='reviewData' id='reviewData' readonly>$review[reviewText]</textarea></div>";


        echo $reviewData;
    }
} else {
    echo '<p class="first" >Be the first to write a review. </p>';
}

?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>