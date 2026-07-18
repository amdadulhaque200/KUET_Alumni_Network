<?php
require_once "../config/db.php";
include "../includes/public_header.php";

$name = isset($_GET['name']) ? trim($_GET['name']) : "";
$dept = isset($_GET['dept']) ? trim($_GET['dept']) : "";
$batch = isset($_GET['batch']) ? trim($_GET['batch']) : "";
$company = isset($_GET['company']) ? trim($_GET['company']) : "";

$sql = "
SELECT
    a.ALUMNI_ID,
    a.FIRST_NAME,
    a.LAST_NAME,
    a.CURRENT_JOB,
    a.CURRENT_COMPANY,
    a.CITY,
    a.COUNTRY,
    d.DEPT_NAME,
    b.BATCH_YEAR,
    a.IS_MENTOR
FROM ALUMNI a
JOIN DEPARTMENT d ON a.DEPT_ID=d.DEPT_ID
JOIN BATCH b ON a.BATCH_ID=b.BATCH_ID
WHERE 1=1
";

if ($name != "") {
    $sql .= " AND (UPPER(a.FIRST_NAME) LIKE :name
                OR UPPER(a.LAST_NAME) LIKE :name)";
}

if ($dept != "") {
    $sql .= " AND a.DEPT_ID=:dept";
}

if ($batch != "") {
    $sql .= " AND a.BATCH_ID=:batch";
}

if ($company != "") {
    $sql .= " AND UPPER(a.CURRENT_COMPANY) LIKE :company";
}

$sql .= " ORDER BY b.BATCH_YEAR DESC,a.FIRST_NAME";

$stid = oci_parse($conn, $sql);

if ($name != "") {
    $n = "%" . strtoupper($name) . "%";
    oci_bind_by_name($stid, ":name", $n);
}

if ($dept != "") {
    oci_bind_by_name($stid, ":dept", $dept);
}

if ($batch != "") {
    oci_bind_by_name($stid, ":batch", $batch);
}

if ($company != "") {
    $c = "%" . strtoupper($company) . "%";
    oci_bind_by_name($stid, ":company", $c);
}

oci_execute($stid);
?>

<section class="page-hero">

    <h1 class="display-5">

        Browse Alumni

    </h1>

    <p>

        Find KUET alumni by name, department, batch or company.

    </p>

</section>

<div class="card shadow mb-5">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-3">

                    <label class="form-label">

                        Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="<?= htmlspecialchars($name) ?>"
                        class="form-control">

                </div>

                <div class="col-md-3">

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

                        $d = oci_parse($conn, "SELECT * FROM DEPARTMENT ORDER BY DEPT_NAME");
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

                <div class="col-md-2">

                    <label class="form-label">

                        Batch

                    </label>

                    <select
                        name="batch"
                        class="form-select">

                        <option value="">

                            All

                        </option>

                        <?php

                        $b = oci_parse($conn, "SELECT * FROM BATCH ORDER BY BATCH_YEAR DESC");
                        oci_execute($b);

                        while ($r = oci_fetch_assoc($b)) {

                        ?>

                            <option
                                value="<?= $r['BATCH_ID']; ?>"
                                <?= ($batch == $r['BATCH_ID']) ? "selected" : ""; ?>>

                                <?= $r['BATCH_YEAR']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-2">

                    <label class="form-label">

                        Company

                    </label>

                    <input
                        type="text"
                        name="company"
                        value="<?= htmlspecialchars($company) ?>"
                        class="form-control">

                </div>

                <div class="col-md-2 d-grid">

                    <label>&nbsp;</label>

                    <button
                        class="btn btn-success">

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

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <img
                        src="../assets/avatar.png"
                        class="rounded-circle mb-3"
                        width="90">

                    <h5>

                        <?= $row['FIRST_NAME'] . " " . $row['LAST_NAME']; ?>

                    </h5>

                    <?php

                    if ($row['IS_MENTOR'] == 'Y') {
                    ?>

                        <span class="badge bg-success mb-2">

                            Mentor

                        </span>

                    <?php
                    }
                    ?>

                    <p class="mb-1">

                        <strong>

                            Department

                        </strong>

                        <br>

                        <?= $row['DEPT_NAME']; ?>

                    </p>

                    <p class="mb-1">

                        <strong>

                            Batch

                        </strong>

                        <br>

                        <?= $row['BATCH_YEAR']; ?>

                    </p>

                    <p class="mb-1">

                        <strong>

                            Job

                        </strong>

                        <br>

                        <?= $row['CURRENT_JOB']; ?>

                    </p>

                    <p class="mb-1">

                        <strong>

                            Company

                        </strong>

                        <br>

                        <?= $row['CURRENT_COMPANY']; ?>

                    </p>

                    <p>

                        <?= $row['CITY']; ?>,
                        <?= $row['COUNTRY']; ?>

                    </p>

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