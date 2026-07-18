<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>KUET Alumni Network</title>

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="/kuet_alumni/assets/style.css">

</head>

<body class="app-shell">

    <nav class="navbar navbar-expand-lg navbar-dark site-nav">

        <div class="container">

            <a class="navbar-brand fw-bold brand-mark"
                href="/kuet_alumni/index.php">

                KUET Alumni Network

            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse"
                id="mainNav">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/index.php">

                            Home

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/about.php">

                            About

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/public/alumni.php">

                            Browse Alumni

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/public/mentor.php">

                            Mentors

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/public/jobs.php">

                            Jobs

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/public/events.php">

                            Events

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/kuet_alumni/contact.php">

                            Contact

                        </a>

                    </li>

                    <li class="nav-item ms-lg-3">

                        <a
                            class="btn btn-success btn-sm"
                            href="/kuet_alumni/login.php">

                            Admin Login

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <main class="page-shell container-lg">