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

        .container{
            position: absolute;
            top: 30%;
            left: 37%;
            width: 25%;
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

        tr{
            font-size: 150%;
            border-top: 0;
        }
    </style>
</head>
<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>
<body>
    <div class="img"></div>
    <div class="container">
        <div class="card">
            <div class="card-header bg-white ">
               <b>Invoice</b> 
            </div>
            <div class="card-body shadow">
                <table class="table">
                    <thead>
                        <tr class="header_tabel">
                            <th>Billing type</th>
                            <th>Price</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ( isset($_GET["No_Servis"])) {
                            $No_Servis = $_GET["No_Servis"];
                        
                            $servername = "localhost:3306";
                            $username = "root";
                            $password = "darthcat@12se";
                            $database = "servis";
                        
                            $connection = new mysqli($servername,$username,$password,$database);
                        
                            $sql1 = "SELECT * from tarif where No_Servis= '$No_Servis'";
                            
                            $result = $connection->query($sql1);
                            
                            if (!$result){
                                die("Invalid query: " . $connection->error);
                            }
                           
                        
                        }

                        // membaca semua data dari tiap row
                        while($row = $result->fetch_assoc()){
                            $modalId = 'exampleModal' . $row['No_Servis']; // Generate unique modal id
                            
                            echo "
                            <tr>
                                <td>Tarif Spare Part : </td>
                                <td>Rp.$row[Tarif_Spare_Part] </td>
                                <td>$row[Note] </td>
                            </tr>
                            <tr>
                                <td>Tarif Jasa : </td>
                                <td>Rp.$row[Tarif_Jasa]</td>
                            </tr>
                            <tr>
                                <td>Total: </td>
                                <td>Rp.$row[Total_Biaya] </td>
                            </tr>
                            <tr></tr>
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
