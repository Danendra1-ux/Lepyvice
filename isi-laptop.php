<?php
$No_Seri = "";
$Nama_Seri = "";
$Tanggal_Keluaran = "";

$servername = "localhost:3306";
$username = "root";
$password = "darthcat@12se";
$database = "servis";

//koneksi ke sql
$connection = new mysqli($servername, $username, $password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $No_Seri = $_POST["No_Seri"];
    $Nama_Seri = $_POST["Nama_Seri"];
    $Tanggal_Keluaran = $_POST["Tanggal_Keluaran"];

    // looping isi if else error
    do {
        if (empty($No_Seri) || empty($Nama_Seri) || empty($Tanggal_Keluaran) ) {
            $errorMessage = "Semua field harus diisi!";
            break;
        }
        // cek kalo laptop sudah ada apa belum
        $checkQuery = "SELECT * FROM laptop WHERE No_Seri = '$No_Seri' ";
        $checkResult = $connection->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            $existingRecords = $checkResult->fetch_all(MYSQLI_ASSOC);
            foreach ($existingRecords as $record) {
                if ($record['No_Seri'] === $No_Seri) {
                    $errorMessage .= "Laptop sudah Ada di database! ";
                }
            }
            break;
        }

        // Insert ke tabel cutomer
        $sqllaptop = "INSERT INTO laptop (No_Seri,Nama_Seri, Tanggal_Keluaran) " .
            "VALUES ('$No_Seri','$Nama_Seri', '$Tanggal_Keluaran')";
        $sqllaptop = $connection->query($sqllaptop);

        if (!$sqllaptop) {
            $errorMessage = "Invalid Query: " . $connection->error;
            break;
        }

        $successMessage = "Customer dan garansi berhasil ditambahkan!";

        // redirect kalo udah ngisi
        header("location:/servis/laptop.php");
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
            <h1><b>Add laptop</b></h1>
            <p>Adding Laptop data...</p>
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
                    <label class="col-sm-3 col-form-label">Series Number</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="No_Seri" value="<?php echo $No_Seri; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Laptop Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Nama_Seri" value="<?php echo $Nama_Seri; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Date releases</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control shadow" name="Tanggal_Keluaran" value="<?php echo $Tanggal_Keluaran; ?>">
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
    <input class="prev btn btn-dark shadow" type="button" value="< Previous" onclick="window.location.href='/servis/laptop.php'">
</body>

</html>
