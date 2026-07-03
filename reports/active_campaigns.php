<?php
include("../includes/header.php");
include("../config/db.php");

$sql = "SELECT *
        FROM V_ACTIVE_CAMPAIGNS
        ORDER BY CAMPAIGN_ID";

$stid = oci_parse($conn, $sql);
oci_execute($stid);
?>

<section class="page-hero">
    <h1 class="display-6 mb-2">Active Campaigns</h1>
    <p>Monitor live fundraising drives and their timelines.</p>
</section>

<div class="section-card">
    <div class="section-card-header">Campaign Tracker</div>
    <div class="table-wrap">
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Target Amount</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
            <?php while($row = oci_fetch_assoc($stid)) { ?>
            <tr>
                <td><?= $row['CAMPAIGN_ID'] ?></td>
                <td><?= $row['TITLE'] ?></td>
                <td>৳ <?= number_format($row['TARGET_AMOUNT']) ?></td>
                <td><?= date("d M Y", strtotime($row['START_DATE'])) ?></td>
                <td><?= date("d M Y", strtotime($row['END_DATE'])) ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>