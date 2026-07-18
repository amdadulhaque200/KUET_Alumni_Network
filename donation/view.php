<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$id = $_GET['id'];

$sql = "
SELECT

d.DONATION_ID,
d.AMOUNT,
d.PAYMENT_METHOD,
d.DONATION_DATE,

a.ALUMNI_ID,
a.FIRST_NAME,
a.LAST_NAME,
a.EMAIL,

c.TITLE AS CAMPAIGN

FROM DONATION d

JOIN ALUMNI a
ON d.ALUMNI_ID = a.ALUMNI_ID

JOIN DONATION_CAMPAIGN c
ON d.CAMPAIGN_ID = c.CAMPAIGN_ID

WHERE d.DONATION_ID = :id
";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ":id", $id);

oci_execute($stid);

$row = oci_fetch_assoc($stid);

if (!$row) {
    echo "<div class='alert alert-danger m-4'>
            Donation not found.
          </div>";

    include("../includes/footer.php");
    exit;
}
?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Donation Details

    </h1>

    <p>

        View donation information.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Donation Information

    </div>

    <div class="section-card-body">

        <div class="row g-4">

            <div class="col-md-6">

                <label class="fw-bold">

                    Donation ID

                </label>

                <div>

                    <?= $row['DONATION_ID']; ?>

                </div>

            </div>

            <div class="col-md-6">

                <label class="fw-bold">

                    Donation Date

                </label>

                <div>

                    <?= date("d M Y", strtotime($row['DONATION_DATE'])); ?>

                </div>

            </div>

            <div class="col-md-6">

                <label class="fw-bold">

                    Alumni

                </label>

                <div>

                    <strong>

                        <?= $row['FIRST_NAME']; ?>

                        <?= $row['LAST_NAME']; ?>

                    </strong>

                    <br>

                    Roll: <?= $row['ALUMNI_ID']; ?>

                    <br>

                    <small>

                        <?= $row['EMAIL']; ?>

                    </small>

                </div>

            </div>

            <div class="col-md-6">

                <label class="fw-bold">

                    Campaign

                </label>

                <div>

                    <?= $row['CAMPAIGN']; ?>

                </div>

            </div>

            <div class="col-md-6">

                <label class="fw-bold">

                    Amount

                </label>

                <div>

                    <span class="badge bg-success fs-5">

                        ৳ <?= number_format($row['AMOUNT']); ?>

                    </span>

                </div>

            </div>

            <div class="col-md-6">

                <label class="fw-bold">

                    Payment Method

                </label>

                <div>

                    <?php

                    switch ($row['PAYMENT_METHOD']) {

                        case "Bkash":
                            echo "<span class='badge bg-success'>Bkash</span>";
                            break;

                        case "Nagad":
                            echo "<span class='badge bg-warning text-dark'>Nagad</span>";
                            break;

                        case "Rocket":
                            echo "<span class='badge bg-danger'>Rocket</span>";
                            break;

                        case "Bank Transfer":
                            echo "<span class='badge bg-primary'>Bank Transfer</span>";
                            break;

                        default:
                            echo "<span class='badge bg-secondary'>Cash</span>";
                    }

                    ?>

                </div>

            </div>

        </div>

        <div class="d-flex justify-content-between mt-4">

            <a
                href="list.php"
                class="btn btn-secondary">

                ← Back

            </a>

        </div>

    </div>

</div>

<?php
include("../includes/footer.php");
?>