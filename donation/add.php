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
        echo "<div class='success'>Donation Added Successfully.</div>";
    }
    else
    {
        $e = oci_error($stid);
        echo "<div class='error'>".$e['message']."</div>";
    }
}
?>

<section class="page-hero">
    <h1 class="display-6 mb-2">Add New Donation</h1>
    <p>Record a donation entry tied to an alumni and campaign.</p>
</section>

<div class="section-card">
    <div class="section-card-header">Donation Information</div>
    <div class="section-card-body">
        <form method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Donation ID</label>
                    <input type="number" name="donation_id" required>
                </div>
                <div class="col-md-6">
                    <label>Alumni ID</label>
                    <input type="number" name="alumni_id" required>
                </div>
                <div class="col-md-6">
                    <label>Campaign ID</label>
                    <input type="number" name="campaign_id" required>
                </div>
                <div class="col-md-6">
                    <label>Amount</label>
                    <input type="number" name="amount" required>
                </div>
                <div class="col-md-6">
                    <label>Donation Date</label>
                    <input type="date" name="donation_date" required>
                </div>
                <div class="col-md-6">
                    <label>Payment Method</label>
                    <select name="payment_method">
                        <option value="Bkash">Bkash</option>
                        <option value="Card">Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash">Cash</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                <a href="list.php" class="btn btn-outline-secondary">Back to List</a>
                <input class="btn-add" type="submit" name="submit" value="Add Donation">
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>