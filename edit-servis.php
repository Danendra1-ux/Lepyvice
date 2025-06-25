<?php

$servername = "localhost:3306";
$username = "root";
$password = "darthcat@12se";
$database = "servis";

//koneksi ke sql
$connection = new mysqli($servername, $username, $password, $database);

//variabel dari tabel garansi
$Kode_Garansi = "";
$Jenis_Garansi = "";
$Lama_Garansi = "";
//data pribadi customer
$ID_Cust = "";
$Alamat_Cust = "";
$No_Seri = "";
$Nama_Cust = "";
$No_Telp = "";
//error message dan message berhasil
$errorMessage = "";
$successMessage = "";

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["ID_Cust"])) {
        header("Location: /servis/servis.php");
        exit;
    }
    $ID_Cust = $_GET["ID_Cust"];

    // Fetch data from the database based on the id
    $sql = "SELECT
        customer.ID_Cust,
        customer.Nama_Cust,
        customer.No_Telp,
        customer.Alamat_Cust,
        customer.No_Seri,
        garansi.Kode_Garansi,
        garansi.Jenis_Garansi,
        garansi.Lama_Garansi
        FROM
        customer
        JOIN garansi ON customer.ID_Cust = garansi.ID_Cust
        WHERE
        customer.ID_Cust = '$ID_Cust'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    // Redirect user if no row is found
    if (!$row) {
        header("Location: /servis/servis.php");
        exit;
    }

    // Assign values from the row to variables
    $Kode_Garansi = $row["Kode_Garansi"];
    $Jenis_Garansi = $row["Jenis_Garansi"];
    $Lama_Garansi = $row["Lama_Garansi"];
    $No_Seri = $row["No_Seri"];
    $Nama_Cust = $row["Nama_Cust"];
    $Alamat_Cust = $row["Alamat_Cust"];
    $No_Telp = $row["No_Telp"];
} else {
    $ID_Cust = $_POST["ID_Cust"];
    // garansi
    $Kode_Garansi = $_POST["Kode_Garansi"];
    $Jenis_Garansi = $_POST["Jenis_Garansi"];
    $Lama_Garansi = $_POST["Lama_Garansi"];
    // customer
    $No_Seri = $_POST["No_Seri"];
    $Nama_Cust = $_POST["Nama_Cust"];
    $Alamat_Cust = $_POST["Alamat_Cust"];
    $No_Telp = $_POST["No_Telp"];

    do {
        if (empty($Jenis_Garansi) || empty($Lama_Garansi) || empty($No_Seri) || empty($Nama_Cust) || empty($Alamat_Cust) || empty($No_Telp) || empty($Kode_Garansi)) {
            $errorMessage = "Semua field harus diisi!";
            break;
        }

        // update customer
        $sqlCustomer = "UPDATE customer ".
                        "SET Nama_Cust = '$Nama_Cust', Alamat_Cust = '$Alamat_Cust', No_Telp = '$No_Telp', No_Seri = '$No_Seri'". 
                        "WHERE ID_Cust = '$ID_Cust'";

        // update garansi
        $sqlGaransi = "UPDATE garansi ".
                       "SET Kode_Garansi = '$Kode_Garansi', Jenis_Garansi = '$Jenis_Garansi', Lama_Garansi = '$Lama_Garansi' ".
                       "WHERE ID_Cust = '$ID_Cust'";


        $connection->query($sqlGaransi);
        $connection->query($sqlCustomer);



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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            background-image: url('/servis/gambar/Screenshot 2023-05-25 131611.png');
            background-repeat: repeat;
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
            <h1><b>Edit Data</b></h1>
            <p>Editing Customer Data...</p>
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


                    <!-- PENTINGGGGGGGGGGGGG -->
                <input type="hidden" name="ID_Cust" value="<?php echo $ID_Cust; ?>">
                    <!-- PENTINGGGGGGGGGGG -->
                    <!-- LINE ASU UDAH 5 JAMMMMM GABISA BISAAAA AKHIRNYA BISA KARENA LINEE INNIIIIIIIIII  -->
                    <!-- rizki 23-05-23 jam 00:55 telah tewas -->



                    <!-- buat insert tabel customer-->

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Customer</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Nama_Cust" value="<?php echo $Nama_Cust; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Alamat Customer</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Alamat_Cust"
                                value="<?php echo $Alamat_Cust; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">No HP Customer</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="No_Telp" value="<?php echo $No_Telp; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">No Seri Laptop</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="No_Seri" value="<?php echo $No_Seri; ?>">
                        </div>
                    </div>

                    <!-- buat insert tabel garansi -->

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode Garansi</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Kode_Garansi"
                                value="<?php echo $Kode_Garansi; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Jenis Garansi</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Jenis_Garansi"
                                value="<?php echo $Jenis_Garansi; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Lama Garansi laptop</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Lama_Garansi"
                                value="<?php echo $Lama_Garansi; ?>">
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
    <input class="prev btn btn-dark shadow" type="button" value="< Previous"
                            onclick="window.location.href='/servis/servis.php'">
</body>

</html>