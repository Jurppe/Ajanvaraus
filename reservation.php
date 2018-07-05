<?php
/**
 * Created by PhpStorm.
 * User: Mika
 * Date: 17/08/17
 * Time: 12:28
 */
include "functions.php";
if($_SESSION[kayttaja_id]==null) {
    echo "du måste logga inn";
    echo "<br>";
    echo '<a href="http://www.sis.uta.fi/~mj422392/ajanvaraus/"> Sisäänkirjautumiseen</a>';
    exit;
}
if($_GET['submit']) {
    $date = $_SESSION['lastDate'];
    $time = $_GET['time'];
    $message = $_GET['message'];
    $employee = $_GET['employee'];
    $customer_id = $_SESSION['kayttaja_id'];
    $insert = "INSERT INTO ajanvaraus.varaus(varaus_tehty,varaus_pvm,varaus_aika,asiakas_id,tt_id,viesti)
        VALUES(CURRENT_TIMESTAMP,'$date','$time',$customer_id,$employee,'$message')";
    if(!pg_query($insert)){
        echo 'Varauksen luonti epäonnistui';
        echo '<br>';
        echo pg_last_error($db);
    }
    else {
        echo 'Varaus luotu onnistuneesti';
    }
}
?>

<html>
<html lang="fi">
<title>Ajanvaraus</title>
<head>
    <meta charset="utf-8"/>
    <link href="calendar.css" type="text/css" rel="stylesheet"/>
    <link href="modal.css" type="text/css" rel="stylesheet"/>
    <script src="externalJS.js"></script>
</head>
<body>

<?php

include 'calendar.php';

$calendar = new Calendar();

echo $calendar->show();
?>
<h1 id ="demo" style="text-align: center"> Osoita hiirellä päivää, jolloin näät onko vapaita aikoja </h1>
<a href=index.php>Log Out</a>
</body>
<div id="overlay">
    <div>
        <h2 id="date" value=""></h2>
        <form name="newReservation" action="?newReservation">
            <h2>Ajanvaraus</h2>
            <p>Valitse työntekijä kelle haluat valita ajan</p>
            <select name="employee">
                <?php
                    $query = "SELECT tt_id, tt_nimi FROM ajanvaraus.tyontekija";
                    $result = pg_query($query);
                    while ($row = pg_fetch_row($result)) {
                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                ?>
            </select>
            <p>Valitse aika jonka haluat varata.</p>
            <select name="time">
                <?php

                    $time = '08:00';
                    $next_time = 60*30;
                    $new_time = strtotime($time);
                    $i = 0;

                    while($i < 17){
                        $h24_time = date('H:i:s',$new_time);
                        $j = 0;
                        $found = false;
                        while($_SESSION['reserved_t'][$j]!=null) {
                            if($h24_time == $_SESSION['reserved_t'][$j]) {
                                $found = true;
                            }
                            $j++;
                        }
                        if($found == false) {
                            echo '<option value="' . $h24_time . '">' . $h24_time . '</option>';
                        }
                        $new_time+=$next_time;
                        $i += 1;
                    }
                    unset($_SESSION['reserved_t']);
                ?>
            </select>
            <br>
            <p>Jätä vapaavalintainen viesti</p>
            <textarea name="message" rows="4" cols="20">Vapaa viesti</textarea>
            <br>
            <input type="submit" name="submit">
            <hr>Click here to [<a href='#' onclick='overlay()'>close</a>]

        </form>
    </div>
</div>
</html>
