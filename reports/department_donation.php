<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "
SELECT *
FROM V_DEPARTMENT_DONATION
ORDER BY TOTAL_DONATION DESC
";

$stid = oci_parse($conn, $sql);
oci_execute($stid);
?>

<h2>Department Donation Report</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Department</th>
        <th>Total Donation</th>
    </tr>

<?php
while($row = oci_fetch_assoc($stid))
{
?>
    <tr>
        <td><?php echo $row['DEPT_NAME']; ?></td>
        <td><?php echo $row['TOTAL_DONATION']; ?></td>
    </tr>
<?php
}
?>
</table>

<?php include("../includes/footer.php"); ?>