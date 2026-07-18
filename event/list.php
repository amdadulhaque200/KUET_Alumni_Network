<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$search = "";

$sql = "
SELECT
    EVENT_ID,
    EVENT_NAME,
    EVENT_DATE,
    VENUE,
    EVENT_TYPE
FROM EVENT
";

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = strtoupper(trim($_GET['search']));

    $sql .= "
    WHERE
        UPPER(EVENT_NAME) LIKE :search
        OR UPPER(EVENT_TYPE) LIKE :search2
        OR UPPER(VENUE) LIKE :search3
    ";
}

$sql .= " ORDER BY EVENT_DATE DESC";

$stid = oci_parse($conn, $sql);

if($search != "")
{
    $like = "%".$search."%";

    oci_bind_by_name($stid, ":search", $like);
    oci_bind_by_name($stid, ":search2", $like);
    oci_bind_by_name($stid, ":search3", $like);
}

oci_execute($stid);

?>

<div class="page-header">

    <h2>📅 Event Management</h2>

    <div class="top-buttons">

        <form method="GET" style="display:flex; gap:10px;">

            <input
                type="text"
                name="search"
                placeholder="Search Event..."
                value="<?php echo htmlspecialchars($search); ?>">

            <button class="btn-search" type="submit">
                Search
            </button>

        </form>

        <a href="add.php" class="btn-add">
            + Add Event
        </a>

    </div>

</div>

<div class="card">

<div class="card-title">
Registered Events
</div>

<table>

<tr>

    <th>ID</th>
    <th>Event Name</th>
    <th>Date</th>
    <th>Venue</th>
    <th>Type</th>
    <th>Action</th>

</tr>

<?php while($row = oci_fetch_assoc($stid)){ ?>

<tr>

    <td><?php echo $row['EVENT_ID']; ?></td>

    <td><?php echo $row['EVENT_NAME']; ?></td>

    <td><?php echo date("d M Y", strtotime($row['EVENT_DATE'])); ?></td>

    <td><?php echo $row['VENUE']; ?></td>

    <td><?php echo $row['EVENT_TYPE']; ?></td>

    <td>

        <a class="btn-edit"
           href="edit.php?id=<?php echo $row['EVENT_ID']; ?>">
            ✏ Edit
        </a>

        <a class="btn-delete"
           href="delete.php?id=<?php echo $row['EVENT_ID']; ?>"
           onclick="return confirm('Delete this event?');">
            🗑 Delete
        </a>

    </td>

</tr>

<?php } ?>

</table>

</div>

<?php
include("../includes/footer.php");
?>