<?php
include("../includes/auth.php");
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

<section class="page-hero">
    <h1 class="display-6 mb-2">Search Alumni</h1>
    <p>Find alumni by name, email, or city using a cleaner search flow.</p>
</section>

<div class="section-card mb-4">
    <div class="section-card-header">Search Filters</div>
    <div class="section-card-body">
        <form method="get" class="search-form">
            <input type="text" name="keyword" placeholder="Name, Email or City" value="<?php echo htmlspecialchars(isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
            <button type="submit" class="btn-search">Search</button>
            <a href="search.php" class="btn-secondary">Reset</a>
        </form>
    </div>
</div>

<?php if($result) { ?>
<div class="section-card">
    <div class="section-card-header">Search Results</div>
    <div class="table-wrap">
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
    </div>
</div>
<?php } else { ?>
<div class="section-card">
    <div class="section-card-body text-center py-5">
        <h4 class="fw-bold mb-2">No search performed yet</h4>
        <p class="table-note mb-0">Enter a name, email, or city to browse the alumni directory.</p>
    </div>
</div>
<?php } ?>

<?php
include '../includes/footer.php';
?>