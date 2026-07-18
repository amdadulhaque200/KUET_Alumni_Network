<?php
include("../includes/auth.php");
include '../config/db.php';
include '../includes/header.php';

$search = "";
$message = "";

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "deleted") {
        $message = "
        <div class='alert alert-success'>
            Donation deleted successfully.
        </div>";
    }
}

$sql = "
SELECT

d.DONATION_ID,

a.ALUMNI_ID,
a.FIRST_NAME,
a.LAST_NAME,

c.TITLE AS CAMPAIGN,

d.AMOUNT,
d.PAYMENT_METHOD,
d.DONATION_DATE

FROM DONATION d

JOIN ALUMNI a
ON d.ALUMNI_ID=a.ALUMNI_ID

JOIN DONATION_CAMPAIGN c
ON d.CAMPAIGN_ID=c.CAMPAIGN_ID
";

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $search = strtoupper(trim($_GET['search']));

    $sql .= "

    WHERE

    TO_CHAR(d.DONATION_ID) LIKE :search

    OR

    TO_CHAR(a.ALUMNI_ID) LIKE :search

    OR

    UPPER(a.FIRST_NAME) LIKE :search

    OR

    UPPER(a.LAST_NAME) LIKE :search

    OR

    UPPER(c.TITLE) LIKE :search

    OR

    UPPER(d.PAYMENT_METHOD) LIKE :search

    ";
}

$sql .= "

ORDER BY

d.DONATION_DATE DESC

";

$stid = oci_parse($conn, $sql);

if ($search != "") {
    $like = "%" . $search . "%";

    oci_bind_by_name($stid, ":search", $like);
}

oci_execute($stid);

?>

<div class="page-header">

    <h2>💰 Donation Management</h2>

    <div class="top-buttons">

        <form method="GET" style="display:flex; gap:10px;">

            <input
                type="text"
                name="search"
                placeholder="Search by Roll, Name, Campaign or Payment..."
                value="<?= $search ?>">

            <button class="btn-search">
                Search
            </button>

        </form>

        <a href="add.php" class="btn-add">
            + Add Donation
        </a>

    </div>
    <?= $message; ?>

</div>

<div class="card">

    <div class="card-title">
        Donation List
    </div>

    <table>

        <tr>

            <th>Donation ID</th>

            <th>Alumni</th>

            <th>Campaign</th>

            <th>Amount</th>

            <th>Method</th>

            <th>Date</th>

            <th width="150">Action</th>

        </tr>

        <?php while ($row = oci_fetch_assoc($stid)) { ?>

            <tr>

                <td>

                    <?= $row['DONATION_ID']; ?>

                </td>

                <td>

                    <strong>

                        <?= $row['ALUMNI_ID']; ?>

                    </strong>

                    <br>

                    <small>

                        <?= $row['FIRST_NAME']; ?>

                        <?= $row['LAST_NAME']; ?>

                    </small>

                </td>

                <td style="min-width:250px;">

                    <?= $row['CAMPAIGN']; ?>

                </td>

                <td>

                    <span class="badge bg-success fs-6">

                        ৳ <?= number_format($row['AMOUNT']); ?>

                    </span>

                </td>

                <td>

                    <?php

                    switch ($row['PAYMENT_METHOD']) {
                        case 'Bkash':
                            echo "<span class='badge bg-success'>Bkash</span>";
                            break;

                        case 'Nagad':
                            echo "<span class='badge bg-warning text-dark'>Nagad</span>";
                            break;

                        case 'Rocket':
                            echo "<span class='badge bg-danger'>Rocket</span>";
                            break;

                        case 'Bank Transfer':
                            echo "<span class='badge bg-primary'>Bank</span>";
                            break;

                        default:
                            echo "<span class='badge bg-secondary'>Cash</span>";
                    }

                    ?>

                </td>

                <td>

                    <?= date("d M Y", strtotime($row['DONATION_DATE'])); ?>

                </td>

                <td>
                    <a href="view.php?id=<?= $row['DONATION_ID']; ?>"
                        class="btn btn-info btn-sm">
                        View
                    </a>

                    <a href="edit.php?id=<?= $row['DONATION_ID']; ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="delete.php?id=<?= $row['DONATION_ID']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete this donation?')">
                        Delete
                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

</div>

<?php
include '../includes/footer.php';
?>