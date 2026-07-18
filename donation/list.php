<?php
include("../includes/auth.php");
include '../config/db.php';
include '../includes/header.php';

$search = "";

$sql = "
SELECT
    d.donation_id,
    a.alumni_id,
    a.first_name,
    a.last_name,
    d.amount,
    d.payment_method,
    d.donation_date
FROM Donation d
JOIN Alumni a
ON d.alumni_id = a.alumni_id
";

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = strtoupper(trim($_GET['search']));

    $sql .= "
    WHERE
        UPPER(a.first_name) LIKE :search
        OR UPPER(a.last_name) LIKE :search
        OR TO_CHAR(a.alumni_id) LIKE :search2
    ";
}

$sql .= "
ORDER BY d.donation_date DESC
";

$stid = oci_parse($conn,$sql);

if($search != "")
{
    $like = "%".$search."%";

    oci_bind_by_name($stid,":search",$like);
    oci_bind_by_name($stid,":search2",$like);
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
placeholder="Search Donor..."
value="<?= $search ?>">

<button class="btn-search">
Search
</button>

</form>

<a href="add.php" class="btn-add">
+ Add Donation
</a>

</div>

</div>

<div class="card">

<div class="card-title">
Donation List
</div>

<table>

<tr>

<th>Donation ID</th>

<th>Roll</th>

<th>Donor</th>

<th>Amount</th>

<th>Method</th>

<th>Date</th>

</tr>

<?php while($row=oci_fetch_assoc($stid)){ ?>

<tr>

<td><?= $row['DONATION_ID'] ?></td>

<td><?= $row['ALUMNI_ID'] ?></td>

<td><?= $row['FIRST_NAME']." ".$row['LAST_NAME'] ?></td>

<td>
৳ <?= number_format($row['AMOUNT']) ?>
</td>

<td><?= $row['PAYMENT_METHOD'] ?></td>

<td><?= date("d M Y",strtotime($row['DONATION_DATE'])) ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php
include '../includes/footer.php';
?>