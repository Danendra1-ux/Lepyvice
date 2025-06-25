<?php

$servername = "localhost:3306";
$username = "root";
$password = "darthcat@12se";
$database = "servis";

//koneksi ke sql
$connection = new mysqli($servername, $username, $password, $database);


$No_Seri = "";
$Nama_Seri = "";
$Tanggal_Keluaran = "";

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["No_Seri"])) {
        header("Location: /servis/laptop.php");
        exit;
    }
    $No_Seri = $_GET["No_Seri"];

    // Fetch data from the database based on the id
    $sql = "SELECT * from laptop
        WHERE
        No_Seri = '$No_Seri'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    // Redirect user if no row is found
    if (!$row) {
        header("Location: /servis/laptop.php");
        exit;
    }

    // Assign values from the row to variables
    $Nama_Seri = $row["Nama_Seri"];
    $Tanggal_Keluaran = $row["Tanggal_Keluaran"];
    
} else {
    $No_Seri = $_POST["No_Seri"];
    $Nama_Seri = $_POST["Nama_Seri"];
    $Tanggal_Keluaran = $_POST["Tanggal_Keluaran"];
    

    do {
        if (empty($Tanggal_Keluaran) || empty($Nama_Seri) ) {
            $errorMessage = "Semua field harus diisi!";
            break;
        }

        // update customer
        $sqlupdate = "UPDATE laptop ".
                        "SET Nama_Seri = '$Nama_Seri', Tanggal_Keluaran = '$Tanggal_Keluaran'". 
                        "WHERE No_Seri = '$No_Seri'";

       


        $connection->query($sqlupdate);
        $successMessage = "Data berhasil diperbarui!";

        // Redirect the user to the index.php file or desired location
        header("location: /servis/laptop.php");
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
                <input type="hidden" name="No_Seri" value="<?php echo $No_Seri; ?>">
                    <!-- PENTINGGGGGGGGGGG -->
                    <!-- LINE ASU UDAH 5 JAMMMMM GABISA BISAAAA AKHIRNYA BISA KARENA LINEE INNIIIIIIIIII  -->
                    <!-- rizki 23-05-23 jam 00:55 telah tewas -->



                    <!-- buat insert tabel customer-->

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Seri</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Nama_Seri" value="<?php echo $Nama_Seri; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Year Releases</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control shadow" name="Tanggal_Keluaran"
                                value="<?php echo $Tanggal_Keluaran; ?>">
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
                            onclick="window.location.href='/servis/laptop.php'">
</body>

</html>