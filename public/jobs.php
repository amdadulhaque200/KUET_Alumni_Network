<?php
require_once "../config/db.php";
include "../includes/public_header.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$sql = "
SELECT
    JOB_ID,
    TITLE,
    COMPANY,
    DESCRIPTION,
    POST_DATE,
    DEADLINE
FROM JOB_POSTING
WHERE 1=1
";

if ($search != "") {
    $sql .= "
    AND
    (
        UPPER(TITLE) LIKE :search
        OR UPPER(COMPANY) LIKE :search
    )
    ";
}

$sql .= "
ORDER BY
POST_DATE DESC
";

$stid = oci_parse($conn, $sql);

if ($search != "") {
    $like = "%" . strtoupper($search) . "%";
    oci_bind_by_name($stid, ":search", $like);
}

oci_execute($stid);
?>

<section class="page-hero">

    <h1 class="display-5">

        Career Opportunities

    </h1>

    <p>

        Explore job opportunities shared by KUET alumni.

    </p>

</section>

<div class="card shadow mb-5">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-10">

                    <label class="form-label">

                        Search Job

                    </label>

                    <input
                        type="text"
                        name="search"
                        value="<?= htmlspecialchars($search); ?>"
                        class="form-control"
                        placeholder="Search by Job Title or Company">

                </div>

                <div class="col-md-2 d-grid">

                    <label>&nbsp;</label>

                    <button class="btn btn-success">

                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="row">

    <?php

    while ($row = oci_fetch_assoc($stid)) {

    ?>

        <div class="col-lg-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h4 class="text-primary">

                        <?= $row['TITLE']; ?>

                    </h4>

                    <h6 class="text-muted">

                        <?= $row['COMPANY']; ?>

                    </h6>

                    <hr>

                    <p>

                        <?= nl2br($row['DESCRIPTION']); ?>

                    </p>

                    <hr>

                    <div class="row">

                        <div class="col-6">

                            <strong>

                                Posted

                            </strong>

                            <br>

                            <?= date("d M Y", strtotime($row['POST_DATE'])); ?>

                        </div>

                        <div class="col-6">

                            <strong>

                                Deadline

                            </strong>

                            <br>

                            <?= date("d M Y", strtotime($row['DEADLINE'])); ?>

                        </div>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <span class="badge bg-success">

                        Open Position

                    </span>

                </div>

            </div>

        </div>

    <?php

    }

    ?>

</div>

<?php
include "../includes/public_footer.php";
?>