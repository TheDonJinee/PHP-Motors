<?php 

// Reviews Model

function insertReview($reviewText, $invId, $clientId) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO reviews (reviewText, invId ,clientId)
            VALUES (:reviewText, :invId , :clientId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

function getReviewItem($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT r.reviewId, r.reviewText, r.reviewDate, r.invId, r.clientId, c.clientFirstname, c.clientLastname 
            FROM reviews r
            JOIN clients c ON c.clientId = r.clientId
            WHERE invId = :invId
            ORDER BY r.reviewDate DESC';
    //Create the prepared statement using the PHP Motors connection
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    //Execute the statement
    $stmt->execute();
    //Will return an associative array if a match is found
    $reviewInfo = $stmt->fetchall(PDO::FETCH_ASSOC);
    //Close the database interaction
    $stmt->closeCursor();
    return $reviewInfo;
}

function getReviewClient($clientId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT r.reviewText, r.reviewDate, r.reviewId, c.clientFirstname, c.clientLastname, i.invModel, i.invMake
            FROM reviews r
            JOIN clients c ON r.clientId = c.clientId
            JOIN inventory i ON i.invId = r.invId
            WHERE r.clientId = :clientId
            ORDER BY reviewDate DESC';
    //Create the prepared statement using the PHP Motors connection
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    //Execute the statement
    $stmt->execute();
    //Will return an associative array if a match is found
    $reviewInfo = $stmt->fetchall(PDO::FETCH_ASSOC);
    //Close the database interaction
    $stmt->closeCursor();
    return $reviewInfo;
}

function getReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT r.reviewText, r.reviewDate, r.invId, r.clientId, c.clientFirstname, c.clientLastname, i.invModel, i.invMake
            FROM reviews r
            JOIN clients c ON c.clientId = r.clientId
            JOIN inventory i ON i.invId = r.invId
            WHERE reviewId = :reviewId' ;
    //Create the prepared statement using the PHP Motors connection
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    //Execute the statement
    $stmt->execute();
    //Will return an associative array if a match is found
    $reviewInfo = $stmt->fetchall(PDO::FETCH_ASSOC);
    //Close the database interaction
    $stmt->closeCursor();
    return $reviewInfo;
}

function updateReview($reviewId, $reviewText, $reviewDate) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET reviewText = :reviewText, reviewDate = :reviewDate
            WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function deleteReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
