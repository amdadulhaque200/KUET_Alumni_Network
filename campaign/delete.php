<?php
include("../includes/auth.php");
include("../config/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    /* Check if campaign has donations */

    $check_sql = "
    SELECT COUNT(*) TOTAL
    FROM DONATION
    WHERE CAMPAIGN_ID = :id
    ";

    $check_stid = oci_parse($conn, $check_sql);

    oci_bind_by_name($check_stid, ":id", $id);

    oci_execute($check_stid);

    $check = oci_fetch_assoc($check_stid);

    if ($check['TOTAL'] > 0) {
        echo "
        <script>
        alert('Cannot delete this campaign because donations exist under it.');
        window.location='list.php';
        </script>
        ";
        exit();
    }

    /* Delete campaign */

    $sql = "
    DELETE FROM DONATION_CAMPAIGN
    WHERE CAMPAIGN_ID = :id
    ";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":id", $id);

    if (oci_execute($stid)) {
        header("Location: list.php");
        exit();
    } else {
        $e = oci_error($stid);

        echo "<h3>" . $e['message'] . "</h3>";
    }
}
