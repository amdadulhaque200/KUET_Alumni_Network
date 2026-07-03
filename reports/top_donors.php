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

<section class="page-hero">
    <h1 class="display-6 mb-2">Top Donors Report</h1>
    <p>Recognize the most active supporters across the alumni network.</p>
</section>

<div class="section-card">
    <div class="section-card-header">Top Contributors</div>
    <div class="table-wrap">
        <table>
            <tr>
                <th>Alumni ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Donated</th>
            </tr>
            <?php while($row = oci_fetch_assoc($stid)) { ?>
            <tr>
                <td><?php echo $row['ALUMNI_ID']; ?></td>
                <td><?php echo $row['FIRST_NAME']; ?></td>
                <td><?php echo $row['LAST_NAME']; ?></td>
                <td>৳ <?php echo number_format($row['TOTAL_DONATED']); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>