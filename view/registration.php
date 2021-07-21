<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<h1> Register</h1>

<?php
if (isset($message)) {
    echo $message;
}
?>
<div class="registrationForm">

    <form action="/phpmotors/accounts/index.php" method="post">
        <label for="clientFirstname">First Name</label><br>
        <input type="text" name="clientFirstname" id="clientFirstname" <?php
                                                                        if (isset($clientFirstname)) {
                                                                            echo "value='$clientFirstname'";
                                                                        }
                                                                        ?> required><br>

        <label for="clientLastname">Last Name</label><br>
        <input type="text" name="clientLastname" id="clientLastname" <?php
                                                                        if (isset($clientLastname)) {
                                                                            echo "value='$clientLastname'";
                                                                        }
                                                                        ?> required><br>

        <label for="clientEmail">Email</label><br>
        <input type="email" name="clientEmail" id="clientEmail" required placeholder="Enter a valid email address" <?php
                                                                                                                    if (isset($clientEmail)) {
                                                                                                                        echo "value='$clientEmail'";
                                                                                                                    }
                                                                                                                    ?>><br>

        <label for="clientPassword">Password</label>
        <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</p>
        <input type="password" name="clientPassword" id="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br>
        
        <input type="submit" name="submit" value="Register">
        <input type="hidden" name="action" value="register">
    </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>