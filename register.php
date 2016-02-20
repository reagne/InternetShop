<?php

require_once("./src/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //zabezpieczyć żeby rzeczy nie były puste w środku metody register client. !!
    $client = Client::RegisterClient($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['address']);

    if ($client !== FALSE) {
        $_SESSION['clientId'] = $client->getId();
        //nie tworzy nam od razu sesji tylko nadal trzeba się zalogować. jak ma być?
        //jeszcze może być header po rejestracji na główną wyrzucać jak poprawne dane rejestracji były
        echo("Rejestracja udana. Możesz się zalogować");
        echo("<a href='index.php'>Przejdź na stronę główną</a>");
    } else {
        echo("Zle dane rejestracji");
    }
}

?>

<fieldset>
    <legend>Rejestracja:</legend>
    <form action="register.php" method="post">
        <p>
            <label>
                Imię:
                <input type="text" name="firstName">
            </label>
        </p>
        <p>
            <label>
                Nazwisko:
                <input type="text" name="lastName">
            </label>
        </p>
        <p>
            <label>
                Email:
                <input type="email" name="email">
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
        <p>
            <label>
                Adres: <br>
                Wypełnij według wzoru: <br><br>
                ul. Jagienki 6 <br>
                45-300 Kraków <br>
                <textarea name="address" cols="40" rows="5"></textarea>
            </label>
        </p>
        <p>
            <input type="submit" value="Zarejestruj sie">
        </p>
    </form>
</fieldset>
