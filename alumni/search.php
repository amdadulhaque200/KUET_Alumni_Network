<?php

include '../config/db.php';
include '../includes/header.php';

$result = null;

if(isset($_GET['keyword']))
{
    $keyword = $_GET['keyword'];

    $sql = "
    SELECT
        alumni_id,
        first_name,
        last_name,
        email,
        city
    FROM ALUMNI
    WHERE
        LOWER(first_name) LIKE LOWER(:keyword)
        OR LOWER(email) LIKE LOWER(:keyword)
        OR LOWER(city) LIKE LOWER(:keyword)
    ORDER BY alumni_id
    ";

    $stid = oci_parse($conn,$sql);

    $search = "%" . $keyword . "%";

    oci_bind_by_name($stid,":keyword",$search);

    oci_execute($stid);

    $result = $stid;
}
?>

<h2>Search Alumni</h2>

<form method="get">

<input
type="text"
name="keyword"
placeholder="Name, Email or City">

<input
type="submit"
value="Search">

</form>

<br>

<?php if($result) { ?>

<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>City</th>
</tr>

<?php while($row = oci_fetch_assoc($result)) { ?>

<tr>
    <td><?= $row['ALUMNI_ID'] ?></td>
    <td><?= $row['FIRST_NAME'].' '.$row['LAST_NAME'] ?></td>
    <td><?= $row['EMAIL'] ?></td>
    <td><?= $row['CITY'] ?></td>
</tr>

<?php } ?>

</table>

<?php } ?>

<?php
include '../includes/footer.php';
?>