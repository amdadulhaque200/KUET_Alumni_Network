<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KUET Alumni Network</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/kuet_alumni/assets/style.css">
</head>

<body class="app-shell">
    <nav class="navbar navbar-expand-lg navbar-dark site-nav">
        <div class="container">
            <a class="navbar-brand fw-bold brand-mark" href="/kuet_alumni/dashboard.php">
                KUET Alumni Network
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <a class="nav-link" href="/kuet_alumni/dashboard.php">Dashboard</a>
                    <a class="nav-link" href="/kuet_alumni/alumni/list.php">Alumni</a>
                    <a class="nav-link" href="/kuet_alumni/donation/list.php">Donations</a>
                    <a class="nav-link" href="/kuet_alumni/event/list.php">Events</a>
                    <a class="nav-link" href="/kuet_alumni/job/list.php">Jobs</a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportsNav" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/kuet_alumni/reports/top_donors.php">Top Donors</a></li>
                            <li><a class="dropdown-item" href="/kuet_alumni/reports/department_donation.php">Department Donation</a></li>
                            <li><a class="dropdown-item" href="/kuet_alumni/reports/active_campaigns.php">Active Campaigns</a></li>
                        </ul>
                    </div>
                    <?php if (isset($_SESSION['admin_id'])) { ?>

                        <span class="navbar-text text-white me-3">

                            👤 <?= $_SESSION['username']; ?>

                            (<?= $_SESSION['role']; ?>)

                        </span>

                        <a
                            class="btn btn-danger btn-sm"
                            href="/kuet_alumni/logout.php">

                            Logout

                        </a>

                    <?php } else { ?>

                        <a
                            class="nav-link nav-cta"
                            href="/kuet_alumni/login.php">

                            Login

                        </a>

                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="page-shell container-lg">