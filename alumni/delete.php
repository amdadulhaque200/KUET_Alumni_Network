<?php
include("../includes/auth.php");
include("../config/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Alumni
            WHERE alumni_id = :id";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":id", $id);

    if (oci_execute($stid)) {
        echo "
        <script>
            alert('Alumni deleted successfully.');
            window.location='list.php';
        </script>";
    } else {
        $e = oci_error($stid);

        // ORA-02292 = Child record exists
        if (strpos($e['message'], 'ORA-02292') !== false) {
            echo "
            <script>
                alert('This alumni cannot be deleted because donation records exist. Delete the related donations first.');
                window.location='list.php';
            </script>";
        } else {
            echo "
            <script>
                alert('Database Error:\\n" . addslashes($e['message']) . "');
                window.location='list.php';
            </script>";
        }
    }
} else {
    header("Location: list.php");
    exit();
}
