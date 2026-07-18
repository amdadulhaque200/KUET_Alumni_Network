<?php
include("../includes/auth.php");
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

<section class="page-hero">
    <h1 class="display-6 mb-2">Department Donation Report</h1>
    <p>Compare fundraising impact across KUET departments.</p>
</section>

<div class="section-card">
    <div class="section-card-header">Department Summary</div>
    <div class="table-wrap">
        <table>
            <tr>
                <th>Department</th>
                <th>Total Donation</th>
            </tr>
            <?php while($row = oci_fetch_assoc($stid)) { ?>
            <tr>
                <td><?php echo $row['DEPT_NAME']; ?></td>
                <td>৳ <?php echo number_format($row['TOTAL_DONATION']); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>