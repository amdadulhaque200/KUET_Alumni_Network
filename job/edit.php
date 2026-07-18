<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

/*==============================
UPDATE
==============================*/

if (isset($_POST['update'])) {
    $job_id      = $_POST['job_id'];
    $posted_by   = $_POST['posted_by'];
    $title       = $_POST['title'];
    $company     = $_POST['company'];
    $description = $_POST['description'];
    $deadline    = $_POST['deadline'];

    $sql = "
    UPDATE JOB_POSTING
    SET
        POSTED_BY = :posted_by,
        TITLE = :title,
        COMPANY = :company,
        DESCRIPTION = :description,
        DEADLINE = TO_DATE(:deadline,'YYYY-MM-DD')
    WHERE JOB_ID = :job_id
    ";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":posted_by", $posted_by);
    oci_bind_by_name($stid, ":title", $title);
    oci_bind_by_name($stid, ":company", $company);
    oci_bind_by_name($stid, ":description", $description);
    oci_bind_by_name($stid, ":deadline", $deadline);
    oci_bind_by_name($stid, ":job_id", $job_id);

    if (oci_execute($stid)) {
        $message = "<div class='alert alert-success'>
        Job Updated Successfully.
        </div>";
    } else {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>
        " . $e['message'] . "
        </div>";
    }
}

/*==============================
LOAD DATA
==============================*/

$id = $_GET['id'];

$sql = "SELECT * FROM JOB_POSTING WHERE JOB_ID=:id";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ":id", $id);

oci_execute($stid);

$row = oci_fetch_assoc($stid);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Edit Job

    </h1>

    <p>

        Update Job Information

    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Job Details

    </div>

    <div class="section-card-body">

        <?= $message ?>

        <form method="post">

            <input
                type="hidden"
                name="job_id"
                value="<?= $row['JOB_ID']; ?>">

            <div class="row g-3">

                <div class="col-md-6">

                    <label>Posted By (Alumni ID)</label>

                    <input
                        type="number"
                        name="posted_by"
                        class="form-control"
                        value="<?= $row['POSTED_BY']; ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Job Title</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?= $row['TITLE']; ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Company</label>

                    <input
                        type="text"
                        name="company"
                        class="form-control"
                        value="<?= $row['COMPANY']; ?>">

                </div>

                <div class="col-md-6">

                    <label>Deadline</label>

                    <input
                        type="date"
                        name="deadline"
                        class="form-control"
                        value="<?= date('Y-m-d', strtotime($row['DEADLINE'])); ?>">

                </div>

                <div class="col-12">

                    <label>Description</label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="5"><?= $row['DESCRIPTION']; ?></textarea>

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-between">

                <a
                    href="list.php"
                    class="btn btn-secondary">

                    Back

                </a>

                <input
                    type="submit"
                    name="update"
                    class="btn btn-success"
                    value="Update Job">

            </div>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>