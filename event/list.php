<?php

include '../config/db.php';
include '../includes/header.php';

$sql = "
SELECT *
FROM EVENT
ORDER BY event_date
";

$stid = oci_parse($conn, $sql);
oci_execute($stid);

?>

<h2>Event List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Event Name</th>
    <th>Date</th>
    <th>Venue</th>
    <th>Type</th>
</tr>

<?php while($row = oci_fetch_assoc($stid)) { ?>

<tr>
    <td><?= $row['EVENT_ID'] ?></td>
    <td><?= $row['EVENT_NAME'] ?></td>
    <td><?= $row['EVENT_DATE'] ?></td>
    <td><?= $row['VENUE'] ?></td>
    <td><?= $row['EVENT_TYPE'] ?></td>
</tr>

<?php } ?>

</table>

<?php
include '../includes/footer.php';
?>