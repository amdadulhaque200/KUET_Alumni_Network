<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "
SELECT *
FROM V_TOP_DONORS
ORDER BY TOTAL_DONATED DESC
";

$stid = oci_parse($conn, $sql);
oci_execute($stid);
?>

<h2>Top Donors Report</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Alumni ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Total Donated</th>
    </tr>

<?php
while($row = oci_fetch_assoc($stid))
{
?>
    <tr>
        <td><?php echo $row['ALUMNI_ID']; ?></td>
        <td><?php echo $row['FIRST_NAME']; ?></td>
        <td><?php echo $row['LAST_NAME']; ?></td>
        <td><?php echo $row['TOTAL_DONATED']; ?></td>
    </tr>
<?php
}
?>
</table>

<?php include("../includes/footer.php"); ?>