<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | KUET Alumni Network</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/kuet_alumni/assets/style.css">
</head>
<body class="auth-shell">
	<div class="auth-card">
		<div class="auth-visual d-flex flex-column justify-content-between">
			<div>
				<p class="text-uppercase fw-semibold mb-2">KUET Alumni Portal</p>
				<h1 class="display-6 mb-3">Sign in to continue.</h1>
				<p class="mb-0">A focused entry screen for admin access and future authentication wiring.</p>
			</div>
			<div class="mt-5 small text-white-50">
				Secure access for alumni operations, event coordination, and donation reporting.
			</div>
		</div>
		<div class="auth-form">
			<h2 class="fw-bold mb-2">Welcome back</h2>
			<p class="text-muted mb-4">Use your admin credentials to access the portal.</p>
			<form method="post" action="#" onsubmit="return false;">
				<div class="mb-3">
					<label class="form-label">Username or Email</label>
					<input type="email" class="form-control" placeholder="admin@kuet.ac.bd">
				</div>
				<div class="mb-3">
					<label class="form-label">Password</label>
					<input type="password" class="form-control" placeholder="Enter password">
				</div>
				<div class="d-grid gap-2">
					<button type="button" class="btn btn-primary">Enter Portal</button>
					<a href="/kuet_alumni/dashboard.php" class="btn btn-outline-secondary">Go to Dashboard</a>
				</div>
			</form>
			<p class="table-note mt-3 mb-0">Authentication can be connected to the Admin table when you are ready.</p>
		</div>
	</div>
</body>
</html>
