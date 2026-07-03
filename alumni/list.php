<?php

include '../config/db.php';
include '../includes/header.php';

/* Search */

$search = "";

$sql = "
SELECT
    alumni_id,
    first_name,
    last_name,
    email,
    city
FROM Alumni
";

if(isset($_GET['search']) && $_GET['search']!="")
{
    $search = strtoupper(trim($_GET['search']));

    $sql .= "
    WHERE
        UPPER(first_name) LIKE :search
        OR UPPER(last_name) LIKE :search
        OR TO_CHAR(alumni_id) LIKE :search2
    ";
}

$sql .= " ORDER BY alumni_id";

$stid = oci_parse($conn,$sql);

if($search!="")
{
    $like="%".$search."%";

    oci_bind_by_name($stid,":search",$like);
    oci_bind_by_name($stid,":search2",$like);
}

oci_execute($stid);

?>

<div class="page-header">

    <h2>🎓 Alumni Management</h2>

    <div class="top-buttons">

        <form method="GET" style="display:flex; gap:10px;">

            <input
                type="text"
                name="search"
                placeholder="Search by Name or Roll..."
                value="<?php echo $search; ?>"
            >

            <button type="submit" class="btn-search">
                Search
            </button>

        </form>

        <a class="btn-add" href="add.php">
            + Add Alumni
        </a>

    </div>

</div>

<div class="card">

<div class="card-title">
Registered Alumni
</div>

<table>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>City</th>

<th>Action</th>

</tr>

<?php while($row=oci_fetch_assoc($stid)){ ?>

<tr>

<td><?= $row['ALUMNI_ID'] ?></td>

<td>
<?= $row['FIRST_NAME']." ".$row['LAST_NAME'] ?>
</td>

<td><?= $row['EMAIL'] ?></td>

<td><?= $row['CITY'] ?></td>

<td>

<a class="btn-edit"
href="edit.php?id=<?=$row['ALUMNI_ID']?>">

✏ Edit

</a>

<a class="btn-delete"
href="delete.php?id=<?=$row['ALUMNI_ID']?>"
onclick="return confirm('Delete this Alumni?')">

🗑 Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php

include '../includes/footer.php';

?>