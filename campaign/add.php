<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

if (isset($_POST['submit'])) {
    $campaign_id = $_POST['campaign_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $target_amount = $_POST['target_amount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO DONATION_CAMPAIGN
    (
        CAMPAIGN_ID,
        TITLE,
        DESCRIPTION,
        TARGET_AMOUNT,
        START_DATE,
        END_DATE,
        STATUS
    )
    VALUES
    (
        :campaign_id,
        :title,
        :description,
        :target_amount,
        TO_DATE(:start_date,'YYYY-MM-DD'),
        TO_DATE(:end_date,'YYYY-MM-DD'),
        :status
    )";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":campaign_id", $campaign_id);
    oci_bind_by_name($stid, ":title", $title);
    oci_bind_by_name($stid, ":description", $description);
    oci_bind_by_name($stid, ":target_amount", $target_amount);
    oci_bind_by_name($stid, ":start_date", $start_date);
    oci_bind_by_name($stid, ":end_date", $end_date);
    oci_bind_by_name($stid, ":status", $status);

    if (oci_execute($stid)) {
        $message = "<div class='alert alert-success'>
        Campaign Added Successfully.
        </div>";
    } else {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>
        " . $e['message'] . "
        </div>";
    }
}
?>

<section class="page-hero">

    <h1 class="display-6 mb-2">
        Add Campaign
    </h1>

    <p>
        Create a new donation campaign.
    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Campaign Information

    </div>

    <div class="section-card-body">

        <?= $message; ?>

        <form method="post">

            <div class="row g-3">

                <div class="col-md-6">

                    <label>Campaign ID</label>

                    <input
                        type="number"
                        name="campaign_id"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Campaign Title</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        required>

                </div>

                <div class="col-12">

                    <label>Description</label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control"></textarea>

                </div>

                <div class="col-md-6">

                    <label>Target Amount</label>

                    <input
                        type="number"
                        name="target_amount"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Status</label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="ACTIVE">
                            ACTIVE
                        </option>

                        <option value="COMPLETED">
                            COMPLETED
                        </option>

                        <option value="CANCELLED">
                            CANCELLED
                        </option>

                    </select>

                </div>

                <div class="col-md-6">

                    <label>Start Date</label>

                    <input
                        type="date"
                        name="start_date"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>End Date</label>

                    <input
                        type="date"
                        name="end_date"
                        class="form-control"
                        required>

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
                    name="submit"
                    class="btn btn-success">

                    Save Campaign

                </button>

            </div>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>