<?php
require_once '../koneksi.php';
session_start();
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
	<style>
		td:hover {
			background-color: #E9F1FC;
		}
	</style>
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
								</strong> </a>

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
			<div class="head-content">
				<div class="d-flex">
					<h2 class="m0">Daftar Produk</h2>
					<a href="tambahProduk.php" class="btn tambah right"> + Tambah Produk </a>
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
					$tampungId = $_SESSION['idGudang'];
					$sql = "SELECT * FROM product WHERE product.id_gudang = '$tampungId'";
					if (isset($_GET['search'])) {
						$sql = "SELECT * FROM product WHERE nama LIKE '%" . $_GET['search'] . "%' AND product.id_gudang = '$tampungId'";
					}
					$result = mysqli_query($conn, $sql);
					$total = mysqli_num_rows($result);
					while ($data = mysqli_fetch_array($result)):
						?>
						<tr>
							<td>
								<a class="produk" href="detailProd.php?id=<?= $data['id']; ?>">
									<div class="center-v">
										<div class="produk-box">
											<img src="image/produk/<?= $data['id'] ?>-<?= $data['photo'] ?>" width="100%">
										</div>
										<div style="margin-left: 20px;" class="">
											<p style="font-size:16px;" class="m0"><strong>
													<?= $data['nama'] ?>
												</strong></p>
											<p style="font-size:12px;color:#6B7280" class="m0"><?= $data['harga_beli'] ?> /
												<?= $data['harga_jual'] ?> / <?= $data['tipe'] ?> / <?= $data['merk'] ?></p>
										</div>
										<p style="font-size:20px;color:#194FB1;" class="right">
											<?= $data['jumlah'] ?>
										</p>
									</div>
								</a>
							</td>
						</tr>
					<?php endwhile ?>

				</table>
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