<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<h1> Sign in </h1>

<?php
if (isset($message)) {
    echo $message;
}
?>
<div class="loginForm">

    <form method="post" action="/phpmotors/accounts/">

        <label for="clientEmail">Email</label><br>
        <input type="email" id="email" name="clientEmail" placeholder="someone@gmail.com" required><br>
        <br>
        <label for="clientPassword">Password</label>
        <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</p>
        <input type="password" id="password" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br>
        <br>
        <input type="submit" value="Sign-In">
        <input type="hidden" name="action" value="Login">
    </form>
    <br>
    <span><a href="/phpmotors/accounts/index.php?action=registration-page">Not a member yet?</a></span>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>