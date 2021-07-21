<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<?php
$dateReview = $review[0]['reviewDate'];
$dateFormat = date("F d, Y", strtotime($dateReview));
$invModel = $review[0]['invModel'];
$invMake = $review[0]['invMake'];


echo "<h1>Delete $invMake $invModel Review</h1>";
?>

<div class="deleteReviewInfo">
    <?php echo "<p class='deleteDate' >Reviewed on $dateFormat</p>"; ?>
    <h3 class='warningDelete'>Deletes cannot be undone. Are you sure you want to delete this review?</h3>

    <form action="/phpmotors/reviews/" method="post">
        <label for='reviewText'>Review Text</label><br>
        <textarea id='reviewText' name='reviewText' readonly required><?php
                                                                        if (isset($reviewText)) {
                                                                            echo $reviewText;
                                                                        } elseif (isset($review[0]['reviewText'])) {
                                                                            echo $review[0]['reviewText'];
                                                                        } ?></textarea><br>

        <input type='submit' value='Delete'>
        <input type="hidden" name="action" value="delete-review">
        <input type="hidden" name="reviewId" value="<?php if (isset($review[0]['reviewId'])) {
                                                        echo $review[0]['reviewId'];
                                                    } elseif (isset($reviewId)) {
                                                        echo $reviewId;
                                                    } ?>">
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>