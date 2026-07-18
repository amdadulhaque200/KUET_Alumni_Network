<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

if (isset($_POST['update'])) {
    $campaign_id = $_POST['campaign_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $target_amount = $_POST['target_amount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $sql = "UPDATE DONATION_CAMPAIGN
            SET
                TITLE = :title,
                DESCRIPTION = :description,
                TARGET_AMOUNT = :target_amount,
                START_DATE = TO_DATE(:start_date,'YYYY-MM-DD'),
                END_DATE = TO_DATE(:end_date,'YYYY-MM-DD'),
                STATUS = :status
            WHERE CAMPAIGN_ID = :campaign_id";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":title", $title);
    oci_bind_by_name($stid, ":description", $description);
    oci_bind_by_name($stid, ":target_amount", $target_amount);
    oci_bind_by_name($stid, ":start_date", $start_date);
    oci_bind_by_name($stid, ":end_date", $end_date);
    oci_bind_by_name($stid, ":status", $status);
    oci_bind_by_name($stid, ":campaign_id", $campaign_id);

    if (oci_execute($stid)) {
        $message = "<div class='alert alert-success'>
        Campaign Updated Successfully.
        </div>";
    } else {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>
        " . $e['message'] . "
        </div>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM DONATION_CAMPAIGN
            WHERE CAMPAIGN_ID = :id";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":id", $id);

    oci_execute($stid);

    $row = oci_fetch_assoc($stid);
}
?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Edit Campaign

    </h1>

    <p>

        Update campaign information.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Campaign Information

    </div>

    <div class="section-card-body">

        <?= $message; ?>

        <form method="post">

            <input
                type="hidden"
                name="campaign_id"
                value="<?= $row['CAMPAIGN_ID']; ?>">

            <div class="row g-3">

                <div class="col-md-6">

                    <label>Campaign Title</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($row['TITLE']); ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Target Amount</label>

                    <input
                        type="number"
                        name="target_amount"
                        class="form-control"
                        value="<?= $row['TARGET_AMOUNT']; ?>"
                        required>

                </div>

                <div class="col-12">

                    <label>Description</label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control"><?= htmlspecialchars($row['DESCRIPTION']); ?></textarea>

                </div>

                <div class="col-md-6">

                    <label>Start Date</label>

                    <input
                        type="date"
                        name="start_date"
                        class="form-control"
                        value="<?= date('Y-m-d', strtotime($row['START_DATE'])); ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>End Date</label>

                    <input
                        type="date"
                        name="end_date"
                        class="form-control"
                        value="<?= date('Y-m-d', strtotime($row['END_DATE'])); ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Status</label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="ACTIVE"
                            <?= $row['STATUS'] == "ACTIVE" ? "selected" : ""; ?>>
                            ACTIVE
                        </option>

                        <option value="COMPLETED"
                            <?= $row['STATUS'] == "COMPLETED" ? "selected" : ""; ?>>
                            COMPLETED
                        </option>

                        <option value="CANCELLED"
                            <?= $row['STATUS'] == "CANCELLED" ? "selected" : ""; ?>>
                            CANCELLED
                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-between">

                <a
                    href="list.php"
                    class="btn btn-secondary">

                    Back

                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn btn-success">

                    Update Campaign

                </button>

            </div>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>