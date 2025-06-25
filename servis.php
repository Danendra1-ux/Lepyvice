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

        hr{
            height: 2px;
            border-width: 0;
            color: black;
            background-color: black;
        }

        .aksi {
            height: 38px;
            justify-content: center;
            line-height: 27px;
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
        <h1 class="tex"> <b> Customer Lists </b></h1>
        <br>
        <br>
        <p> <b>All transaction</b> </p>
        <hr>
        <br>
        <div>
        <table class="table-kontener">
        <thead>
            <tr>
                <th><form action="" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" id="search-input" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control ngisi shadow" placeholder="Input Service Number...">
                            
                        </div>
                    </form>
                </th>
                <th><a class='mb-3 btn btn-dark btn-sm bottom-0 end-0 p-2 baten shadow' href='/servis/servis.php'>Back To List</a></th>
                <th><a class='mb-3 btn btn-dark btn-sm bottom-0 end-0 p-2 baten shadow' href='/servis/isi-data.php'>Tambahkan Data</a></th>
                <th><a class='mb-3 btn btn-dark btn-sm bottom-0 end-0 p-2 baten shadow' href='/servis/laptop.php'>Database Laptop</a></th>
            </tr>
        </thead>
    </table>
    </div>
        <div class="card">
            <div class="card-header bg-white ">
               <b>Service Lists</b> 
            </div>
            <div class="card-body shadow">
                <table class="table">
                    <thead>
                        <tr class="header_tabel">
                            <th>Service Number</th>
                            <th>Customer</th>
                            <th>Laptop</th>
                            <th>Warranty</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Tarif</th>
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
                        $sql = "SELECT
                        
                        customer.ID_Cust,
                        customer.Nama_Cust,
                        customer.No_Telp,
                        customer.Alamat_Cust,
                        customer.No_Seri,
                        
                        garansi.Kode_Garansi,
                        garansi.Jenis_Garansi,
                        garansi.Lama_Garansi,
                        
                        servis.No_Servis,
                        servis.Alamat_Servis,
                        servis.Kerusakan,
                        servis.Status_Servis,
                        
                        laptop.Nama_Seri

                        FROM

                        customer
                        JOIN garansi ON customer.ID_Cust = garansi.ID_Cust
                        JOIN servis ON garansi.ID_Cust = servis.ID_Cust
                        JOIN laptop ON customer.No_Seri = laptop.No_Seri
                        WHERE servis.No_Servis = '$search';";    
                        } else{
                        $sql = "SELECT
                        
                        customer.ID_Cust,
                        customer.Nama_Cust,
                        customer.No_Telp,
                        customer.Alamat_Cust,
                        customer.No_Seri,
                        
                        garansi.Kode_Garansi,
                        garansi.Jenis_Garansi,
                        garansi.Lama_Garansi,
                        
                        servis.No_Servis,
                        servis.Alamat_Servis,
                        servis.Kerusakan,
                        servis.Status_Servis,
                        
                        laptop.Nama_Seri

                        FROM

                        customer
                        JOIN garansi ON customer.ID_Cust = garansi.ID_Cust
                        JOIN servis ON garansi.ID_Cust = servis.ID_Cust
                        JOIN laptop ON customer.No_Seri = laptop.No_Seri;";
                        }
                        
                        $result = $connection->query($sql);

                        if (!$result){
                            die("Invalid query: " . $connection->error);
                        }

                        // membaca semua data dari tiap row
                        while($row = $result->fetch_assoc()){
                            $modalId = 'exampleModal' . $row['No_Servis']; // Generate unique modal id
                            
                            echo "
                            <tr>
                                <td>$row[No_Servis] </td>
                                <td>$row[Nama_Cust] <br>
                                    $row[ID_Cust]   </td>
                                <td>$row[Nama_Seri] <br>
                                    $row[No_Seri]   </td>
                                <td>$row[Kode_Garansi]</td>
                                <td><div class='dropdown'>
                                <button class='btn btn-dark dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                $row[Status_Servis]
                                </button>
                                <ul class='dropdown-menu'>
                                  <li><a class='dropdown-item' href='/servis/dropdon/just_added.php?ID_Cust=$row[ID_Cust]'>Just added</a></li>
                                  <li><a class='dropdown-item' href='/servis/dropdon/on_waiting_list.php?ID_Cust=$row[ID_Cust]'>On waiting list</a></li>
                                  <li><a class='dropdown-item' href='/servis/dropdon/rejected.php?ID_Cust=$row[ID_Cust]'>Rejected</a></li>
                                  <li><a class='dropdown-item' href='/servis/dropdon/on_progress.php?ID_Cust=$row[ID_Cust]'>On progress</a></li>
                                  <li><a class='dropdown-item' href='/servis/dropdon/fixed.php?ID_Cust=$row[ID_Cust]'>Fixed</a></li>
                                  <li><a class='dropdown-item' href='/servis/dropdon/ready_to_be_pickup.php?ID_Cust=$row[ID_Cust]'>Ready to be pickup</a></li>
                                  <li><a class='dropdown-item' href='/servis/dropdon/on_delivery.php?ID_Cust=$row[ID_Cust]'>On delivery</a></li>
                                </ul>
                              </div></td>
                                <td>
                                    <a class='aksi btn btn-primary btn-sm' href='/servis/edit-servis.php?ID_Cust=$row[ID_Cust]'>Edit</a>
                                    <a class='aksi btn btn-danger btn-sm' href='/servis/delete-servis.php?ID_Cust=$row[ID_Cust]&No_Servis=$row[No_Servis]'>Delete</a>
                                    <!-- Button trigger modal -->
                                    <a href='#' class=' btn btn-primary' data-bs-toggle='modal' data-bs-target='#$modalId'>Info</a>

                                    <!-- Modal -->
                                    <div class='modal fade modal-lg' id='$modalId' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Informasi Servis</h1>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                        <h4>Informasi Customer</h4>
                                            <p>ID Customer : $row[ID_Cust] <br>
                                            Nama Customer : $row[Nama_Cust] <br>
                                            Alamat Customer : $row[Alamat_Cust] <br>
                                            Nomor Telpon Customer : $row[No_Telp] </p>
                                            
                                        <h4>Informasi Laptop</h4>
                                            <p>Nama Seri Laptop : $row[Nama_Seri] <br>
                                            Nomor Nomor Seri : $row[No_Seri] </p>

                                        <h4>Informasi Garansi</h4>
                                            <p>Kode Garansi : $row[Kode_Garansi]<br>
                                            Jenis Garansi : $row[Jenis_Garansi] <br>
                                            Lama Garansi : $row[Lama_Garansi] </p>
                                        
                                        <h4>Informasi Servis Lebih Rinci</h4>
                                            <p>Nomor Servis : $row[No_Servis]<br>
                                            Alamat Tempat Servis : $row[Alamat_Servis] <br>
                                            Kerusakan Pada Laptop : $row[Kerusakan] <br>
                                            Status Servis : $row[Status_Servis] </p>    
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                                <td><div class='dropdown'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                Bill
                                </button>
                                <ul class='dropdown-menu'>
                                  <li><a class='dropdown-item' href='/servis/add-bill.php?Kode_Garansi=$row[Kode_Garansi]&No_Servis=$row[No_Servis]'>Add Bill</a></li>
                                  <li><a class='dropdown-item' href='/servis/edit-bill.php?No_Servis=$row[No_Servis]'>Edit Bill</a></li>
                                  <li><a class='dropdown-item' href='/servis/show-bill.php?No_Servis=$row[No_Servis]'>Show Bil</a></li>
                                </ul>
                              </div>
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
    
</body>
</html>
