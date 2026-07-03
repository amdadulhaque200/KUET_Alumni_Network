<?php
include("../includes/header.php");
include("../config/db.php");

$message = "";

if(isset($_POST['submit']))
{
    $id = $_POST['alumni_id'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dept = $_POST['dept_id'];
    $batch = $_POST['batch_id'];
    $job = $_POST['job'];
    $company = $_POST['company'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    $sql = "INSERT INTO ALUMNI
    VALUES
    (
        :id,
        :fname,
        :lname,
        :email,
        :phone,
        :dept,
        :batch,
        :job,
        :company,
        :city,
        :country,
        SYSDATE
    )";

    $stid = oci_parse($conn,$sql);

    oci_bind_by_name($stid,":id",$id);
    oci_bind_by_name($stid,":fname",$fname);
    oci_bind_by_name($stid,":lname",$lname);
    oci_bind_by_name($stid,":email",$email);
    oci_bind_by_name($stid,":phone",$phone);
    oci_bind_by_name($stid,":dept",$dept);
    oci_bind_by_name($stid,":batch",$batch);
    oci_bind_by_name($stid,":job",$job);
    oci_bind_by_name($stid,":company",$company);
    oci_bind_by_name($stid,":city",$city);
    oci_bind_by_name($stid,":country",$country);

    if(oci_execute($stid))
    {
        $message = "<div class='alert alert-success'>
        Alumni Added Successfully!
        </div>";
    }
    else
    {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>".$e['message']."</div>";
    }
}
?>

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3 class="mb-0">
Add New Alumni
</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="post">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Alumni ID
</label>

<input
type="number"
name="alumni_id"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Email
</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
First Name
</label>

<input
type="text"
name="first_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Last Name
</label>

<input
type="text"
name="last_name"
class="form-control"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Phone
</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Department ID
</label>

<input
type="number"
name="dept_id"
class="form-control"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Batch ID
</label>

<input
type="number"
name="batch_id"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Current Job
</label>

<input
type="text"
name="job"
class="form-control">

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Company
</label>

<input
type="text"
name="company"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
City
</label>

<input
type="text"
name="city"
class="form-control">

</div>

</div>

<div class="mb-4">

<label class="form-label">
Country
</label>

<input
type="text"
name="country"
class="form-control">

</div>

<div class="d-flex justify-content-between">

<a href="list.php" class="btn btn-secondary">
← Back
</a>

<button
type="submit"
name="submit"
class="btn btn-success">

Save Alumni

</button>

</div>

</form>

</div>

</div>

</div>

</div>

<?php
include("../includes/footer.php");
?>