<?php
/**
 * Created by PhpStorm.
 * User: Mika
 * Date: 17/08/17
 * Time: 11:33
 */

// PSQL
$host        = "host=dbstud2.sis.uta.fi";
$port        = "port=5432";
$dbname      = "dbname=mj422392";
$credentials = "user=mj422392 password=123moimoi";

$db = pg_connect( "$host $port $dbname $credentials"  );
if(!$db){
    echo "Error : Unable to open database\n";
}
session_start();

function getReservations(){
    $q = intval($_GET['q']);
    $query = "SELECT varaus_aika FROM ajanvaraus.varaus WHERE varaus_pvm = $q";
    $result = pg_query($query);
    if(pg_num_rows($result)>0) {
        while ($row = pg_fetch_row($result)) {
            echo '$row[0]';
        }
    }
    else {
        echo 'ei varattuja vuoroja';
        exit;
    }
}

?>