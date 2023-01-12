<?php
require_once '../koneksi.php';
session_start();

// ambil data di url
$id = $_GET['id'];

// query product berdasarkan id
$sql = "SELECT * FROM product WHERE product.id = '$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($result);

$_SESSION['idProduk'] = $_GET['id'];

//ketika button hapus ditekan
if (isset($_POST["hapus"])) {
	//hapus data berdasarkan ID
	mysqli_query($conn, "DELETE FROM product WHERE id = '$id'");
	header("Location: Index.php");
	exit();
}
//ketika button edit ditekan
if (isset($_POST["edit"])) {
	header("Location: editProd.php");
	exit();
}

?>
<!DOCTYPE html>
<html>

<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
				<div class="dropdown" align="center">
					<button class="btn dropdown-toggle" style="background-color: #E9F1FC;" type="button"
						id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<h5><strong>
								<?php echo $_SESSION['namaGudang']; ?>
							</strong></h5>
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
								</strong>
							</a>
						<?php endwhile ?>

						<hr>
						<a class="dropdown-item" href="../daftarLogin/indexGudang.php" style="color: #194FB1;"><Strong>+
								Buat Gudang Baru</Strong></a>
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
			<div class="head-content mb-0">
				<div class="d-flex">
					<h2 class="m0">Detail Produk</h2>
				</div>
				<h3 style="font-size: 18px;" class="m0 ml-1 my-2">Info Produk</h3>

			</div>
			<div class="body-content" style="float: left;">
				<div class="input-with-icon" style="margin-bottom: 15px;">
					<!-- button -->
					<form action="" method="post">
						<input type="submit" class="btn btn-primary btnHapus mx-1 my-2" name="edit" value="Edit">
						<input type="button" class="btn btn-primary btnHapus mx-1 my-2" data-toggle="modal"
							data-target="#exampleModal" value="Hapus">
					</form>
					<!-- Alert Konfirmasi -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
						aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Pesan Konfirmasi</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Apakah anda ingin menghapus produk ini?
								</div>
								<div class="modal-footer">
									<form action="" method="post">
										<button type="button" class="btn btn-secondary"
											data-dismiss="modal">Batal</button>
										<input type="submit" class="btn btn-primary" name="hapus" value="Hapus"
											style="width: 80px; height: 38px;">
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
				<table>
					<tr>
						<td>
							<div class="center-v">
								<div>
									<p style="color: black; font-weight: normal;">Nama</p>
									<p style="color: black; font-weight: normal;">Harga Jual</p>
									<p style="color: black; font-weight: normal;">Harga Beli</p>
								</div>
								<div style="margin-left: 40px;" class="">
									<p style="color: black; font-weight: normal;">
										<?= $data['nama'] ?>
									</p>
									<p style="color: black; font-weight: normal;">
										<?= $data['harga_beli'] ?>
									</p>
									<p style="color: black; font-weight: normal;">
										<?= $data['harga_jual'] ?>
									</p>
								</div>
								<img src="image/produk/<?= $data['id'] ?>-<?= $data['photo'] ?>" width="20%"
									class="right">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="center-v">
								<div>
									<p style="color: black; font-weight: normal;">Tipe</p>
									<p style="color: black; font-weight: normal;">Merk</p>
								</div>
								<div style="margin-left: 90px;" class="">
									<p style="color: black; font-weight: normal;">
										<?= $data['tipe'] ?>
									</p>
									<p style="color: black; font-weight: normal;"> <?= $data['merk'] ?> </p>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>

			<div class="body-content" style="float: right; margin-top: 25px;">
				<div class="card"
					style="width: 22rem; margin: auto; border-radius: 5%; height: 500px; box-shadow: 2px 1px 10px grey;">
					<div class="card-body">
						<h5 class="card-title" style="text-align: center;"><strong>Riwayat & Total saat ini</strong>
						</h5>
						<p style="text-align: center; font-size: 35px;"><strong>
								<?= $data['jumlah'] ?>
							</strong></p>
						<hr>

						<?php
						$tampungId = $_SESSION['idGudang'];
						$sql = "SELECT * FROM product JOIN riwayat ON(product.id = riwayat.id_product) WHERE riwayat.id_gudang = '$tampungId' AND riwayat.id_product = $id ORDER BY tanggal DESC";
						$result = mysqli_query($conn, $sql);
						$total = mysqli_num_rows($result);
						$arr = array();
						while ($data = mysqli_fetch_array($result)): ?>
							<div style="clear: both;">
								<div style="float: left;">
									<p style="font-size:16px;" class="m-0">
										<?= $data['jenisStok'] ?>
									</p>
									<p style="font-size:12px;color:#6B7280" class="tgl" margin-top="10px"> <?= $data['tanggal'] ?> </p>
								</div>
								<div style="float: right;">
									<?php if ($data['jenisStok'] === 'Stok Masuk'): ?>
										<p style="font-size:20px;color:#194FB1;" class="right"><b> +<?= $data['jumlah'] ?> </b>
										</p>
									<?php else: ?>
										<p style="font-size:20px;color:red;" class="right"><b> -<?= $data['jumlah'] ?> </b></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile ?>

					</div>
				</div>
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