<?php
if (isset($_GET["No_Seri"])) {
    $No_Seri = $_GET["No_Seri"];

    $servername = "localhost:3306";
    $username = "root";
    $password = "darthcat@12se";
    $database = "servis";

    $connection = new mysqli($servername,$username,$password,$database);

    $sql1 = "DELETE from laptop where No_Seri= '$No_Seri'";
 
    $connection->query($sql1); // baru garansi


}

//mendireksi user ke file (atau tampilan) index.php
header("location:/servis/laptop.php");

//me exit looping
exit;
?>