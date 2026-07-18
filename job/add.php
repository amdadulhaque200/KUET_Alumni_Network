
<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

/* ===============================
   INSERT JOB
================================ */

if (isset($_POST['submit'])) {
    $job_id      = $_POST['job_id'];
    $posted_by   = $_POST['posted_by'];
    $title       = $_POST['title'];
    $company     = $_POST['company'];
    $description = $_POST['description'];
    $deadline    = $_POST['deadline'];

    $sql = "
    INSERT INTO JOB_POSTING
    (
        JOB_ID,
        POSTED_BY,
        TITLE,
        COMPANY,
        DESCRIPTION,
        POST_DATE,
        DEADLINE
    )
    VALUES
    (
        :job_id,
        :posted_by,
        :title,
        :company,
        :description,
        SYSDATE,
        TO_DATE(:deadline,'YYYY-MM-DD')
    )
    ";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":job_id", $job_id);
    oci_bind_by_name($stid, ":posted_by", $posted_by);
    oci_bind_by_name($stid, ":title", $title);
    oci_bind_by_name($stid, ":company", $company);
    oci_bind_by_name($stid, ":description", $description);
    oci_bind_by_name($stid, ":deadline", $deadline);

    if (oci_execute($stid)) {
        $message = "<div class='alert alert-success'>
        Job Posted Successfully!
        </div>";
    } else {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>
        " . $e['message'] . "
        </div>";
    }
}

/* ===============================
   LOAD ALUMNI
================================ */

$alumni_sql = "
SELECT
    ALUMNI_ID,
    FIRST_NAME,
    LAST_NAME
FROM ALUMNI
ORDER BY FIRST_NAME
";

$alumni_stid = oci_parse($conn, $alumni_sql);

oci_execute($alumni_stid);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Add New Job

    </h1>

    <p>

        Create a job opportunity for current KUET students.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Job Information

    </div>

    <div class="section-card-body">

        <?php echo $message; ?>

        <form method="post">

            <div class="row g-3">

                <div class="col-md-6">

                    <label>Job ID</label>

                    <input
                        type="number"
                        name="job_id"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Posted By</label>

                    <select
                        name="posted_by"
                        class="form-control"
                        required>

                        <option value="">Select Alumni</option>

                        <?php

                        while ($a = oci_fetch_assoc($alumni_stid)) {

                        ?>

                            <option value="<?= $a['ALUMNI_ID']; ?>">

                                <?= $a['ALUMNI_ID']; ?>

                                -

                                <?= $a['FIRST_NAME'] . " " . $a['LAST_NAME']; ?>

                            </option>

                        <?php

                        }

                        ?>

                    </select>

                </div>

                <div class="col-md-6">

                    <label>Job Title</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Company</label>

                    <input
                        type="text"
                        name="company"
                        class="form-control"
                        required>

                </div>

                <div class="col-12">

                    <label>Description</label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control"
                        required>

</textarea>

                </div>

                <div class="col-md-6">

                    <label>Application Deadline</label>

                    <input
                        type="date"
                        name="deadline"
                        class="form-control"
                        required>

                </div>

            </div>

            <div class="mt-4">

                <a href="list.php" class="btn btn-secondary">

                    Back

                </a>

                <button
                    type="submit"
                    name="submit"
                    class="btn btn-success">

                    Post Job

                </button>

            </div>

        </form>

    </div>

</div>

<?php

include("../includes/footer.php");

?>