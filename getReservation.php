<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 40px;
            border-collapse: collapse;
            font-family: Tahoma, Geneva, sans-serif;
            border: 1px solid #1C6EA4;
            background-color: whitesmoke;
            text-align: center;
        }

        table, td, th {
            border: 1px solid black;
            padding: 5px;
        }

        th {text-align: left;}
    </style>
</head>
<body>

<?php
include_once 'functions.php';
if($q = strval($_GET['q'])) {
    $query = "SELECT asiakas.nimi, varaus.varaus_pvm, varaus.varaus_aika, tyontekija.tt_nimi 
            FROM ajanvaraus.varaus, ajanvaraus.asiakas, ajanvaraus.tyontekija 
              WHERE tyontekija.tt_id = varaus.tt_id AND asiakas.asiakas_id = varaus.asiakas_id AND varaus_pvm = '$q'";
    $result = pg_query($query);

    if (pg_num_rows($result) > 0) {
        echo "
    <table>
    <tr>
    <th>Vaaraaja</th>
    <th>Varauspvm</th>
    <th>Varausaika</th>
    <th>Tyontekija</th>
    </tr>";
        while ($row = pg_fetch_row($result)) {
            echo "<tr>";
            echo "<td>" . $row[0] . "</td>";
            echo "<td>" . $row[1] . "</td>";
            echo "<td>" . $row[2] . "</td>";
            echo "<td>" . $row[3] . "</td>";
            echo "</tr>";
        }
    } else {
        echo 'ei varattuja vuoroja';
        exit;
    }
}
else if($q = strval($_GET['date'])){
    $_SESSION['lastDate'] = $q;
    $query = "SELECT varaus_aika FROM ajanvaraus.varaus WHERE varaus_pvm = '$q'";
    $result = pg_query($query);
    unset($_SESSION['reserved_t']);
    $_SESSION['reserved_t'] = array();
    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_row($result)) {
            $_SESSION['reserved_t'][] = $row[0];
            echo $_SESSION['reserved_t'][0];
        }
    }
}
?>
</body>
</html>