<?php
if (isset($_GET["ID_Cust"])) {
    $ID_Cust = $_GET["ID_Cust"];

    $servername = "localhost:3306";
    $username = "root";
    $password = "darthcat@12se";
    $database = "servis";

    $connection = new mysqli($servername,$username,$password,$database);

    $sql1 = "UPDATE servis SET Status_Servis = 'On waiting list' WHERE ID_Cust= '$ID_Cust'";
    
    $connection->query($sql1); // 

}

//mendireksi user ke file (atau tampilan) index.php
header("location:/servis/servis.php");

//me exit looping
exit;
?>