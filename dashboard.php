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

<div class="text-center mb-4">
    <h1>KUET Alumni Management System</h1>
    <p class="text-muted">
        Oracle Database + PHP Web Application
    </p>
</div>

<div class="row g-4">

```
<div class="col-md-3">
    <div class="card text-bg-primary shadow">
        <div class="card-body text-center">
            <h5>Total Alumni</h5>
            <h2><?php echo $row1['TOTAL']; ?></h2>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card text-bg-success shadow">
        <div class="card-body text-center">
            <h5>Total Donations</h5>
            <h2><?php echo $row2['TOTAL']; ?></h2>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card text-bg-warning shadow">
        <div class="card-body text-center">
            <h5>Total Events</h5>
            <h2><?php echo $row3['TOTAL']; ?></h2>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card text-bg-danger shadow">
        <div class="card-body text-center">
            <h5>Active Campaigns</h5>
            <h2><?php echo $row4['TOTAL']; ?></h2>
        </div>
    </div>
</div>
```

</div>

<div class="card mt-5 shadow">
    <div class="card-body">
        <h4>Project Features</h4>

```
    <ul>
        <li>Alumni CRUD Operations</li>
        <li>Donation Management</li>
        <li>Event Management</li>
        <li>Search Alumni</li>
        <li>Oracle Stored Procedure</li>
        <li>Oracle Trigger</li>
        <li>Oracle Function</li>
        <li>Oracle Views & Reports</li>
    </ul>
</div>
```

</div>

<?php include("includes/footer.php"); ?>
