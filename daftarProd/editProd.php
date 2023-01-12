<?php
require_once '../koneksi.php';
session_start();
// ambil data di url
$id = $_SESSION['idProduk'];
// query product berdasarkan id
$sql = "SELECT * FROM product WHERE product.id = '$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($result);

if (isset($_POST["submit"])) {
	if ($_FILES['photo']['size'] == 0) {
		$nama = $_POST["nama"];
		$jual = $_POST['harga_jual'];
		$beli = $_POST['harga_beli'];
		$tipe = $_POST['tipe'];
		$merk = $_POST['merk'];
		$sql = "UPDATE product SET
						nama = '$nama',
						harga_beli = $jual,
						harga_jual = $beli,
						tipe =  '$tipe',
						merk =  '$merk'
						WHERE product.id = $id";
		if (mysqli_query($conn, $sql)) {
			header("Location: detailProd.php?id=$id");
		}
	} else {
		$targetFile = strtotime(date("Y-m-d H:i:s")) . "-" . basename($_FILES["photo"]["name"]);
		$nama = $_POST["nama"];
		$jual = $_POST['harga_jual'];
		$beli = $_POST['harga_beli'];
		$tipe = $_POST['tipe'];
		$merk = $_POST['merk'];
		$sql = "UPDATE product SET
						nama = '$nama',
						harga_beli = $jual,
						harga_jual = $beli,
						tipe =  '$tipe',
						merk =  '$merk',
						photo = '$targetFile'
						WHERE product.id = $id";
		if (mysqli_query($conn, $sql)) {
			move_uploaded_file($_FILES["photo"]["tmp_name"], 'image/produk/' . $id . "-" . $targetFile);
			header("Location: detailProd.php?id=$id");
		}
	}

}
if (isset($_POST["cancel"])) {
	header("Location: detailProd.php?id=$id");
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
			<div class="head-content mb-0">
				<div class="d-flex ">
					<h2 class="m0">Edit Produk</h2>
				</div>
				<h3 style="font-size: 18px;" class="m0 ml-1 my-2">Deskripsi produk</h3>

			</div>
			<div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="d-flex">
						<div class="form-bottom">
							<hr style="margin-top: 10px;margin-bottom:20px">
							<div class="d-flex" style="margin-bottom:30px">
								<div style="width:100%">
									<div class="form-inline center-v" style="margin-bottom:10px">
										<label for="nama">Nama</label>
										<input type="text" id="nama" name="nama" required value="<?= $data['nama'] ?>">
									</div>
									<div class="form-inline center-v" style="margin-bottom:10px">
										<label for="harga_beli">Harga beli</label>
										<input type="number" id="harga_beli" name="harga_beli" required
											value="<?= $data['harga_beli'] ?>">
									</div>
									<div class="form-inline center-v">
										<label for="harga_jual">Harga jual</label>
										<input type="number" id="harga_jual" name="harga_jual" required
											value="<?= $data['harga_jual'] ?>">
									</div>
								</div>
							</div>
						</div>
						<div style="margin-left: 20px;" class="center-v input-photo">
							<input type="file" id="photo" style="display:none;" onchange="readURL(this)"
								accept="image/*" name="photo">
							<label for="photo"><img src="image/produk/<?= $data['id'] ?>-<?= $data['photo'] ?>"
									id="image"></label>
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
							<input type="text" id="merk" name="merk" required value="<?= $data['merk'] ?>">
						</div>
						<button class="btnKirim" name="submit" value="submit">Edit</button>
						<button class="btnCancel" name="cancel" value="cancel">Cancel</button>
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