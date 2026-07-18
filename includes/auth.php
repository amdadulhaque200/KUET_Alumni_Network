<?php
session_start();

/*
|--------------------------------------------------------------------------
| Authentication Check
|--------------------------------------------------------------------------
|
| If the admin is not logged in, redirect to the login page.
|
*/

if (!isset($_SESSION['admin_id'])) {

    header("Location: /kuet_alumni/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Logged-in Admin Information
|--------------------------------------------------------------------------
*/

$admin_id = $_SESSION['admin_id'];
$username = $_SESSION['username'];
$role     = $_SESSION['role'];
