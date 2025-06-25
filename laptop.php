<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Servis Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>

        body{
            background-image: url('/servis/gambar/Screenshot 2023-05-25 131611.png');
            background-repeat: repeat;
        }

        .card-header{
            color: black;
            font-size: 200%;
        }

        tr.header_tabel{
            background-color: #e0dcdc;
            color: darkgrey;
        }

        .table-kontener{
            border-collapse: separate;
            border-spacing: 0px;
        }

        .tex{
            color: white;
            font-size: 300%;
        }
        
        .baten{
            background-color: black;
            border-radius: 50px;
        }

        .ngisi{
            border-radius: 20px;
        }

        .dropdown-toggle{
            background-color: black;
        }
        .prev{
            position: absolute;
            top: 93%;
            left: 10%;
            background-color: black;
        }

    </style>
</head>
<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>
<body>
    <div class="img"></div>
    <div class="container">
        <br><br><br>
        <h1 class="tex"> <b> Database Laptop Lists </b></h1>
        <br>
        <br>
        <br>
        <div>
        <table class="table-kontener">
        <thead>
            <tr>
                <th><form action="" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control ngisi shadow" placeholder="Input Series Number...">
                        </div>
                    </form>
                </th>
                <th><a class='mb-3 btn btn-dark btn-sm bottom-0 end-0 p-2 baten shadow' href='/servis/laptop.php'>Back To List</a></th>
                <th><a class='mb-3 btn btn-dark btn-sm bottom-0 end-0 p-2 baten shadow' href='/servis/isi-laptop.php'>Tambahkan Laptop</a></th>
            </tr>
        </thead>
    </table>
    </div>
        <div class="card">
            <div class="card-header bg-white ">
               <b>Laptop</b> 
            </div>
            <div class="card-body shadow">
                <table class="table">
                    <thead>
                        <tr class="header_tabel">
                            <th>Laptop Series Number</th>
                            <th>Name</th>
                            <th>Year Releases</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servername = "localhost:3306";
                        $username = "root";
                        $password = "darthcat@12se";
                        $database = "servis";

                        // membuat koneksi
                        $connection = new mysqli($servername, $username, $password, $database);
                        // cek koneksi
                        if ($connection->connect_error){
                            die("Connection failed: " . $connection->connect_error);
                        }

                        // baca semua row dari table servis
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        if (!empty($search)) {
                        $sql = "SELECT * from laptop
                        WHERE No_Seri = '$search';";    
                        } else{
                        $sql = "SELECT * from laptop;";
                        }
                        
                        $result = $connection->query($sql);

                        if (!$result){
                            die("Invalid query: " . $connection->error);
                        }

                        // membaca semua data dari tiap row
                        while($row = $result->fetch_assoc()){
                            $modalId = 'exampleModal' . $row['No_Seri']; // Generate unique modal id
                            
                            echo "
                            <tr>
                                <td>$row[No_Seri] </td>
                                <td>$row[Nama_Seri] </td>
                                <td>$row[Tanggal_Keluaran] </td>

                                <td>
                                    <a class='baten btn btn-primary btn-sm' href='/servis/edit-laptop.php?No_Seri=$row[No_Seri]'>Edit</a>
                
                                </td>
                            </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <input class="prev btn btn-dark shadow" type="button" value="< Previous" onclick="window.location.href='/servis/servis.php'">
</body>
</html>
