<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$search = "";

$sql = "
SELECT *
FROM DONATION_CAMPAIGN
";

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $search = strtoupper(trim($_GET['search']));

    $sql .= "
    WHERE
        UPPER(TITLE) LIKE :search
        OR UPPER(STATUS) LIKE :search2
        OR TO_CHAR(CAMPAIGN_ID) LIKE :search3
    ";
}

$sql .= "
ORDER BY CAMPAIGN_ID DESC
";

$stid = oci_parse($conn, $sql);

if ($search != "") {
    $like = "%" . $search . "%";

    oci_bind_by_name($stid, ":search", $like);
    oci_bind_by_name($stid, ":search2", $like);
    oci_bind_by_name($stid, ":search3", $like);
}

oci_execute($stid);

$count_sql = "SELECT COUNT(*) TOTAL FROM DONATION_CAMPAIGN";

$count_stid = oci_parse($conn, $count_sql);

oci_execute($count_stid);

$count = oci_fetch_assoc($count_stid);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Donation Campaigns

    </h1>

    <p>

        Manage all donation campaigns.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header d-flex justify-content-between align-items-center">

        <div>

            <strong>Total Campaigns :</strong>

            <?= $count['TOTAL']; ?>

        </div>

        <div>

            <a
                href="add.php"
                class="btn btn-success">

                + Add Campaign

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
                    placeholder="Search by Campaign ID, Title or Status"
                    value="<?= htmlspecialchars($search); ?>">

            </div>

            <div class="col-md-2">

                <button
                    class="btn btn-primary w-100">

                    Search

                </button>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>

                        <th>Title</th>

                        <th>Target</th>

                        <th>Start</th>

                        <th>End</th>

                        <th>Status</th>

                        <th width="170">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php while ($row = oci_fetch_assoc($stid)) { ?>

                        <tr>

                            <td>

                                <?= $row['CAMPAIGN_ID']; ?>

                            </td>

                            <td>

                                <strong>

                                    <?= $row['TITLE']; ?>

                                </strong>

                                <br>

                                <small>

                                    <?= $row['DESCRIPTION']; ?>

                                </small>

                            </td>

                            <td>

                                ৳ <?= number_format($row['TARGET_AMOUNT']); ?>

                            </td>

                            <td>

                                <?= date("d-M-Y", strtotime($row['START_DATE'])); ?>

                            </td>

                            <td>

                                <?= date("d-M-Y", strtotime($row['END_DATE'])); ?>

                            </td>

                            <td>

                                <?php

                                $status = $row['STATUS'];

                                if ($status == "ACTIVE") {
                                    echo "<span class='badge bg-success'>ACTIVE</span>";
                                } elseif ($status == "COMPLETED") {
                                    echo "<span class='badge bg-primary'>COMPLETED</span>";
                                } else {
                                    echo "<span class='badge bg-danger'>CANCELLED</span>";
                                }

                                ?>

                            </td>

                            <td>

                                <a
                                    href="edit.php?id=<?= $row['CAMPAIGN_ID']; ?>"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <a
                                    href="delete.php?id=<?= $row['CAMPAIGN_ID']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this Campaign?')">

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

<?php include("../includes/footer.php"); ?>