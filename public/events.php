<?php
require_once "../config/db.php";
include "../includes/public_header.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$sql = "
SELECT
    EVENT_ID,
    EVENT_NAME,
    EVENT_DATE,
    VENUE,
    EVENT_TYPE
FROM EVENT
WHERE 1=1
";

if ($search != "") {
    $sql .= "
    AND
    (
        UPPER(EVENT_NAME) LIKE :search
        OR UPPER(VENUE) LIKE :search
        OR UPPER(EVENT_TYPE) LIKE :search2
    )
    ";
}

$sql .= "
ORDER BY EVENT_DATE DESC
";

$stid = oci_parse($conn, $sql);

if ($search != "") {
    $like = "%" . strtoupper($search) . "%";
    oci_bind_by_name($stid, ":search", $like);
    oci_bind_by_name($stid, ":search2", $like);
}

oci_execute($stid);
?>

<section class="page-hero">

    <h1 class="display-5">

        KUET Events

    </h1>

    <p>

        Stay updated with reunions, seminars, workshops and networking events.

    </p>

</section>

<div class="card shadow mb-5">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-10">

                    <label class="form-label">

                        Search Event

                    </label>

                    <input
                        type="text"
                        name="search"
                        value="<?= htmlspecialchars($search); ?>"
                        class="form-control"
                        placeholder="Search by Event, Venue or Type">

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

    <?php while ($row = oci_fetch_assoc($stid)) { ?>

        <div class="col-lg-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h4 class="text-primary">

                        <?= $row['EVENT_NAME']; ?>

                    </h4>

                    <span class="badge bg-success mb-3">

                        <?= $row['EVENT_TYPE']; ?>

                    </span>

                    <hr>

                    <p>

                        <strong>Date</strong>

                        <br>

                        <?= date("d F Y", strtotime($row['EVENT_DATE'])); ?>

                    </p>

                    <p>

                        <strong>Venue</strong>

                        <br>

                        <?= $row['VENUE']; ?>

                    </p>

                </div>

                <div class="card-footer text-end">

                    <span class="badge bg-primary">

                        Upcoming Event

                    </span>

                </div>

            </div>

        </div>

    <?php } ?>

</div>

<?php
include "../includes/public_footer.php";
?>