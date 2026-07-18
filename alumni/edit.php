<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

/* ---------------- UPDATE ---------------- */

if (isset($_POST['update'])) {
       $id      = $_POST['alumni_id'];
       $fname   = $_POST['first_name'];
       $lname   = $_POST['last_name'];
       $email   = $_POST['email'];
       $phone   = $_POST['phone'];
       $dept    = $_POST['dept_id'];
       $batch   = $_POST['batch_id'];
       $job     = $_POST['job'];
       $company = $_POST['company'];
       $city    = $_POST['city'];
       $country = $_POST['country'];
       $ismentor = $_POST['is_mentor'];
       $contact = $_POST['mentor_contact'];
       $linkedin = $_POST['linkedin_url'];

       $sql = "
    UPDATE Alumni
    SET
        first_name = :fname,
        last_name = :lname,
        email = :email,
        phone = :phone,
        dept_id = :dept,
        batch_id = :batch,
        current_job = :job,
        current_company = :company,
        city = :city,
        country = :country,
        IS_MENTOR=:ismentor,
        MENTOR_CONTACT=:contact,
        LINKEDIN_URL=:linkedin
    WHERE alumni_id = :id
    ";

       $stid = oci_parse($conn, $sql);

       oci_bind_by_name($stid, ":fname", $fname);
       oci_bind_by_name($stid, ":lname", $lname);
       oci_bind_by_name($stid, ":email", $email);
       oci_bind_by_name($stid, ":phone", $phone);
       oci_bind_by_name($stid, ":dept", $dept);
       oci_bind_by_name($stid, ":batch", $batch);
       oci_bind_by_name($stid, ":job", $job);
       oci_bind_by_name($stid, ":company", $company);
       oci_bind_by_name($stid, ":city", $city);
       oci_bind_by_name($stid, ":country", $country);
       oci_bind_by_name($stid, ":id", $id);
       oci_bind_by_name($stid, ":ismentor", $ismentor);
       oci_bind_by_name($stid, ":contact", $contact);
       oci_bind_by_name($stid, ":linkedin", $linkedin);

       if (oci_execute($stid)) {
              $message = "
        <div class='alert alert-success'>
            Alumni information updated successfully.
        </div>";
       } else {
              $e = oci_error($stid);

              $message = "
<div class='alert alert-danger'>
Failed to update alumni.
</div>";
       }
}

/* ---------------- LOAD DATA ---------------- */

$id = $_GET['id'];

$sql = "SELECT * FROM Alumni WHERE alumni_id=:id";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ":id", $id);

oci_execute($stid);

$row = oci_fetch_assoc($stid);

?>

<section class="page-hero">

       <h1 class="display-6 mb-2">
              Edit Alumni
       </h1>

       <p>
              Update alumni profile information.
       </p>

</section>

<div class="section-card">

       <div class="section-card-header">

              Alumni Information

       </div>

       <div class="section-card-body">

              <?= $message ?>

              <form method="post">

                     <input
                            type="hidden"
                            name="alumni_id"
                            value="<?= $row['ALUMNI_ID']; ?>">

                     <div class="row g-3">

                            <div class="col-md-6">

                                   <label class="form-label">

                                          KUET Roll Number

                                   </label>

                                   <input
                                          type="text"
                                          class="form-control"
                                          value="<?= $row['ALUMNI_ID']; ?>"
                                          readonly>

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Email

                                   </label>

                                   <input
                                          type="email"
                                          name="email"
                                          class="form-control"
                                          value="<?= $row['EMAIL']; ?>"
                                          required>

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          First Name

                                   </label>

                                   <input
                                          type="text"
                                          name="first_name"
                                          class="form-control"
                                          value="<?= $row['FIRST_NAME']; ?>"
                                          required>

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Last Name

                                   </label>

                                   <input
                                          type="text"
                                          name="last_name"
                                          class="form-control"
                                          value="<?= $row['LAST_NAME']; ?>"
                                          required>

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Phone

                                   </label>

                                   <input
                                          type="text"
                                          name="phone"
                                          class="form-control"
                                          value="<?= $row['PHONE']; ?>">

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Department

                                   </label>

                                   <select
                                          name="dept_id"
                                          class="form-select"
                                          required>

                                          <?php

                                          $dsql = "SELECT dept_id,dept_name
