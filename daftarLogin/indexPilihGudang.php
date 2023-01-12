<?php
include_once '../koneksi.php';
session_start();

?>

<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
	<link rel="stylesheet" href="pilihGudang.css">

	<!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <section class="fitur" data-aos="fade-up">
        <div class="container">
        <div class="row text-left mb-4" >
            <div class="col judul">
            <h4>Pilih Gudang</h4>
            </div>
        </div>
        <div class="row justify-content-center text-center" id="fitur">
            
                <?php
                	$idUser = $_SESSION['idUser'];
                	$hasil = mysqli_query($conn, "SELECT * FROM gudang WHERE id_user = '$idUser'");
					while($row = mysqli_fetch_array($hasil)):
				?>
                    <a class ="col-md-3" style="text-decoration: none;" href="pilihGudang.php?id=<?= $row['id_gudang']; ?>">
                    <h6><?=$row['namaGudang']?></h6>
                    <img src="box.png" alt="" width="110">
                    <p style="padding-top: 10px">
                    <?php
                        $idGudang = $row['id_gudang'];
                        $hasil1 = mysqli_query($conn, "SELECT COUNT(*) FROM product WHERE id_gudang = '$idGudang'");
                        $row1 = mysqli_fetch_array($hasil1);
                        echo $row1[0];

                    ?>
                    </p>
                    </a>
                <?php endwhile ?>
            
        </div>
        </div>
    </section>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- Fontawesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    
   
    </body>
    </html>