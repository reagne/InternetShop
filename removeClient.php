<?php

require_once("./src/connection.php");

if (!isset($_SESSION['clientId']) && !(isset($_SESSION['adminId']))) {
    header("Location: index.php");
}

$clientId = $_SESSION['clientId'];

if (isset($_SESSION['adminId'])) {
    $clientId = $_GET['id'];
}

$client = Client::GetClientById($clientId);

?>

<form method='post'>
    <label>Jesteś pewny, że chcesz usunąć konto?
        <input type='submit' value='Tak'></label>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($client->removeClient()) {
        echo("Usunięto");
        if(isset($_SESSION['clientId'])) {
            unset($_SESSION['clientId']);
        }
    } else {
        echo("Nie udało się usunąć użytkownika");
    }

}

?>



