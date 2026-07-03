<?php

include '../config/db.php';
include '../includes/header.php';

$sql = "
SELECT
    donation_id,
    alumni_id,
    campaign_id,
    amount,
    donation_date,
    payment_method
FROM DONATION
ORDER BY donation_date DESC
";

$stid = oci_parse($conn, $sql);
oci_execute($stid);

?>

<h2>Donation List</h2>

<table>

<tr>
    <th>Donation ID</th>
    <th>Alumni ID</th>
    <th>Campaign ID</th>
    <th>Amount</th>
    <th>Date</th>
    <th>Payment Method</th>
</tr>

<?php while($row = oci_fetch_assoc($stid)) { ?>

<tr>
    <td><?= $row['DONATION_ID'] ?></td>
    <td><?= $row['ALUMNI_ID'] ?></td>
    <td><?= $row['CAMPAIGN_ID'] ?></td>
    <td><?= $row['AMOUNT'] ?></td>
    <td><?= $row['DONATION_DATE'] ?></td>
    <td><?= $row['PAYMENT_METHOD'] ?></td>
</tr>

<?php } ?>

</table>

<?php
include '../includes/footer.php';
?>