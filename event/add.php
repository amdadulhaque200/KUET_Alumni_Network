<?php

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
        echo "<h3 style='color:green'>Event Added Successfully!</h3>";
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

<h2>Add Event</h2>

<form method="post">

Event ID:<br>
<input type="number" name="event_id" required>
<br><br>

Event Name:<br>
<input type="text" name="event_name" required>
<br><br>

Event Date:<br>
<input type="date" name="event_date" required>
<br><br>

Venue:<br>
<input type="text" name="venue">
<br><br>

Event Type:<br>

<select name="event_type">
    <option value="Reunion">Reunion</option>
    <option value="Job Fair">Job Fair</option>
    <option value="Webinar">Webinar</option>
    <option value="Fundraiser">Fundraiser</option>
</select>

<br><br>

<input type="submit" name="submit" value="Add Event">

</form>

<?php
include '../includes/footer.php';
?>