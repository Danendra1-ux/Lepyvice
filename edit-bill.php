<?php

$servername = "localhost:3306";
$username = "root";
$password = "darthcat@12se";
$database = "servis";

//koneksi ke sql
$connection = new mysqli($servername, $username, $password, $database);


$No_Servis = "";
$Kode_Garansi = "";
$Total_Biaya = "";
$Tarif_Jasa = "";
$Tarif_Spare_Part = "";
$Note = "";

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["No_Servis"])) {
        header("Location: /servis/servis.php");
        exit;
    }
    $No_Servis = $_GET["No_Servis"];
    

    // Fetch data from the database based on the id
    $sql = "SELECT * from tarif
        WHERE
        No_Servis = '$No_Servis'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    // Redirect user if no row is found
    if (!$row) {
        header("Location: /servis/servis.php");
        exit;
    }

    // Assign values from the row to variables
    $Total_Biaya= $row["Total_Biaya"];
    $Tarif_Spare_Part = $row["Tarif_Spare_Part"];
    $Tarif_Jasa = $row["Tarif_Jasa"];
    $Note = $row["Note"];
    
} else {
    $No_Servis = $_POST["No_Servis"];
    $Total_Biaya= $_POST["Total_Biaya"];
    $Tarif_Spare_Part = $_POST["Tarif_Spare_Part"];
    $Tarif_Jasa = $_POST["Tarif_Jasa"];
    $Note = $_POST["Note"];
    

    do {
        if ( empty($Tarif_Spare_Part) || empty($Tarif_Jasa)|| empty($Note) ) {
            $errorMessage = "Semua field harus diisi!";
            break;
        }

        $Total_Biaya = (int)$Tarif_Jasa + (int)$Tarif_Spare_Part;

        // update customer
        $sqlupdate = "UPDATE tarif ".
                        "SET Total_Biaya = '$Total_Biaya', Tarif_Spare_Part = '$Tarif_Spare_Part', Tarif_Jasa = '$Tarif_Jasa',Note = '$Note'". 
                        "WHERE No_Servis = '$No_Servis'";

       


        $connection->query($sqlupdate);
        $successMessage = "Data berhasil diperbarui!";

        // Redirect the user to the index.php file or desired location
        header("location: /servis/servis.php");
        exit;

    } while (false);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coba</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src ="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            background-image: url('/servis/gambar/Screenshot 2023-05-25 131611.png');
            background-repeat: no-repeat;
        }

        .konten{
            position: absolute;
            top: 43%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .header-tabel {
            color: white;
        }

        .header-tabel b{
            font-size: 150%;
        }

        .card{
            background-color: #98acd4;
        }

        .card label{
            color: white;
            font-size: 120%;
        }

        input {
            border: 2px solid red;
            padding: 5px;
            border-radius: 5px;
        }
  
        input[type="text"] {
            background-color: #98acd4;
            color: white;
        }

        input[type="number"]{
            background-color: #98acd4;
            color: white;
        }

        .prev{
            position: absolute;
            top: 93%;
            left: 10%;
            background-color: black;
        }

        .baten{
            border-radius: 20px;
        }

        .btn-primary{
            background-color: #88bccc;
            border-color: #88bccc;
        }

        .btn-warning{
            background-color: #98acd4;
            border-color: #98acd4;
        }

        .form-control{
            border-color: #98acd4;
        }
    </style>
</head>

<body>
    <div class="container konten">
    <div class="header-tabel">
            <h1><b>Add bill</b></h1>
            <p>Adding Customer Bill...</p>
            <br>
        </div>
    <div class="card">
        <div class="card-body shadow">
            <?php if (!empty($errorMessage)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php } ?>
            <?php if (!empty($successMessage)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $successMessage; ?>
                </div>
            <?php } ?>

            <!-- text box -->

            <form method="POST">
            <input type="hidden" name="No_Servis" value="<?php echo $No_Servis; ?>">
            <input type="hidden" name="Kode_Garansi" value="<?php echo $Kode_Garansi; ?>">

                <!-- buat insert tabel customer-->

            <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tarif Spare Part</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control shadow" name="Tarif_Spare_Part" value="<?php echo $Tarif_Spare_Part; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tarif jasa</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control shadow" name="Tarif_Jasa" value="<?php echo $Tarif_Jasa; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Note</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Note" value="<?php echo $Note; ?>">
                    </div>
                </div>
                <div class="position-absolute bottom-0 end-0 p-2">
                <input class="baten btn btn-primary shadow" type="submit" value="Submit">
                <input class="baten btn btn-warning shadow" type="reset" value="Reset">
                </div>
            </div>
        </form>
    </div>
    </div>
    <input class="prev btn btn-dark shadow" type="button" value="< Previous" onclick="window.location.href='/servis/servis.php'">
</body>

</html>
