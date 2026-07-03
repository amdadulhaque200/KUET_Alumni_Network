<?php
include("config/db.php");
include("includes/header.php");

/* Total Alumni */
$sql1 = "SELECT COUNT(*) AS TOTAL FROM ALUMNI";
$stid1 = oci_parse($conn, $sql1);
oci_execute($stid1);
$row1 = oci_fetch_assoc($stid1);

/* Total Donations */
$sql2 = "SELECT NVL(SUM(AMOUNT),0) AS TOTAL FROM DONATION";
$stid2 = oci_parse($conn, $sql2);
oci_execute($stid2);
$row2 = oci_fetch_assoc($stid2);

/* Total Events */
$sql3 = "SELECT COUNT(*) AS TOTAL FROM EVENT";
$stid3 = oci_parse($conn, $sql3);
oci_execute($stid3);
$row3 = oci_fetch_assoc($stid3);

/* Active Campaigns */
$sql4 = "SELECT COUNT(*) AS TOTAL FROM V_ACTIVE_CAMPAIGNS";
$stid4 = oci_parse($conn, $sql4);
oci_execute($stid4);
$row4 = oci_fetch_assoc($stid4);
?>

<div class="page-header">
    <div>
        <h2>Dashboard</h2>
        <div class="table-note">Overview of alumni, donations, events, and active campaigns.</div>
    </div>
</div>

<div class="stats-grid mb-4">
    <div class="kpi-card primary">
        <div class="label">Total Alumni</div>
        <div class="value"><?php echo number_format($row1['TOTAL']); ?></div>
    </div>
    <div class="kpi-card success">
        <div class="label">Total Donations</div>
        <div class="value">৳ <?php echo number_format($row2['TOTAL']); ?></div>
    </div>
    <div class="kpi-card warning">
        <div class="label">Total Events</div>
        <div class="value"><?php echo number_format($row3['TOTAL']); ?></div>
    </div>
    <div class="kpi-card danger">
        <div class="label">Active Campaigns</div>
        <div class="value"><?php echo number_format($row4['TOTAL']); ?></div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
