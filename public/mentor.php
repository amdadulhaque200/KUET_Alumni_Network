<?php
require_once "../config/db.php";
include "../includes/public_header.php";

$dept = isset($_GET['dept']) ? trim($_GET['dept']) : "";

$sql = "
SELECT
    a.ALUMNI_ID,
    a.FIRST_NAME,
    a.LAST_NAME,
    a.CURRENT_JOB,
    a.CURRENT_COMPANY,
    a.CITY,
    a.COUNTRY,
    a.MENTOR_CONTACT,
    a.LINKEDIN_URL,
    d.DEPT_NAME,
    b.BATCH_YEAR
FROM ALUMNI a
JOIN DEPARTMENT d
ON a.DEPT_ID=d.DEPT_ID
JOIN BATCH b
ON a.BATCH_ID=b.BATCH_ID
WHERE a.IS_MENTOR='Y'
";

if ($dept != "") {
    $sql .= " AND a.DEPT_ID=:dept";
}

$sql .= "
ORDER BY
b.BATCH_YEAR DESC,
a.FIRST_NAME
";

$stid = oci_parse($conn, $sql);

if ($dept != "") {
    oci_bind_by_name($stid, ":dept", $dept);
}

oci_execute($stid);
?>

<section class="page-hero">

    <h1 class="display-5">

        Mentor Directory

    </h1>

    <p>

        Connect with experienced KUET alumni mentors for career guidance,
        higher studies and professional networking.

    </p>

</section>

<div class="card shadow mb-5">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-10">

                    <label class="form-label">

                        Department

                    </label>

                    <select
                        name="dept"
                        class="form-select">

                        <option value="">

                            All Departments

                        </option>

                        <?php

                        $d = oci_parse(
                            $conn,
                            "SELECT *
                             FROM DEPARTMENT
                             ORDER BY DEPT_NAME"
                        );

                        oci_execute($d);

                        while ($r = oci_fetch_assoc($d)) {

                        ?>

                            <option
                                value="<?= $r['DEPT_ID']; ?>"
                                <?= ($dept == $r['DEPT_ID']) ? "selected" : ""; ?>>

                                <?= $r['DEPT_NAME']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-2 d-grid">

                    <label>&nbsp;</label>

                    <button class="btn btn-success">

                        Filter

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

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <img
                        src="../assets/avatar.png"
                        width="100"
                        class="rounded-circle mb-3 border">

                    <h4>

                        <?= $row['FIRST_NAME'] . " " . $row['LAST_NAME']; ?>

                    </h4>

                    <span class="badge bg-success mb-3">

                        KUET Mentor

                    </span>

                    <p>

                        <strong>

                            Department

                        </strong>

                        <br>

                        <?= $row['DEPT_NAME']; ?>

                    </p>

                    <p>

                        <strong>

                            Batch

                        </strong>

                        <br>

                        <?= $row['BATCH_YEAR']; ?>

                    </p>

                    <p>

                        <strong>

                            Current Position

                        </strong>

                        <br>

                        <?= $row['CURRENT_JOB']; ?>

                    </p>

                    <p>

                        <strong>

                            Company

                        </strong>

                        <br>

                        <?= $row['CURRENT_COMPANY']; ?>

                    </p>

                    <p>

                        <strong>

                            Location

                        </strong>

                        <br>

                        <?= $row['CITY']; ?>,
                        <?= $row['COUNTRY']; ?>

                    </p>

                    <hr>

                    <p>

                        <strong>

                            Contact

                        </strong>

                        <br>

                        <?= !empty($row['MENTOR_CONTACT'])
                            ? $row['MENTOR_CONTACT']
                            : "Not Available"; ?>

                    </p>

                    <?php

                    if (!empty($row['LINKEDIN_URL'])) {

                    ?>

                        <a
                            href="<?= $row['LINKEDIN_URL']; ?>"
                            target="_blank"
                            class="btn btn-primary btn-sm">

                            LinkedIn Profile

                        </a>

                    <?php

                    }

                    ?>

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