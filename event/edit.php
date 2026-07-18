<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$message = "";

if (isset($_POST['update'])) {
    $id = $_POST['event_id'];
    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $venue = $_POST['venue'];
    $type = $_POST['event_type'];

    $sql = "UPDATE EVENT
          SET
            EVENT_NAME=:name,
            EVENT_DATE=TO_DATE(:date,'YYYY-MM-DD'),
            VENUE=:venue,
            EVENT_TYPE=:type
          WHERE EVENT_ID=:id";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":name", $name);
    oci_bind_by_name($stid, ":date", $date);
    oci_bind_by_name($stid, ":venue", $venue);
    oci_bind_by_name($stid, ":type", $type);
    oci_bind_by_name($stid, ":id", $id);

    if (oci_execute($stid)) {
        $message = "<div class='alert alert-success'>
        Event Updated Successfully.
        </div>";
    } else {
        $e = oci_error($stid);

        $message = "<div class='alert alert-danger'>
        " . $e['message'] . "
        </div>";
    }
}

$id = $_GET['id'];

$sql = "SELECT * FROM EVENT
      WHERE EVENT_ID=:id";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ":id", $id);

oci_execute($stid);

$row = oci_fetch_assoc($stid);

?>

<section class="page-hero">

    <h1 class="display-6 mb-2">

        Edit Event

    </h1>

    <p>

        Update event information.

    </p>

</section>

<div class="section-card">

    <div class="section-card-header">

        Event Information

    </div>

    <div class="section-card-body">

        <?= $message; ?>

        <form method="post">

            <input
                type="hidden"
                name="event_id"
                value="<?= $row['EVENT_ID']; ?>">

            <div class="row g-3">

                <div class="col-md-6">

                    <label>Event Name</label>

                    <input
                        type="text"
                        name="event_name"
                        class="form-control"
                        value="<?= htmlspecialchars($row['EVENT_NAME']); ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Event Type</label>

                    <input
                        type="text"
                        name="event_type"
                        class="form-control"
                        value="<?= $row['EVENT_TYPE']; ?>">

                </div>

                <div class="col-md-6">

                    <label>Event Date</label>

                    <input
                        type="date"
                        name="event_date"
                        class="form-control"
                        value="<?= date('Y-m-d', strtotime($row['EVENT_DATE'])); ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Venue</label>

                    <input
                        type="text"
                        name="venue"
                        class="form-control"
                        value="<?= $row['VENUE']; ?>">

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-between">

                <a
                    href="list.php"
                    class="btn btn-secondary">

                    Back

                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn btn-success">

                    Update Event

                </button>

            </div>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>