<?php 
    require_once 'connection.php'; 
?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
	<link rel="stylesheet" href="style.css">

	<!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>


<div class="wrapper">
	
 <nav id="sidebar">
 	
 	 <div class="sidebar-header">	
 	 	<h3><img src="image/logo.png" width="35" height="100%" class="d-inline-block align-top"> eBox</h3>
 	 </div>
 	 <ul class="list-unstyled components">

			<p align="center">Betamart</p>
 	 	 	 	<li>
 	 				<a href="Index.php"><i class="fa-solid fa-box"></i>  Daftar produk</a>
 	 			</li>
				<li>
					<a href="#"><i class="fa-solid fa-arrow-down"></i>  Stok masuk</a>
				</li>
				<li>
					<a href="#"><i class="fa-solid fa-arrow-up"></i>  Stok keluar</a>
				</li>
				<li>
					<a href="#"><i class="fa-solid fa-clock-rotate-left"></i>  Riwayat</a>
				</li>



 	 </ul>
 </nav>


<div id="content">
	
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  	<div class="container-fluid">
  		<button type="button" id="sidebarCollapse" class="btn  btn-info">
  			<i class="fas fa-align-left"></i>
  			<span></span>
  			
  		</button>
  	</div>
  	  </nav>
		<div class="head-content">
			<div class="d-flex">
				<h2 class="m0">Daftar Produk</h2>
				<a href="tambahProduk.php" class="btn tambah right">
					+ Tambah Produk
				</a>
			</div>
		</div>
		<div class="body-content">
			<div class="input-with-icon" style="margin-bottom: 15px;">
				<form>
                    <input type="text" class="input-icon" placeholder="search" name="search">
                </form>
			</div>
			<table>
				<?php
					$sql = "SELECT * FROM product";
					if(isset($_GET['search'])){
						$sql = "SELECT * FROM product WHERE nama LIKE '%".$_GET['search']."%'";
					}
					$result = mysqli_query($conn, $sql);
					$total = mysqli_num_rows($result);
					$arr = array();
					while($data = mysqli_fetch_array($result)): ?>
							<tr>
							<td>
								<div class="center-v">
									<div class="produk-box">
										<img src="image/produk/<?=$data['id']?>-<?=$data['photo']?>" width="100%">
									</div>
									<div style="margin-left: 20px;" class="">
										<p style="font-size:14px;" class="m0"><?=$data['nama']?></p>
										<p style="font-size:12px;color:#6B7280" class="m0"><?=$data['harga_beli']?> / <?=$data['harga_jual']?> / <?=$data['tipe']?> / <?=$data['merk']?></p>
									</div>
									<p style="font-size:20px;color:#194FB1;" class="right"><?=$data['jumlah']?></p>
								</div>
							</td>
						</tr>
				<?php endwhile ?>
			</table>
		</div>
	</div>
</div>


</div>












<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- Fontawesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

<script>

$(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

</script>


</body>
</html>