<?php
session_start();
include("config/db.php");

if (isset($_SESSION['admin_id'])) {
	header("Location: dashboard.php");
	exit();
}

$message = "";

if (isset($_POST['login'])) {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	$sql = "
    SELECT *
    FROM ADMIN
    WHERE USERNAME = :username
    AND PASSWORD = :password
    ";

	$stid = oci_parse($conn, $sql);

	oci_bind_by_name($stid, ":username", $username);
	oci_bind_by_name($stid, ":password", $password);

	oci_execute($stid);

	if ($row = oci_fetch_assoc($stid)) {

		$_SESSION['admin_id'] = $row['ADMIN_ID'];
		$_SESSION['username'] = $row['USERNAME'];
		$_SESSION['role'] = $row['ROLE'];

		header("Location: dashboard.php");
		exit();
	} else {

		$message = "
        <div class='alert alert-danger'>
            Invalid Username or Password.
        </div>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Admin Login | KUET Alumni Network</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">

	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap" rel="stylesheet">

	<style>
		body {
			background: #f5f7fb;
			font-family: 'Manrope', sans-serif;
		}

		.login-card {
			width: 430px;
			border: none;
			border-radius: 15px;
			box-shadow: 0 10px 35px rgba(0, 0, 0, .12);
		}

		.logo {
			width: 90px;
		}
	</style>

</head>

<body>

	<div class="container vh-100 d-flex justify-content-center align-items-center">

		<div class="card login-card">

			<div class="card-body p-5">

				<div class="text-center mb-4">

					<img src="assets/kuet_logo.png" class="logo mb-3">

					<h3 class="fw-bold">

						KUET Alumni Network

					</h3>

					<p class="text-muted">

						Administrator Login

					</p>

				</div>

				<?= $message ?>

				<form method="post">

					<div class="mb-3">

						<label class="form-label">

							Username

						</label>

						<input
							type="text"
							name="username"
							class="form-control"
							autocomplete="off"
							spellcheck="false"
							autocapitalize="off"
							required>
					</div>

					<div class="mb-4">

						<label class="form-label">

							Password

						</label>

						<input
							type="password"
							name="password"
							class="form-control"
							autocomplete="new-password"
							required>

					</div>

					<button
						type="submit"
						name="login"
						class="btn btn-primary w-100">

						Login

					</button>

				</form>

			</div>

		</div>

	</div>

</body>

</html>