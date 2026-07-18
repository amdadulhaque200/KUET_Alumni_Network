
<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$search = "";

/*==============================
    SEARCH QUERY
==============================*/

$sql = "
SELECT
    J.JOB_ID,
    J.TITLE,
    J.COMPANY,
    J.POST_DATE,
    J.DEADLINE,
    A.ALUMNI_ID,
    A.FIRST_NAME,
    A.LAST_NAME
FROM JOB_POSTING J
JOIN ALUMNI A
ON J.POSTED_BY = A.ALUMNI_ID
";

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $search = strtoupper(trim($_GET['search']));

    $sql .= "
    WHERE
        UPPER(J.TITLE) LIKE :search
        OR UPPER(J.COMPANY) LIKE :search2
        OR UPPER(A.FIRST_NAME) LIKE :search3
        OR UPPER(A.LAST_NAME) LIKE :search4
    ";
}

$sql .= "
ORDER BY
J.POST_DATE DESC
";

$stid = oci_parse($conn, $sql);

if ($search != "") {
    $like = "%" . $search . "%";

    oci_bind_by_name($stid, ":search", $like);
    oci_bind_by_name($stid, ":search2", $like);
    oci_bind_by_name($stid, ":search3", $like);
    oci_bind_by_name($stid, ":search4", $like);
}

oci_execute($stid);

/*==============================
TOTAL JOBS
==============================*/

$count_sql = "SELECT COUNT(*) TOTAL FROM JOB_POSTING";

$count_stid = oci_parse($conn, $count_sql);

oci_execute($count_stid);

$count = oci_fetch_assoc($count_stid);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Job Posting Management

    </h1>

    <p>

        Manage career opportunities shared by KUET alumni.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <strong>Total Jobs :</strong>

            <?= $count['TOTAL']; ?>

        </div>

        <div>

            <a href="add.php" class="btn btn-success">

                + Add Job

            </a>

        </div>

    </div>

    <div class="section-card-body">

        <form method="GET" class="row mb-4">

            <div class="col-md-10">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by Job Title, Company or Alumni Name"
                    value="<?= htmlspecialchars($search); ?>">

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary w-100">

                    Search

                </button>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>

                        <th>Job Title</th>

                        <th>Company</th>

                        <th>Posted By</th>

                        <th>Post Date</th>

                        <th>Deadline</th>

                        <th width="180">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php while ($row = oci_fetch_assoc($stid)) { ?>

                        <tr>

                            <td>

                                <?= $row['JOB_ID']; ?>

                            </td>

                            <td>

                                <strong>

                                    <?= $row['TITLE']; ?>

                                </strong>

                            </td>

                            <td>

                                <?= $row['COMPANY']; ?>

                            </td>

                            <td>

                                <?= $row['FIRST_NAME'] . " " . $row['LAST_NAME']; ?>

                                <br>

                                <small>

                                    <?= $row['ALUMNI_ID']; ?>

                                </small>

                            </td>

                            <td>

                                <?= date("d-M-Y", strtotime($row['POST_DATE'])); ?>

                            </td>

                            <td>

                                <?= date("d-M-Y", strtotime($row['DEADLINE'])); ?>

                            </td>

                            <td>

                                <a
                                    href="edit.php?id=<?= $row['JOB_ID']; ?>"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <a
                                    href="delete.php?id=<?= $row['JOB_ID']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this Job?')">

                                    Delete

                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

include("../includes/footer.php");

?>