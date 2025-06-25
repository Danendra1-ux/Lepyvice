<?php
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
//variabel dari tabel servis
$No_Servis = "";
$Alamat_Servis = "";
$Kerusakan = "";
$Status_Servis = "";
//error message dan message berhasil
$errorMessage = "";
$successMessage = "";

$servername = "localhost:3306";
$username = "root";
$password = "darthcat@12se";
$database = "servis";

//koneksi ke sql
$connection = new mysqli($servername, $username, $password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Kode_Garansi = $_POST["Kode_Garansi"];
    $Jenis_Garansi = $_POST["Jenis_Garansi"];
    $Lama_Garansi = $_POST["Lama_Garansi"];
    $No_Seri = $_POST["No_Seri"];
    $Nama_Cust = $_POST["Nama_Cust"];
    $Alamat_Cust = $_POST["Alamat_Cust"];
    $No_Telp = $_POST["No_Telp"];
    $Alamat_Servis = $_POST["Alamat_Servis"];
    $Kerusakan = $_POST["Kerusakan"];

    // looping isi if else error
    do {
        if (empty($Jenis_Garansi) || empty($Lama_Garansi) || empty($No_Seri) || empty($Nama_Cust) || empty($Alamat_Cust) || empty($No_Telp)|| empty($Kode_Garansi)||empty($Alamat_Servis)|| empty($Kerusakan)) {
            $errorMessage = "Semua field harus diisi!";
            break;
        }
        // cek kalo email dan no hp sudah ada apa belum
        $checkQuery = "SELECT * FROM garansi WHERE Kode_Garansi = '$Kode_Garansi' ";
        $checkResult = $connection->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            $existingRecords = $checkResult->fetch_all(MYSQLI_ASSOC);
            foreach ($existingRecords as $record) {
                if ($record['Kode_Garansi'] === $Kode_Garansi) {
                    $errorMessage .= "Garansi Laptop sudah terdaftar! ";
                }
            }
            break;
        }

        //UUID Buat ID_Cust sama No_Servis
        $ID_Cust = substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
        $No_Servis = substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);

        // Insert ke tabel cutomer
        $sqlCustomer = "INSERT INTO customer (ID_Cust,Nama_Cust, Alamat_Cust, No_Telp, No_Seri) " .
            "VALUES ('$ID_Cust','$Nama_Cust', '$Alamat_Cust', '$No_Telp', '$No_Seri')";
        $resultCustomer = $connection->query($sqlCustomer);

        if (!$resultCustomer) {
            $errorMessage = "Invalid Query: " . $connection->error;
            break;
        }

        // Insert ke tabel garansi
        $sqlGaransi = "INSERT INTO garansi (Kode_Garansi, Jenis_Garansi, ID_Cust, Lama_Garansi) " .
            "VALUES ('$Kode_Garansi', '$Jenis_Garansi', '$ID_Cust', '$Lama_Garansi')";
        $resultGaransi = $connection->query($sqlGaransi);

        if (!$resultGaransi) {
            $errorMessage = "Invalid Query: " . $connection->error;
            break;
        }

        //query insert into ke tabel servis

        $sqlServis = "INSERT INTO servis (No_Servis,Alamat_Servis, Kerusakan, Status_Servis, ID_Cust) " .
            "VALUES ('$No_Servis','$Alamat_Servis', '$Kerusakan', 'Just added', '$ID_Cust')";
        $resultServis = $connection->query($sqlServis);

        if (!$resultServis) {
            $errorMessage = "Invalid Query: " . $connection->error;
            break;
        }

        $successMessage = "Customer dan garansi berhasil ditambahkan!";

        // redirect kalo udah ngisi
        header("location:/servis/servis.php");
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
            <h1><b>Add transaction</b></h1>
            <p>Customer data registration.</p>
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

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

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
                        <input type="text" class="form-control shadow" name="Alamat_Cust" value="<?php echo $Alamat_Cust; ?>">
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
                        <input type="text" class="form-control shadow" name="Kode_Garansi" value="<?php echo $Kode_Garansi; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Jenis Garansi</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Jenis_Garansi" value="<?php echo $Jenis_Garansi; ?>">
                    </div>
                </div>

                <!-- jan sentuh -->
                <input type="hidden" name="ID_Cust" value="<?php echo $cust_id; ?>">

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Lama Garansi laptop</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Lama_Garansi" value="<?php echo $Lama_Garansi; ?>">
                    </div>
                </div>

                <!-- buat insert tabel servis -->

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Alamat cabang laptop diservis</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Alamat_Servis" value="<?php echo $Alamat_Servis; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kerusakan Pada Laptop</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Kerusakan" value="<?php echo $Kerusakan; ?>">
                    </div>
                </div>
                <div class="position-absolute bottom-0 end-0 p-2 ">
                <input class="baten btn btn-primary shadow" type="submit" value="Submit">
                <input class="baten btn btn-warning shadow" type="reset" value="Reset">
                </div>
            </div>
        </form>
    </div>
    </div>
    <input class="prev btn btn-dark" type="button" value="< Previous" onclick="window.location.href='/servis/servis.php'">
</body>

</html>
