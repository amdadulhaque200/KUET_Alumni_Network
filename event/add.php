<?php
include("../includes/auth.php");
include '../config/db.php';
include '../includes/header.php';

if(isset($_POST['submit']))
{
    $id = $_POST['event_id'];
    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $venue = $_POST['venue'];
    $type = $_POST['event_type'];

    $sql = "
INSERT INTO EVENT
(
    event_id,
    event_name,
    event_date,
    venue,
    event_type
)
VALUES
(
    :event_id,
    :event_name,
    TO_DATE(:event_date,'YYYY-MM-DD'),
    :venue,
    :event_type
)
";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":event_id", $id);
    oci_bind_by_name($stid, ":event_name", $name);
    oci_bind_by_name($stid, ":event_date", $date);
    oci_bind_by_name($stid, ":venue", $venue);
    oci_bind_by_name($stid, ":event_type", $type);

    if(oci_execute($stid))
    {
        echo "<h3 class='success'>Event Added Successfully!</h3>";
    }
    else
    {
        $e = oci_error($stid);
        echo "<pre>";
        print_r($e);
        echo "</pre>";
    }
}
?>

<section class="page-hero">
    <h1 class="display-6 mb-2">Add Event</h1>
    <p>Create a new alumni event entry with venue and category.</p>
</section>

<div class="section-card">
    <div class="section-card-header">Event Details</div>
    <div class="section-card-body">
        <form method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Event ID</label>
                    <input type="number" name="event_id" required>
                </div>
                <div class="col-md-6">
                    <label>Event Name</label>
                    <input type="text" name="event_name" required>
                </div>
                <div class="col-md-6">
                    <label>Event Date</label>
                    <input type="date" name="event_date" required>
                </div>
                <div class="col-md-6">
                    <label>Venue</label>
                    <input type="text" name="venue">
                </div>
                <div class="col-md-6">
                    <label>Event Type</label>
                    <select name="event_type">
                        <option value="Reunion">Reunion</option>
                        <option value="Job Fair">Job Fair</option>
                        <option value="Webinar">Webinar</option>
                        <option value="Fundraiser">Fundraiser</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                <a href="list.php" class="btn btn-outline-secondary">Back to List</a>
                <input class="btn-add" type="submit" name="submit" value="Add Event">
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>