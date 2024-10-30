<?php
session_start();

require_once __DIR__ . '/inc/configDB.inc.php';

# Übung User-Login mit Session und Header-Weiterleitung

/*
## Aufgabe:

- wenn die Formulardaten gesendet werden, soll der eingegebenen Benutzername und das Passwort überprüft werden
    - hier Simulation: wir prüfen gegen die Werte zweier definierter Variable ($loginname = 'Hans' und $password = 'ganzgeheim')

-> stimmen Loginname und Password überein soll in der Session zu einem Key 'name' der Benutzername und zu einem Key 'loggedin' der Wert TRUE gespeichert werden
    - anschließen soll auf die Seite 'loggedin.php' weitergeleitet werden und hier der User mit Namen begrüßt werden
    - auf der Seite 'loggedin.php' soll sichergestellt sein, dass der Benutzer auch wirklich eingeloggt ist 
        => anderenfalls soll er auf die Formularseite weitergeleitet werden

-> stimmen Loginname und Password nicht überein, sollen die eingegebenen Werte in die Formularfeldern eingetragen werden und zusätzlich ein Hinweis 'Die Kombination Benutzername und Password stimmen nicht überein in einem <p>-Element unterhalb der Formulars angezeigt werden

*/

$error = false;

if($_POST){
    $db = connectDB();

    $sql = 'SELECT password FROM users WHERE email = ?' ;
    $PDOStatement = $db->prepare($sql);
    $PDOStatement->execute([$_POST['email']]);
    
    $passwordHash = $PDOStatement->fetch();
/*    $passwordHash = $passwordHash['password'];*/
    
    if($passwordHash){
        if(password_verify($_POST['password'], $passwordHash['password'])){
            echo 'Du bist drin', PHP_EOL;
            exit;
        }
    }
    
    $error = true;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <h1>Login</h1>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset id="reg-data">
            <legend>Login</legend>
            <div>
                <label for="loginname">E-Mail: </label>
                <input type="text" name="email" id="email" value="<?= $email ?>" required>
            </div>
            <div>
                <label for="password">Passwort: </label>
                <input type="password" name="password" id="password" value="<?= $password ?>" required>
            </div>
        </fieldset>
        <fieldset>
            <legend>Aktion</legend>
            <div>
                <button type="submit">anmelden</button>
                <button type="reset">zurücksetzen</button>
            </div>
        </fieldset>
    </form>
    <?php if($error) : ?>
        <p>
            Die Kombination Benutzername und Password stimmen nicht überein 
        </p>
    <?php endif ?>
</body>

</html>