<?php
include("../includes/header.php");
include("../config/db.php");

$sql = "SELECT *
        FROM V_ACTIVE_CAMPAIGNS
        ORDER BY CAMPAIGN_ID";

$stid = oci_parse($conn, $sql);
oci_execute($stid);
?>

<h2>Active Campaigns</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Target Amount</th>
    <th>Start Date</th>
    <th>End Date</th>
</tr>

<?php while($row = oci_fetch_assoc($stid)) { ?>
<tr>
    <td><?= $row['CAMPAIGN_ID'] ?></td>
    <td><?= $row['TITLE'] ?></td>
    <td><?= $row['TARGET_AMOUNT'] ?></td>
    <td><?= $row['START_DATE'] ?></td>
    <td><?= $row['END_DATE'] ?></td>
</tr>
<?php } ?>

</table>

<?php include("../includes/footer.php"); ?>