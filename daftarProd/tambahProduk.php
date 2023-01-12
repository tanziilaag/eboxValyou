<?php
require '../koneksi.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
				<div class="dropdown" align="center">
					<button class="btn dropdown-toggle" style="background-color: #E9F1FC;" type="button"
						id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<h5><strong> <?php echo $_SESSION['namaGudang']; ?> </strong></h5>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<?php
						$idUser = $_SESSION['idUser'];
						$hasil = mysqli_query($conn, "SELECT * FROM gudang WHERE id_user = '$idUser'");
						while ($row = mysqli_fetch_array($hasil)):
							?>
							<a class="dropdown-item" href="../daftarLogin/pilihGudang.php?id=<?= $row['id_gudang']; ?>">
								<strong>
									<?= $row['namaGudang'] ?>
								</strong> </a>
						<?php endwhile ?>

						<hr>
						<a class="dropdown-item" href="../daftarLogin/indexGudang.php" style="color: #194FB1;"><Strong>+ Buat Gudang Baru</Strong></a>
					</div>
				</div>
				<li>
					<a href="../daftarProd/Index.php"><i class="fa-solid fa-box"></i> Daftar produk</a>
				</li>
				<li>
					<a href="../stockIn/stockIn.php"><i class="fa-solid fa-arrow-down"></i> Stok masuk</a>
				</li>
				<li>
					<a href="../stockOut/stockOut.php"><i class="fa-solid fa-arrow-up"></i> Stok keluar</a>
				</li>
				<li>
					<a href="../riwayat/riwayat.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</a>
				</li>
				<li>
					<a href="../logout.php" style="text-align: center;"><Strong>Logout</Strong></a>
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
					<h2 class="m0">Tambah produk baru</h2>
				</div>
			</div>
			<div>

				<?php
				$idGudang = $_SESSION['idGudang'];
				if (isset($_POST["submit"])):
					$targetFile = strtotime(date("Y-m-d H:i:s")) . "-" . basename($_FILES["photo"]["name"]);
					if($_POST['jumlah'] > 0 && $_POST["harga_beli"] > 0 && $_POST["harga_jual"]):
						$sql = "INSERT INTO product VALUES (null,
										'" . $_POST["nama"] . "',
										" . $_POST["harga_beli"] . ",
										" . $_POST["harga_jual"] . ",
										'" . $_POST["tipe"] . "',
										'" . $_POST["merk"] . "',
										" . $_POST["jumlah"] . ",
										'" . $targetFile . "',
										'$idGudang')";
						if (mysqli_query($conn, $sql)):
							move_uploaded_file($_FILES["photo"]["tmp_name"], 'image/produk/' . mysqli_insert_id($conn) . "-" . $targetFile); 
				?>
							<div class="alert alert-success" role="alert">
								Penambahan produk berhasil
							</div>
						<?php else: ?>
							<div class="alert alert-danger" role="alert">
								Penambahan produk gagal
							</div>
						<?php endif;?>
					<?php else: ?>
						<div class="alert alert-danger" role="alert">
							Penambahan produk gagal
						</div>
					<?php endif;
				endif; ?>
				<form method="POST" enctype="multipart/form-data">
					<div class="d-flex">
						<div class="form-bottom">
							<h3 style="font-size: 18px;" class="m0">Deskripsi produk</h3>
							<hr style="margin-top: 10px;margin-bottom:20px">
							<div class="d-flex" style="margin-bottom:30px">
								<div style="width:100%">
									<div class="form-inline center-v" style="margin-bottom:10px">
										<label for="nama">Nama</label>
										<input type="text" id="nama" name="nama" required>
									</div>
									<div class="form-inline center-v" style="margin-bottom:10px">
										<label for="harga_beli">Harga beli</label>
										<input type="number" id="harga_beli" name="harga_beli" required>
									</div>
									<div class="form-inline center-v">
										<label for="harga_jual">Harga jual</label>
										<input type="number" id="harga_jual" name="harga_jual" required>
									</div>
								</div>
							</div>
						</div>
						<div style="margin-left: 20px;" class="center-v input-photo">
							<input type="file" id="photo" style="display:none;" onchange="readURL(this)"
								accept="image/*" name="photo" required>
							<label for="photo"><img src="image/photo.png" id="image"></label>
							<script>
								$(function () {
									$('#photo').change(function () {
										var input = this;
										var url = $(this).val();
										var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
										if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
											var reader = new FileReader();
											reader.onload = function (e) {
												$('#image').attr('src', e.target.result);
											}
											reader.readAsDataURL(input.files[0]);
										} else {
											$('#image').attr('src', 'img/photo.png');
										}
									});
								});
							</script>
						</div>
					</div>
					<div class="form-bottom">
						<h3 style="font-size: 18px;" class="m0">Kategori produk</h3>
						<hr style="margin-top: 10px;margin-bottom:20px">
						<div class="form-inline center-v" style="margin-bottom:10px">
							<label for="tipe">Tipe</label>
							<select id="tipe" name="tipe">
								<option value="Buku">Buku</option>
								<option value="Dapur">Dapur</option>
								<option value="Elektronik">Elektronik</option>
								<option value="Clothing Brand">Clothing Brand</option>
								<option value="Film & Musik">Film & Musik</option>
								<option value="Kecantikan">Kecantikan</option>
								<option value="Kesehatan">Kesehatan</option>
								<option value="Komputer dan Laptop">Komputer dan Laptop</option>
								<option value="Olahraga">Olahraga</option>
								<option value="Rumah Tangga">Rumah Tangga</option>
								<option value="Wedding">Wedding</option>
							</select>
						</div>
						<div class="form-inline center-v" style="margin-bottom:30px">
							<label for="merk">Merk</label>
							<input type="text" id="merk" name="merk" required>
						</div>
						<h3 style="font-size: 18px;" class="m0">Jumlah produk</h3>
						<hr style="margin-top: 10px;margin-bottom:20px">
						<div class="form-inline center-v" style="margin-bottom:10px">
							<label for="jumlah">Jumlah</label>
							<input type="number" id="jumlah" name="jumlah" required>
						</div>
						<button class="btnKirim" style="padding: 5px 25px; " name="submit" value="submit">
							<p style="font-size: 20px;color:white">Kirim</p>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	</div>












	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
		integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
		crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
		crossorigin="anonymous"></script>

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