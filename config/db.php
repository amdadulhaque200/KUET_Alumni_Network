<?php

$conn = oci_connect(
    "ALUMNI_ADMIN",
    "alumni321",
    "localhost/XE"
);

if (!$conn) {
    $e = oci_error();
    die($e['message']);
}

echo "Connected";
?>