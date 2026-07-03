<?php
include("../config/db.php");
include("../includes/header.php");

if(isset($_POST['update']))
{
    $id = $_POST['alumni_id'];

    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $city = $_POST['city'];

    $sql = "
    UPDATE Alumni
    SET
        first_name = :fname,
        last_name = :lname,
        city = :city
    WHERE alumni_id = :id
    ";

    $stid = oci_parse($conn,$sql);

    oci_bind_by_name($stid,":fname",$fname);
    oci_bind_by_name($stid,":lname",$lname);
    oci_bind_by_name($stid,":city",$city);
    oci_bind_by_name($stid,":id",$id);

    if(oci_execute($stid))
    {
        echo "<h3 style='color:green'>Updated Successfully!</h3>";
    }
}

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql = "SELECT * FROM Alumni WHERE alumni_id = :id";

    $stid = oci_parse($conn,$sql);

    oci_bind_by_name($stid,":id",$id);

    oci_execute($stid);

    $row = oci_fetch_assoc($stid);
}
?>

<section class="page-hero">
       <h1 class="display-6 mb-2">Edit Alumni</h1>
       <p>Update the core profile fields for this alumnus.</p>
</section>

<div class="section-card">
       <div class="section-card-header">Alumni Profile</div>
       <div class="section-card-body">
              <form method="post">
                     <input type="hidden" name="alumni_id" value="<?php echo $row['ALUMNI_ID']; ?>">
                     <div class="row g-3">
                            <div class="col-md-6">
                                   <label>First Name</label>
                                   <input type="text" name="first_name" value="<?php echo $row['FIRST_NAME']; ?>">
                            </div>
                            <div class="col-md-6">
                                   <label>Last Name</label>
                                   <input type="text" name="last_name" value="<?php echo $row['LAST_NAME']; ?>">
                            </div>
                            <div class="col-12">
                                   <label>City</label>
                                   <input type="text" name="city" value="<?php echo $row['CITY']; ?>">
                            </div>
                     </div>
                     <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                            <a href="list.php" class="btn btn-outline-secondary">Back to List</a>
                            <input type="submit" name="update" class="btn-add" value="Update Alumni">
                     </div>
              </form>
       </div>
</div>

<?php include("../includes/footer.php"); ?>