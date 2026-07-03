<?php
include("../config/db.php");

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql = "DELETE FROM Alumni
            WHERE alumni_id = :id";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":id", $id);

    if(oci_execute($stid))
    {
        header("Location: list.php");
        exit();
    }
    else
    {
        $e = oci_error($stid);
        echo $e['message'];
    }
}
?>