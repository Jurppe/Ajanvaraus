<!DOCTYPE html>
<?php
$_SESSION['kayttaja_id'] = "";
include('functions.php');
unset($_SESSION['kayttaja_id']);
if (isset($_GET['login'])) {
    $username = pg_escape_string($_POST['username']);
    $userpassword = pg_escape_string($_POST['password']);

    $query = "SELECT kayttajatunnus, salasana FROM ajanvaraus.asiakas WHERE kayttajatunnus = '$username' AND salasana = '$userpassword'";

    $tulos = pg_query($query);
    $rows = pg_num_rows($tulos);

    if($rows == 1){
        echo 'kirjautuminen onnistui';

        $id_query = "SELECT asiakas_id FROM ajanvaraus.asiakas WHERE kayttajatunnus ='$username'";

        $id_result = pg_query($id_query);
        $id_rows = pg_fetch_array($id_result);

        $_SESSION['kayttaja_id'] = $id_rows[0];

        header("Location: reservation.php");
    }
    else {
        echo 'ei onnaa';
    }
}

?>

<html lang="fi">
<title>Sisäänkirjautuminen</title>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body style="background: darkslategrey">
<center>
<div class="w3-container w3-padding w3-display-middle">
    <div class="w3-container w3-teal">
        <h2>Sisäänkirjautuminen</h2>
    </div>

    <form class="w3-container" style="background: whitesmoke" action="?login" method="post">
        <label class="w3-text-teal"><b>Käyttäjätunnus</b></label>
        <input class="w3-input w3-border w3-light-grey" type="text" name="username">

        <label class="w3-text-teal"><b>Salasana</b></label>
        <input class="w3-input w3-border w3-light-grey" type="password" name="password">
        <br>
        <button type=submit class="w3-btn w3-blue-grey">Kirjaudu</button>
        <br>
    </form>
</div>
</center>
</body>
</html>