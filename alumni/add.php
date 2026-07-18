<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../config/db.php");

$message = "";

if (isset($_POST['submit'])) {
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
    $is_mentor = $_POST['is_mentor'];
    $mentor_contact = $_POST['mentor_contact'];
    $linkedin = $_POST['linkedin_url'];

    $sql = "INSERT INTO ALUMNI
    (
        alumni_id,
        first_name,
        last_name,
        email,
        phone,
        dept_id,
        batch_id,
        current_job,
        current_company,
        city,
        country,
        reg_date,
        IS_MENTOR,
        MENTOR_CONTACT,
        LINKEDIN_URL
    )
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
        SYSDATE,
        :ismentor,
        :contact,
        :linkedin
    )";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":id", $id);
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
    oci_bind_by_name($stid, ":ismentor", $is_mentor);
    oci_bind_by_name($stid, ":contact", $mentor_contact);
    oci_bind_by_name($stid, ":linkedin", $linkedin);

    if (oci_execute($stid)) {
        $message = "<div class='alert alert-success'>
        <strong>Success!</strong> Alumni added successfully.
        </div>";
    } else {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>
Failed to add alumni.
</div>";
    }
}
?>

<section class="page-hero">
    <h1 class="display-6 mb-2">Add New Alumni</h1>
    <p>Create a new alumni profile in the KUET Alumni Network.</p>
</section>

<div class="section-card">

    <div class="section-card-header">
        Alumni Information
    </div>

    <div class="section-card-body">

        <?= $message ?>

        <form method="post">

            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">
                        KUET Roll Number
                    </label>

                    <input
                        type="number"
                        name="alumni_id"
                        class="form-control"
                        placeholder="Example: 1907059"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="example@gmail.com"
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
                        placeholder="01XXXXXXXXX">

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Department
                    </label>

                    <select
                        name="dept_id"
                        class="form-select"
                        required>

                        <option value="">
                            Select Department
                        </option>

                        <?php

                        $dsql = "SELECT dept_id,dept_name
FROM Department
ORDER BY dept_name";

                        $dstid = oci_parse($conn, $dsql);

                        oci_execute($dstid);

                        while ($drow = oci_fetch_assoc($dstid)) {

                        ?>

                            <option value="<?= $drow['DEPT_ID']; ?>">

                                <?= sprintf("%02d", $drow['DEPT_ID']); ?>

                                -

                                <?= $drow['DEPT_NAME']; ?>

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

                        <option value="">
                            Select Batch
                        </option>

                        <?php

                        $bsql = "
SELECT batch_id,batch_year
FROM Batch
ORDER BY batch_year DESC
";

                        $bstid = oci_parse($conn, $bsql);

                        oci_execute($bstid);

                        while ($brow = oci_fetch_assoc($bstid)) {

                        ?>

                            <option value="<?= $brow['BATCH_ID']; ?>">

                                Batch <?= $brow['BATCH_YEAR']; ?>

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
                        placeholder="Software Engineer">

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Company
                    </label>

                    <input
                        type="text"
                        name="company"
                        class="form-control"
                        placeholder="Brain Station 23">

                </div>
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Is Mentor

                    </label>

                    <select
                        name="is_mentor"
                        class="form-select">

                        <option value="N">

                            No

                        </option>

                        <option value="Y">

                            Yes

                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Mentor Contact

                    </label>

                    <input
                        type="text"
                        name="mentor_contact"
                        class="form-control">

                </div>

                <div class="col-md-12 mb-3">

                    <label class="form-label">

                        LinkedIn URL

                    </label>

                    <input
                        type="url"
                        name="linkedin_url"
                        class="form-control"
                        placeholder="https://linkedin.com/in/username">

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        City
                    </label>

                    <input
                        type="text"
                        name="city"
                        class="form-control"
                        placeholder="Dhaka">

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Country
                    </label>

                    <input
                        type="text"
                        name="country"
                        class="form-control"
                        value="Bangladesh">

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
                    name="submit"
                    class="btn btn-success">

                    Save Alumni

                </button>

            </div>

        </form>

    </div>

</div>

<?php
include("../includes/footer.php");
?>