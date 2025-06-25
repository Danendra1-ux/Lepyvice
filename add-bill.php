<?php


$No_Servis = "";
$Kode_Garansi = "";
$Total_Biaya = "";
$Tarif_Jasa = "";
$Tarif_Spare_Part = "";
$Note = "";


    $servername = "localhost:3306";
    $username = "root";
    $password = "darthcat@12se";
    $database = "servis";

    $connection = new mysqli($servername,$username,$password,$database);

if (isset($_GET["Kode_Garansi"]) && isset($_GET["No_Servis"])) {
    $No_Servis = $_GET["No_Servis"];
    $Kode_Garansi = $_GET["Kode_Garansi"];
 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $Total_Biaya= $_POST["Total_Biaya"];
        $Tarif_Spare_Part = $_POST["Tarif_Spare_Part"];
        $Tarif_Jasa = $_POST["Tarif_Jasa"];
        $Note = $_POST["Note"];
        
    
        // looping isi if else error
        
            if ( empty($Tarif_Spare_Part) || empty($Tarif_Jasa)|| empty($Note) ) {
                $errorMessage = "Semua field harus diisi!";
                
            }else{
            
            $Total_Biaya = (int)$Tarif_Jasa + (int)$Tarif_Spare_Part;


            // Insert ke tabel tarif
            $sqlBill = "INSERT INTO tarif 
            VALUES (  '$Total_Biaya', '$Tarif_Spare_Part', '$Tarif_Jasa','$Kode_Garansi' ,'$No_Servis','$Note')";
            $sqlBill = $connection->query($sqlBill);

            if (!$sqlBill) {
            $errorMessage = "Invalid Query: " . $connection->error;
}

    
            $successMessage = "Customer dan garansi berhasil ditambahkan!";
    
            // redirect kalo udah ngisi
            header("location:/servis/servis.php");
            exit;
        }
    
    }
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