FROM Department
ORDER BY dept_name";

                                          $dstid = oci_parse($conn, $dsql);

                                          oci_execute($dstid);

                                          while ($dept = oci_fetch_assoc($dstid)) {

                                          ?>

                                                 <option
                                                        value="<?= $dept['DEPT_ID']; ?>"

                                                        <?= ($dept['DEPT_ID'] == $row['DEPT_ID']) ? 'selected' : ''; ?>>

                                                        <?= sprintf("%02d", $dept['DEPT_ID']); ?>

                                                        -

                                                        <?= $dept['DEPT_NAME']; ?>

                                                 </option>

                                          <?php } ?>

                                   </select>

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Batch

                                   </label>

                                   <select
                                          name="batch_id"
                                          class="form-select"
                                          required>

                                          <?php

                                          $bsql = "
SELECT batch_id,batch_year
FROM Batch
ORDER BY batch_year DESC
";

                                          $bstid = oci_parse($conn, $bsql);

                                          oci_execute($bstid);

                                          while ($batch = oci_fetch_assoc($bstid)) {

                                          ?>

                                                 <option
                                                        value="<?= $batch['BATCH_ID']; ?>"

                                                        <?= ($batch['BATCH_ID'] == $row['BATCH_ID']) ? 'selected' : ''; ?>>

                                                        Batch <?= $batch['BATCH_YEAR']; ?>

                                                 </option>

                                          <?php } ?>

                                   </select>

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Current Job

                                   </label>

                                   <input
                                          type="text"
                                          name="job"
                                          class="form-control"
                                          value="<?= $row['CURRENT_JOB']; ?>">

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Company

                                   </label>

                                   <input
                                          type="text"
                                          name="company"
                                          class="form-control"
                                          value="<?= $row['CURRENT_COMPANY']; ?>">

                            </div>
                            <div class="col-md-4">

                                   <label>

                                          Is Mentor

                                   </label>

                                   <select
                                          name="is_mentor"
                                          class="form-select">

                                          <option value="Y"
                                                 <?= ($row['IS_MENTOR'] == 'Y') ? 'selected' : ''; ?>>

                                                 Yes

                                          </option>

                                          <option value="N"
                                                 <?= ($row['IS_MENTOR'] == 'N') ? 'selected' : ''; ?>>

                                                 No

                                          </option>

                                   </select>

                            </div>

                            <div class="col-md-4">

                                   <label>

                                          Mentor Contact

                                   </label>

                                   <input
                                          type="text"
                                          name="mentor_contact"
                                          class="form-control"
                                          value="<?= $row['MENTOR_CONTACT']; ?>">

                            </div>

                            <div class="col-md-4">

                                   <label>

                                          LinkedIn

                                   </label>

                                   <input
                                          type="text"
                                          name="linkedin_url"
                                          class="form-control"
                                          value="<?= $row['LINKEDIN_URL']; ?>">

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          City

                                   </label>

                                   <input
                                          type="text"
                                          name="city"
                                          class="form-control"
                                          value="<?= $row['CITY']; ?>">

                            </div>

                            <div class="col-md-6">

                                   <label class="form-label">

                                          Country

                                   </label>

                                   <input
                                          type="text"
                                          name="country"
                                          class="form-control"
                                          value="<?= $row['COUNTRY']; ?>">

                            </div>

                     </div>

                     <div class="d-flex justify-content-between mt-4">

                            <a
                                   href="list.php"
                                   class="btn btn-outline-secondary">

                                   ← Back to Alumni List

                            </a>

                            <button
                                   type="submit"
                                   name="update"
                                   class="btn btn-success">

                                   Update Alumni

                            </button>

                     </div>

              </form>

       </div>

</div>

<?php include("../includes/footer.php"); ?>