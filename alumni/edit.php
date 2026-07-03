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

<h2>Edit Alumni</h2>

<form method="post">

<input type="hidden"
       name="alumni_id"
       value="<?php echo $row['ALUMNI_ID']; ?>">

First Name:<br>
<input type="text"
       name="first_name"
       value="<?php echo $row['FIRST_NAME']; ?>">
<br><br>

Last Name:<br>
<input type="text"
       name="last_name"
       value="<?php echo $row['LAST_NAME']; ?>">
<br><br>

City:<br>
<input type="text"
       name="city"
       value="<?php echo $row['CITY']; ?>">
<br><br>

<input type="submit"
       name="update"
       value="Update">

</form>

<?php include("../includes/footer.php"); ?>