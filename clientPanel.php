<?php


require_once("./src/connection.php");

if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
}

$clientId = $_SESSION['clientId'];

$client = Client::GetClientById($clientId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newFirstName = $_POST['newFirstName'];
    $newLastName = $_POST['newLastName'];
    $newEmail = $_POST['newEmail'];
    $newAddress = $_POST['newAddress'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    if (strlen(trim($newFirstName)) > 2) {
        if ($client->changeFirstName($newFirstName)) {
            echo("Imię zostało zmienione <br>");
        } else {
            echo("Nie udało się zmienić imienia <br>");
        }
    }
    if (strlen(trim($newLastName)) > 2) {
        if ($client->changeLastName($newLastName)) {
            echo("Nazwisko zostało zmienione <br>");
        } else {
            echo("Nie udało się zmienić nazwiska <br>");
        }
    }
    if (strlen(trim($newEmail)) > 4) {
        if ($client->changeEmail($newEmail)) {
            echo("Email został zmieniony <br>");
        } else {
            echo("Nie udało się zmienić emaila <br>");
        }
    }

    if (strlen(trim($newAddress)) > 5) {
        if ($client->changeAddress($newAddress)) {
            echo("Adres został zmieniony <br>");
        } else {
            echo("Nie udało się zmienić adresu <br> ");
        }
    }

    if (strlen(trim($oldPassword)) > 3) {
        if ($client->changePassword($oldPassword, $newPassword1, $newPassword2)) {
            echo("Hasło zostało zmienione <br>");
        } else {
            echo("Zmiana hasła nieudana <br>");
        }
    }

}
?>

<form action="#" method="post">
    <fieldset>
        <legend>Zmień dane:</legend>
        <p>
            <label>Zmień imię:
                <input type="text" name="newFirstName">
            </label>
        </p>
        <p>
            <label>Zmień nazwisko:
                <input type="text" name="newLastName">
            </label>
        </p>
        <p>
            <label>Zmień email:
                <input type="text" name="newEmail">
            </label>
        </p>
        <p>
            <label>Zmień adres:
                <textarea name="newAddress"></textarea>
            </label>
        </p>
    </fieldset>
    <fieldset>
        <legend>Zmień hasło:</legend>
        <p>
            <label>Obecne hasło:
                <input type="password" name="oldPassword">
            </label>
        </p>
        <p>
            <label>Nowe hasło:
                <input type="password" name="newPassword1">
            </label>
        </p>
        <p>
            <label>Nowe hasło:
                <input type="password" name="newPassword2">
            </label>
        </p>

    </fieldset>
    <input type="submit" value="Zmień">

</form>

<?php


$allClientOrders = $client->getAllMyOrders();
//var_dump($allClientOrders);

echo("<h2>Twoje zamówienia:</h2>");
$length = count($allClientOrders);

foreach($allClientOrders as $orderToShow){
    echo("<h3>Zamówienie numer: " . $length . "</h3>");
    echo("Status: " . $orderToShow->getStatus() . "</br>");
    echo("Suma: " .$orderToShow->getPriceSum() . "</br>");
    echo("<a href='orderSite.php?id={$orderToShow->getId()}'>Pokaż szczegóły</a>");
    $length--;
}