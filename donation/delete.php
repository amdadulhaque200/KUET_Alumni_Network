<?php
include("../includes/auth.php");
include("../config/db.php");

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id = $_GET['id'];

/*==========================
CHECK DONATION EXISTS
==========================*/

$sql = "
SELECT DONATION_ID
FROM DONATION
WHERE DONATION_ID=:id
";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ":id", $id);

oci_execute($stid);

if (!oci_fetch_assoc($stid)) {
    header("Location: list.php");
    exit;
}

/*==========================
DELETE DONATION
==========================*/

$sql = "
DELETE FROM DONATION
WHERE DONATION_ID=:id
";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ":id", $id);

if (oci_execute($stid)) {

    header("Location:list.php?msg=deleted");
    exit;
} else {

    $e = oci_error($stid);

    die("
        <h3>Delete Failed</h3>
        <p>" . $e['message'] . "</p>
        <a href='list.php'>Back</a>
    ");
}
