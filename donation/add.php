<?php

include '../config/db.php';
include '../includes/header.php';

if(isset($_POST['submit']))
{
    $donation_id = $_POST['donation_id'];
    $alumni_id = $_POST['alumni_id'];
    $campaign_id = $_POST['campaign_id'];
    $amount = $_POST['amount'];
    $method = $_POST['payment_method'];

    $sql = "
    BEGIN
        REGISTER_DONATION(
            :donation_id,
            :alumni_id,
            :campaign_id,
            :amount,
            :method
        );
    END;
    ";

    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":donation_id", $donation_id);
    oci_bind_by_name($stid, ":alumni_id", $alumni_id);
    oci_bind_by_name($stid, ":campaign_id", $campaign_id);
    oci_bind_by_name($stid, ":amount", $amount);
    oci_bind_by_name($stid, ":method", $method);

    if(oci_execute($stid))
    {
        echo "<h3 style='color:green'>Donation Added Successfully!</h3>";
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

<h2>Add Donation</h2>

<form method="post">

Donation ID:<br>
<input type="number" name="donation_id" required>
<br><br>

Alumni ID:<br>
<input type="number" name="alumni_id" required>
<br><br>

Campaign ID:<br>
<input type="number" name="campaign_id" required>
<br><br>

Amount:<br>
<input type="number" name="amount" required>
<br><br>

Payment Method:<br>

<select name="payment_method">
    <option value="Bkash">Bkash</option>
    <option value="Card">Card</option>
    <option value="Bank Transfer">Bank Transfer</option>
    <option value="Cash">Cash</option>
</select>

<br><br>

<input type="submit" name="submit" value="Add Donation">

</form>

<?php
include '../includes/footer.php';
?>