<?php

require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}
require_once("./src/Header.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $admin = Admin::RegisterAdmin($email, $_POST['password1'], $_POST['password2']);

    if($admin != FALSE) {
        echo("Administrator dodany");
    } else {
        echo("Nie udało się dodać administratora");
    }
}

?>

<form method="post">
    <p>
        <label>
            Email:
            <input type="text" name="email">
        </label>
    </p>
    <p>
        <label>
            Hasło:
            <input type="password" name="password1">
        </label>
    </p>
    <p>
        <label>
            Powtórz hasło:
            <input type="password" name="password2">
        </label>
    </p>
    <input type="submit" value="Dodaj">
</form>
<?php
require_once("./src/Footer.php");
?>