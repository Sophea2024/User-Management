<?php


require_once __DIR__ . '/inc/configDB.inc.php';

function validateEMail(string $email): bool {
    // $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function validateName(string $name): bool {
    //Filterfunktionalität für die Namenskriterien
    // Bespiel: Name muss mindesten 3 Zeichen und maximal 15 Zeichen lang sein
    if (mb_strlen($name) >= 3 && mb_strlen($name) <= 15) {
        return true;
    }
    return false;
}

function validatePassword(string $password): bool {
    // nicht implementiert
    return true;
}

function validate(array $formData = []): bool {
    if ($formData) {
        if (
            !empty($_POST['firstname']) &&
            !empty($_POST['lastname']) &&
            !empty($_POST['email']) &&
            !empty($_POST['password']) &&
            validateEMail($_POST['email']) &&
            validateName($_POST['firstname']) &&
            validateName($_POST['lastname']) &&
            validatePassword($_POST['password'])
        ) {
            return true;
        }
    }
    return false;
}

function saveUserData(array $user) {
    // 2do -prüfen Da

    $db = connectDB();

    $sql = "INSERT INTO users (firstname,lastname,  email, password) VALUES (:firstname, :lastname, :email, :password)";

    $PDOStatement = $db->prepare($sql);
    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    
    $PDOStatement->execute($user);

    header('location: userlogin.php', true, 307);
    exit;
}

if ($_POST) { 
    if (validate($_POST)) {
        // Funktionsaufruf zum Speichern der Daten
        saveUserData($_POST);
    }
} else {
    // 2do - hier jetzt Mitteilung an User, das alle Felder ausgefüllt werden sollen
    echo 'alle Felder ausfüllen';
}


?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierungsformular</title>
    <style>
        #reg-data {
            display: grid;
            grid-template-columns: max-content 15vw;
            column-gap: .5em;
            row-gap: .3em;
        }

        #reg-data div {
            display: grid;
            grid-column: 1 / 3;
            grid-template-columns: subgrid;
        }
    </style>
</head>

<body>
    <h1>Registrierungsformular</h1>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset id="reg-data">
            <legend>Registrierung</legend>
            <div>
                <label for="firstname">Vorname: </label>
                <input type="text" name="firstname" id="firstname" required>
            </div>
            <div>
                <label for="lastname">Nachname: </label>
                <input type="text" name="lastname" id="lastname" required>
            </div>
            <div>
                <label for="email">E-Mail: </label>
                <input type="text" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Passwort: </label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="pwd_wdh">Passwort wdh: </label>
                <input type="password" id="pwd_wdh" required>
            </div>
        </fieldset>
        <fieldset>
            <legend>Aktion</legend>
            <div>
                <button type="submit">registrieren</button>
                <button type="reset">zurücksetzen</button>
            </div>
        </fieldset>
    </form>
</body>

</html>