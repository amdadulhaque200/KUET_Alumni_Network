<?php

include '../config/db.php';
include '../includes/header.php';

$sql = "
SELECT
    alumni_id,
    first_name,
    last_name,
    email,
    city
FROM ALUMNI_ADMIN.ALUMNI
ORDER BY alumni_id
";

$stid = oci_parse($conn, $sql);
oci_execute($stid);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="mb-0">👨‍🎓 Alumni List</h2>

    <a href="add.php" class="btn btn-success">
        + Add Alumni
    </a>

</div>

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">
            Registered Alumni
        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>City</th>

                        <th width="180">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row = oci_fetch_assoc($stid)) { ?>

                    <tr>

                        <td>
                            <?= $row['ALUMNI_ID']; ?>
                        </td>

                        <td>

                            <strong>

                                <?= $row['FIRST_NAME']; ?>

                                <?= $row['LAST_NAME']; ?>

                            </strong>

                        </td>

                        <td>

                            <?= $row['EMAIL']; ?>

                        </td>

                        <td>

                            <?= $row['CITY']; ?>

                        </td>

                        <td>

                            <a
                                href="edit.php?id=<?= $row['ALUMNI_ID']; ?>"
                                class="btn btn-warning btn-sm">

                                ✏ Edit

                            </a>

                            <a
                                href="delete.php?id=<?= $row['ALUMNI_ID']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this alumni?');">

                                🗑 Delete

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
include '../includes/footer.php';
?>