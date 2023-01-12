<?php
require_once '../koneksi.php';
session_start();
if (isset($_POST['submit'])) {
	$id = $_GET['id'];

	$result = mysqli_query($conn, "SELECT * FROM product WHERE id = '$id'");
	if (mysqli_num_rows($result) === 1) {
		$row = mysqli_fetch_assoc($result);
		if ($row['id'] == $id) {
			$jumlahProd = $row['jumlah'];
		}
	}

	if ($_POST['jumlah'] > 0) {
		$stokIn = $_POST['jumlah'];
		$tanggal = $_POST['tanggal'];
		$jenis = "Stok Masuk";
		$idProduct = $_GET['id'];
		$idGudang = $_SESSION['idGudang'];

		$jumlahTerbaru = $stokIn + $jumlahProd;

		mysqli_query($conn, "INSERT INTO riwayat (jenisStok, jumlah,	tanggal, id_product, id_gudang) 
					VALUES ('$jenis', $stokIn, '$tanggal', $idProduct, $idGudang)");
		mysqli_query($conn, "UPDATE product SET product.jumlah = $jumlahTerbaru 
					WHERE product.id = $id");
	}
}
?>
<!DOCTYPE html>
<html>

<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<link rel="stylesheet" href="stockIn.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<style>
		.produk:hover{
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
			<ul class="lisst-unstyled components">
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
					<a href="stockIn.php"><i class="fa-solid fa-arrow-down"></i> Stok masuk</a>
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
					<h2 class="m0">Stok Masuk</h2>
				</div>
			</div>

			<div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="d-flex">
						<div class="form-bottom">
							<h3 style="font-size: 18px;" class="m0">Pilih produk</h3>
							<hr style="margin-top: 10px;margin-bottom:20px">

							<div class="input-with-icon" style="margin-bottom: 15px;">

								<input type="text" class="input-icon" placeholder="search" name="search">

							</div>

							<div class="d-flex" style="margin-bottom:30px">
								<div style="width:100%">
									<table>
										<?php
                                        $tampungId = $_SESSION['idGudang'];
                                        $sql = "SELECT * FROM product WHERE product.id_gudang = '$tampungId'";
                                        if (isset($_GET['search'])) {
	                                        $sql = "SELECT * FROM product WHERE nama LIKE '%" . $_GET['search'] . "%' AND product.id_gudang = '$tampungId'";
                                        }
                                        $result = mysqli_query($conn, $sql);
                                        $total = mysqli_num_rows($result);
                                        while ($data = mysqli_fetch_array($result)): ?>
										<tr>
											<td class="py-1 produk">
												<a href="stockIn.php?id=<?= $data['id']; ?>">
													<div class="center-v">
														<div class="produk-box">
															<img src="../daftarProd/image/produk/<?= $data['id'] ?>-<?= $data['photo'] ?>"
																width="100%">
														</div>
														<div style="margin-left: 20px;" class="left">
															<p style="font-size:16px;" class="my-1"><strong> <?= $data['nama'] ?> </strong></p>
															<p style="font-size:12px;color:#6B7280" class="my-1">
																<?= $data['harga_beli'] ?> / <?= $data['harga_jual'] ?> / <?= $data['tipe'] ?> / <?= $data['merk'] ?>
															</p>
														</div>
														<div class="right">
															<p style="font-size:20px;color:#194FB1; margin-bottom: -10px; ">
																<?= $data['jumlah'] ?>
															</p>
															<p
																style="font-size:16px;color: #194FB1; margin-bottom: 0; float: right;">
																<?php if (isset($_POST['submit']) && $data['id'] === $id && $_POST['jumlah'] > 0) {
																	echo "+ " . $_POST['jumlah'];
																} ?>
															</p>
														</div>
													</div>
												</a>
											</td>
										</tr>
										<?php endwhile ?>
									</table>
									<div style="margin-top: 100px; display: flex;">
										<button type="submit" class="btnMasukkan" style="padding: 5px 25px; "
											name="submit" value="Masukkan">
											<p style="font-size: 20px;color:white">Masukkan</p>
										</button>
									</div>
								</div>
							</div>
						</div>

						<div style="margin-left: 20px; margin-top: 230px" class="center-v input-stok">
							<div class="inputanStok">
								<table>
									<tr>
										<td style="border: none;">
											<div class="inputanStok">
												<input type="number" name="jumlah" id="" required>
											</div>
										</td>
										<td style="border: none;">
											<div class="date">
												<input type="date" name="tanggal" id="" required>
											</div>
										</td>
									</tr>
									<tr style="margin-top: 50px; display: flex;">
										<td style="border-top: none;">
											<div class="total">
												<p style="color: black;">
													<strong>
														<span style="color: grey;">Total</span>
														Jumlah Masukkan : <span style="color:#194FB1;">
															<?php if (isset($_POST['submit']) && $_POST['jumlah'] > 0) {
	                                                            echo $_POST['jumlah'];
                                                            } ?>
														</span>
													</strong>
												</p>
											</div>
										</td>
										<td style="border-top: none;"></td>
									</tr>
									<tr>
										<td>

										</td>
										<td>
											<div class="jmlProd">
												<p style="color:#194FB1;"> <strong>
														Total produk :
														<?php if (isset($_POST['submit']) && $_POST['jumlah'] > 0 ) {
	                                                        echo $jumlahTerbaru;
                                                        } ?>
													</strong>
												</p>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
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