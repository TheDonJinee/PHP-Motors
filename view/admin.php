<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<?php
if ($_SESSION['loggedin'] == false) {
    header("Location: /phpmotors/");
}
?>
<h1 class="adminTitle">
    <?php echo $_SESSION['clientData']['clientFirstname']; ?>
    <?php echo " "; ?>
    <?php echo $_SESSION['clientData']['clientLastname']; ?>
</h1>

<?php
if (isset($message)) {
    echo $message;
}

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
}
?>

<div class="adminData">
    <p>You are logged in.</p>
    <ul>
        <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname']; ?></li>
        <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
        <li>Email: <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
    </ul>


    <div class="adminManage">
        <div class="adminAccount admin">
            <h2>Account Management</h2>
            <p>Use this link to update account information.</p>
            <p><a href="/phpmotors/accounts/index.php/?action=client-update">Update Account Information</a></p>
        </div>

        <div class="adminInventory admin">
            <?php if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo '<h2>Inventory Management</h2>
                  <p>Use this link to manage the inventory.</p>
                  <p><a href="/phpmotors/vehicles/index.php">Vehicle Management</a></p>';
            }
            ?>
        </div>

        <div class="adminReview admin">
            <?php
            $clientId = $_SESSION['clientData']['clientId'];
            echo reviewsUser($clientId);
            ?>

        </div>

    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>