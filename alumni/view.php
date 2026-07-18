<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id = $_GET['id'];

$sql = "
SELECT
    a.*,
    d.DEPT_NAME,
    b.BATCH_YEAR
FROM ALUMNI a
JOIN DEPARTMENT d ON a.DEPT_ID = d.DEPT_ID
JOIN BATCH b ON a.BATCH_ID = b.BATCH_ID
WHERE a.ALUMNI_ID = :id
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":id", $id);
oci_execute($stid);

$row = oci_fetch_assoc($stid);

if (!$row) {
    echo "<div class='alert alert-danger m-4'>Alumni not found.</div>";
    include("../includes/footer.php");
    exit();
}
?>

<section class="page-hero">
    <h1 class="display-6 mb-2">
        Alumni Profile
    </h1>

    <p>
        Complete Alumni Information
    </p>
</section>

<div class="section-card">

    <div class="section-card-header">
        Alumni Details
    </div>

    <div class="section-card-body">

        <div class="row">

            <div class="col-md-3 text-center mb-4">

                <img
                    src="../assets/avatar.png"
                    class="img-fluid rounded-circle border"
                    style="width:170px;height:170px;object-fit:cover;">

                <h4 class="mt-3">
                    <?= $row['FIRST_NAME'] . " " . $row['LAST_NAME']; ?>
                </h4>

                <?php if ($row['IS_MENTOR'] == 'Y') { ?>

                    <span class="badge bg-success fs-6">
                        Mentor
                    </span>

                <?php } else { ?>

                    <span class="badge bg-secondary fs-6">
                        Alumni
                    </span>

                <?php } ?>

            </div>

            <div class="col-md-9">

                <table class="table table-bordered">

                    <tr>
                        <th width="220">KUET Roll</th>
                        <td><?= $row['ALUMNI_ID']; ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?= $row['EMAIL']; ?></td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td><?= $row['PHONE']; ?></td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <td><?= $row['DEPT_NAME']; ?></td>
                    </tr>

                    <tr>
                        <th>Batch</th>
                        <td><?= $row['BATCH_YEAR']; ?></td>
                    </tr>

                    <tr>
                        <th>Current Job</th>
                        <td><?= $row['CURRENT_JOB']; ?></td>
                    </tr>

                    <tr>
                        <th>Current Company</th>
                        <td><?= $row['CURRENT_COMPANY']; ?></td>
                    </tr>

                    <tr>
                        <th>City</th>
                        <td><?= $row['CITY']; ?></td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td><?= $row['COUNTRY']; ?></td>
                    </tr>

                    <tr>
                        <th>Registration Date</th>
                        <td><?= date("d-M-Y", strtotime($row['REG_DATE'])); ?></td>
                    </tr>

                    <tr>
                        <th>Mentor Status</th>

                        <td>

                            <?php
                            if ($row['IS_MENTOR'] == 'Y') {
                                echo "<span class='badge bg-success'>YES</span>";
                            } else {
                                echo "<span class='badge bg-secondary'>NO</span>";
                            }
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <th>Mentor Contact</th>
                        <td>
                            <?= !empty($row['MENTOR_CONTACT']) ? $row['MENTOR_CONTACT'] : "-"; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>LinkedIn</th>
                        <td>

                            <?php
                            if (!empty($row['LINKEDIN_URL'])) {
                            ?>

                                <a href="<?= $row['LINKEDIN_URL']; ?>" target="_blank">
                                    <?= $row['LINKEDIN_URL']; ?>
                                </a>

                            <?php
                            } else {
                                echo "-";
                            }
                            ?>

                        </td>
                    </tr>

                </table>

            </div>

        </div>

        <div class="mt-4 d-flex justify-content-between">

            <a href="list.php" class="btn btn-secondary">

                ← Back

            </a>

            <a href="edit.php?id=<?= $row['ALUMNI_ID']; ?>" class="btn btn-warning">

                Edit Profile

            </a>

        </div>

    </div>

</div>

<?php include("../includes/footer.php"); ?>