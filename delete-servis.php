<?php
if (isset($_GET["ID_Cust"]) && isset($_GET["No_Servis"])) {
    $ID_Cust = $_GET["ID_Cust"];
    $No_Servis = $_GET["No_Servis"];

    $servername = "localhost:3306";
    $username = "root";
    $password = "darthcat@12se";
    $database = "servis";

    $connection = new mysqli($servername,$username,$password,$database);

    $sql0 = "DELETE from tarif where No_Servis= '$No_Servis'";
    $sql1 = "DELETE from garansi where ID_Cust= '$ID_Cust'";
    $sql2 = "DELETE from customer where ID_Cust= '$ID_Cust'";
    $sql3 = "DELETE from servis where No_Servis= '$No_Servis'";
    
    $connection->query($sql0); // ngapus servis dulu
    $connection->query($sql3); // ngapus servis dulu
    $connection->query($sql1); // baru garansi
    $connection->query($sql2); // yang terakhir customer

}

//mendireksi user ke file (atau tampilan) index.php
header("location:/servis/servis.php");

//me exit looping
exit;
?>