<?php
include("../includes/auth.php");
include("../config/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    /* Check Event Registration */

    $check_sql = "SELECT COUNT(*) TOTAL
                FROM EVENT_REGISTRATION
                WHERE EVENT_ID=:id";

    $check_stid = oci_parse($conn, $check_sql);

    oci_bind_by_name($check_stid, ":id", $id);

    oci_execute($check_stid);

    $check = oci_fetch_assoc($check_stid);

    if ($check['TOTAL'] > 0) {
        echo "
        <script>
        alert('Cannot delete this event because registrations already exist.');
        window.location='list.php';
        </script>";
        exit();
    }

    $sql = "DELETE FROM EVENT
          WHERE EVENT_ID=:id";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":id", $id);

    if (oci_execute($stid)) {
        header("Location:list.php");
        exit();
    } else {
        $e = oci_error($stid);

        echo $e['message'];
    }
}
