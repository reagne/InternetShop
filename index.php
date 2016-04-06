<?php

require_once("./src/connection.php");
require_once("./src/Header.php");

if(!(isset($_SESSION['clientId'])) && !(isset($_SESSION['adminId']))){
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $client = Client::LogInClient($_POST['email'], $_POST['password']);

        if ($client != FALSE) {
            $_SESSION['clientId'] = $client->getId();
            header("Location: showProduct.php?category=all");
        } else {
            $admin = Admin::LogInAdmin($_POST['email'], $_POST['password']);
            if ($admin != FALSE) {
                $_SESSION['adminId'] = $admin->getId();
                header("Location: panel.php");
            } else {
                echo("Niepoprawne dane logowania");
            }
        }
    }
    ?>
    <fieldset>
        <legend>Logowanie:</legend>
        <form action="index.php" method="post">
            <p>
                <label>
                    Email:
                    <input type="email" name="email">
                </label>
            </p>
            <p>
                <label>
                    Hasło:
                    <input type="password" name="password">
                </label>
            </p>
            <p>
                <input type="submit" value="Zaloguj sie">
            </p>
        </form>
    </fieldset>
    <p>
        Nie masz konta?
        <a href='register.php' name='register'>Zarejestuj się</a>
    </p>

    <?php
}
echo("Menu kategorii produktów i karuzela w connection menu.");
require_once("./src/Footer.php");