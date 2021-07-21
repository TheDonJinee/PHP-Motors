<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>



<?php
$dateReview = $review[0]['reviewDate'];
$dateFormat = date("F d, Y", strtotime($dateReview));
$invModel = $review[0]['invModel'];
$invMake = $review[0]['invMake'];

echo "<h1>$invMake $invModel Review</h1>";

if (isset($message)) {
    echo $message;
}

?>

<div class="updateReviewInfo">
    <?php echo "<p class='updateDate' >Reviewed on $dateFormat</p>"; ?>

    <form action="/phpmotors/reviews/" method="post">
        <label for='reviewText'>Review Text</label><br>
        <textarea id='reviewText' name='reviewText' required><?php
                                                                if (isset($reviewText) && !empty($reviewText)) {
                                                                    echo $reviewText;
                                                                } elseif (isset($review[0]['reviewText'])) {
                                                                    echo $review[0]['reviewText'];
                                                                } ?></textarea><br>

        <input type='submit' value='Update'>
        <input type="hidden" name="action" value="update-review">
        <input type="hidden" name="reviewId" value="<?php if (isset($review[0]['reviewId'])) {
                                                        echo $review[0]['reviewId'];
                                                    } elseif (isset($reviewId)) {
                                                        echo $reviewId;
                                                    } ?>">
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>