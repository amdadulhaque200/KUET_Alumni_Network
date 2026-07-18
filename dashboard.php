<?php
include("includes/auth.php");
include("config/db.php");
include("includes/header.php");

/*==========================
TOTAL ALUMNI
==========================*/

$sql1 = "SELECT COUNT(*) TOTAL FROM ALUMNI";
$stid1 = oci_parse($conn, $sql1);
oci_execute($stid1);
$alumni = oci_fetch_assoc($stid1);

/*==========================
TOTAL DONATION AMOUNT
==========================*/

$sql2 = "SELECT NVL(SUM(AMOUNT),0) TOTAL FROM DONATION";
$stid2 = oci_parse($conn, $sql2);
oci_execute($stid2);
$donation = oci_fetch_assoc($stid2);

/*==========================
TOTAL EVENTS
==========================*/

$sql3 = "SELECT COUNT(*) TOTAL FROM EVENT";
$stid3 = oci_parse($conn, $sql3);
oci_execute($stid3);
$event = oci_fetch_assoc($stid3);

/*==========================
ACTIVE CAMPAIGNS
==========================*/

$sql4 = "SELECT COUNT(*) TOTAL FROM V_ACTIVE_CAMPAIGNS";
$stid4 = oci_parse($conn, $sql4);
oci_execute($stid4);
$campaign = oci_fetch_assoc($stid4);

/*==========================
TOTAL JOBS
==========================*/

$sql5 = "SELECT COUNT(*) TOTAL FROM JOB_POSTING";
$stid5 = oci_parse($conn, $sql5);
oci_execute($stid5);
$job = oci_fetch_assoc($stid5);

/*==========================
RECENT DONATIONS
==========================*/

$sql6 = "
SELECT *
FROM
(
SELECT
DONATION_ID,
ALUMNI_ID,
AMOUNT,
DONATION_DATE
FROM DONATION
ORDER BY DONATION_DATE DESC
)
WHERE ROWNUM<=5
";

$stid6 = oci_parse($conn, $sql6);
oci_execute($stid6);

/*==========================
RECENT EVENTS
==========================*/

$sql7 = "
SELECT *
FROM
(
SELECT
EVENT_ID,
EVENT_NAME,
EVENT_DATE
FROM EVENT
ORDER BY EVENT_DATE DESC
)
WHERE ROWNUM<=5
";

$stid7 = oci_parse($conn, $sql7);
oci_execute($stid7);

/*==========================
RECENT JOBS
==========================*/

$sql8 = "
SELECT *
FROM
(
SELECT
JOB_ID,
TITLE,
COMPANY,
POST_DATE
FROM JOB_POSTING
ORDER BY POST_DATE DESC
)
WHERE ROWNUM<=5
";

$stid8 = oci_parse($conn, $sql8);
oci_execute($stid8);

/*==========================
ACTIVE CAMPAIGN LIST
==========================*/

$sql9 = "
SELECT
TITLE,
TARGET_AMOUNT,
START_DATE,
END_DATE
FROM V_ACTIVE_CAMPAIGNS
";

$stid9 = oci_parse($conn, $sql9);
oci_execute($stid9);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Admin Dashboard

    </h1>

    <p>

        Welcome to KUET Alumni Network Administration Panel

    </p>

</section>

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Total Alumni</h6>

                <h2><?= number_format($alumni['TOTAL']) ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Total Donations</h6>

                <h2>৳ <?= number_format($donation['TOTAL']) ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Total Events</h6>

                <h2><?= number_format($event['TOTAL']) ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Active Campaigns</h6>

                <h2><?= number_format($campaign['TOTAL']) ?></h2>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-md-12">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Total Job Posts</h6>

                <h2><?= number_format($job['TOTAL']) ?></h2>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card shadow-sm">

            <div class="card-header">

                Recent Donations

            </div>

            <div class="card-body">

                <table class="table table-sm">

                    <tr>

                        <th>ID</th>

                        <th>Alumni</th>

                        <th>Amount</th>

                    </tr>

                    <?php while ($r = oci_fetch_assoc($stid6)) { ?>

                        <tr>

                            <td><?= $r['DONATION_ID'] ?></td>

                            <td><?= $r['ALUMNI_ID'] ?></td>

                            <td>৳ <?= number_format($r['AMOUNT']) ?></td>

                        </tr>

                    <?php } ?>

                </table>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card shadow-sm">

            <div class="card-header">

                Recent Events

            </div>

            <div class="card-body">

                <table class="table table-sm">

                    <tr>

                        <th>ID</th>

                        <th>Event</th>

                    </tr>

                    <?php while ($r = oci_fetch_assoc($stid7)) { ?>

                        <tr>

                            <td><?= $r['EVENT_ID'] ?></td>

                           <td><?= $r['EVENT_NAME'] ?></td>

                        </tr>

                    <?php } ?>

                </table>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card shadow-sm">

            <div class="card-header">

                Recent Jobs

            </div>

            <div class="card-body">

                <table class="table table-sm">

                    <tr>

                        <th>Job</th>

                        <th>Company</th>

                    </tr>

                    <?php while ($r = oci_fetch_assoc($stid8)) { ?>

                        <tr>

                           <td><?= $r['TITLE'] ?></td>

                            <td><?= $r['COMPANY'] ?></td>

                        </tr>

                    <?php } ?>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header">

        Active Campaigns

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>

                <th>Campaign</th>

                <th>Target Amount</th>

                <th>Start</th>

                <th>End</th>

            </tr>

            <?php while ($r = oci_fetch_assoc($stid9)) { ?>

                <tr>

                    <td><?= $r['TITLE'] ?></td>

                    <td>৳ <?= number_format($r['TARGET_AMOUNT']) ?></td>

                    <td><?= date("d-M-Y", strtotime($r['START_DATE'])) ?></td>

                    <td><?= date("d-M-Y", strtotime($r['END_DATE'])) ?></td>

                </tr>

            <?php } ?>

        </table>

    </div>

</div>

<?php include("includes/footer.php"); ?>