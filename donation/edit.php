<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

$id = $_GET['id'];

/* ===========================
   LOAD DONATION
=========================== */

$sql = "
SELECT
DONATION_ID,
ALUMNI_ID,
CAMPAIGN_ID,
AMOUNT,
PAYMENT_METHOD
FROM DONATION
WHERE DONATION_ID=:id
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":id", $id);
oci_execute($stid);

$row = oci_fetch_assoc($stid);

if (!$row) {
    echo "<div class='alert alert-danger'>
            Donation not found.
          </div>";

    include("../includes/footer.php");
    exit;
}

/* ===========================
   UPDATE DONATION
=========================== */

if (isset($_POST['update'])) {

    $alumni     = $_POST['alumni_id'];
    $campaign   = $_POST['campaign_id'];
    $amount     = $_POST['amount'];
    $payment    = $_POST['payment_method'];

    $sql = "

    UPDATE DONATION

    SET

        ALUMNI_ID=:alumni,
        CAMPAIGN_ID=:campaign,
        AMOUNT=:amount,
        PAYMENT_METHOD=:payment

    WHERE DONATION_ID=:id

    ";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":alumni", $alumni);
    oci_bind_by_name($stid, ":campaign", $campaign);
    oci_bind_by_name($stid, ":amount", $amount);
    oci_bind_by_name($stid, ":payment", $payment);
    oci_bind_by_name($stid, ":id", $id);

    if (oci_execute($stid)) {

        echo "<div class='alert alert-success'>
                Donation updated successfully.
              </div>";

        $row['ALUMNI_ID'] = $alumni;
        $row['CAMPAIGN_ID'] = $campaign;
        $row['AMOUNT'] = $amount;
        $row['PAYMENT_METHOD'] = $payment;
    } else {

        $e = oci_error($stid);

        echo "<div class='alert alert-danger'>
                " . $e['message'] . "
              </div>";
    }
}

/* ===========================
   LOAD ALUMNI
=========================== */

$alumni_sql = "

SELECT

a.ALUMNI_ID,
a.FIRST_NAME,
a.LAST_NAME,
d.DEPT_NAME,
b.BATCH_YEAR

FROM ALUMNI a

JOIN DEPARTMENT d
ON a.DEPT_ID=d.DEPT_ID

JOIN BATCH b
ON a.BATCH_ID=b.BATCH_ID

ORDER BY a.ALUMNI_ID

";

$alumni_stid = oci_parse($conn, $alumni_sql);
oci_execute($alumni_stid);

/* ===========================
   LOAD CAMPAIGNS
=========================== */

$campaign_sql = "

SELECT

CAMPAIGN_ID,
TITLE

FROM DONATION_CAMPAIGN

ORDER BY TITLE

";

$campaign_stid = oci_parse($conn, $campaign_sql);
oci_execute($campaign_stid);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Edit Donation

    </h1>

    <p>

        Update donation information.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Donation Information

    </div>

    <div class="section-card-body">

        <form method="post">

            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">

                        Donation ID

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= $row['DONATION_ID']; ?>"
                        readonly>

                </div>

                <div class="col-md-6">

                    <label class="form-label">

                        Alumni

                    </label>

                    <select
                        name="alumni_id"
                        class="form-select searchable"
                        required>

                        <?php while ($a = oci_fetch_assoc($alumni_stid)) { ?>

                            <option
                                value="<?= $a['ALUMNI_ID']; ?>"
                                <?= ($a['ALUMNI_ID'] == $row['ALUMNI_ID']) ? 'selected' : ''; ?>>

                                <?= $a['ALUMNI_ID']; ?>

                                |

                                <?= $a['FIRST_NAME']; ?>

                                <?= $a['LAST_NAME']; ?>

                                |

                                <?= $a['DEPT_NAME']; ?>

                                |

                                Batch <?= $a['BATCH_YEAR']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">

                        Campaign

                    </label>

                    <select
                        name="campaign_id"
                        class="form-select searchable"
                        required>

                        <?php while ($c = oci_fetch_assoc($campaign_stid)) { ?>

                            <option
                                value="<?= $c['CAMPAIGN_ID']; ?>"
                                <?= ($c['CAMPAIGN_ID'] == $row['CAMPAIGN_ID']) ? 'selected' : ''; ?>>

                                <?= $c['TITLE']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">

                        Amount

                    </label>

                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        value="<?= $row['AMOUNT']; ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">

                        Payment Method

                    </label>

                    <select
                        name="payment_method"
                        class="form-select">

                        <?php

                        $methods = [
                            "Bkash",
                            "Nagad",
                            "Rocket",
                            "Bank Transfer",
                            "Cash"
                        ];

                        foreach ($methods as $m) {

                        ?>

                            <option
                                value="<?= $m; ?>"
                                <?= ($m == $row['PAYMENT_METHOD']) ? 'selected' : ''; ?>>

                                <?= $m; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>

            <div class="d-flex justify-content-between mt-4">

                <a
                    href="list.php"
                    class="btn btn-secondary">

                    ← Back

                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn btn-primary">

                    Update Donation

                </button>

            </div>

        </form>

    </div>

</div>

<?php
include("../includes/footer.php");
?>