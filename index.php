<?php
require_once 'config/db.php';
include 'includes/public_header.php';

/* ===========================
   TOTAL ALUMNI
=========================== */

$sql1 = "SELECT COUNT(*) TOTAL FROM ALUMNI";
$s1 = oci_parse($conn, $sql1);
oci_execute($s1);
$alumni = oci_fetch_assoc($s1);

/* ===========================
   TOTAL MENTORS
=========================== */

$sql2 = "
SELECT COUNT(*) TOTAL
FROM ALUMNI
WHERE IS_MENTOR='Y'
";

$s2 = oci_parse($conn, $sql2);
oci_execute($s2);
$mentor = oci_fetch_assoc($s2);

/* ===========================
   TOTAL JOBS
=========================== */

$sql3 = "
SELECT COUNT(*) TOTAL
FROM JOB_POSTING
";

$s3 = oci_parse($conn, $sql3);
oci_execute($s3);
$jobs = oci_fetch_assoc($s3);

/* ===========================
   UPCOMING EVENTS
=========================== */

$sql4 = "
SELECT COUNT(*) TOTAL
FROM EVENT
";

$s4 = oci_parse($conn, $sql4);
oci_execute($s4);
$events = oci_fetch_assoc($s4);

/* ===========================
   FEATURED MENTORS
=========================== */

$sql5 = "
SELECT *
FROM
(
SELECT
FIRST_NAME,
LAST_NAME,
CURRENT_JOB,
CURRENT_COMPANY,
CITY
FROM ALUMNI
WHERE IS_MENTOR='Y'
ORDER BY REG_DATE DESC
)
WHERE ROWNUM<=3
";

$s5 = oci_parse($conn, $sql5);
oci_execute($s5);

/* ===========================
   LATEST JOBS
=========================== */

$sql6 = "
SELECT *
FROM
(
SELECT
TITLE,
COMPANY
FROM JOB_POSTING
ORDER BY POST_DATE DESC
)
WHERE ROWNUM<=3
";

$s6 = oci_parse($conn, $sql6);
oci_execute($s6);

/* ===========================
   UPCOMING EVENTS
=========================== */

$sql7 = "
SELECT *
FROM
(
SELECT
EVENT_NAME,
EVENT_DATE,
VENUE
FROM EVENT
ORDER BY EVENT_DATE DESC
)
WHERE ROWNUM<=3
";

$s7 = oci_parse($conn, $sql7);
oci_execute($s7);

?>

<section class="page-hero">

	<div class="row align-items-center">

		<div class="col-lg-7">

			<h1 class="display-4 fw-bold">

				Connecting KUET Alumni,
				Students &
				Future Engineers

			</h1>

			<p class="lead mt-4">

				The KUET Alumni Network helps students connect with alumni,
				discover mentors,
				explore career opportunities,
				participate in events,
				and strengthen the KUET community.

			</p>

			<div class="mt-4">

				<a
					href="public/alumni.php"
					class="btn btn-success btn-lg">

					Browse Alumni

				</a>

				<a
					href="public/mentor.php"
					class="btn btn-outline-light btn-lg ms-2">

					Find Mentors

				</a>

			</div>

		</div>

		<div class="col-lg-5 text-center">

			<img
				src="assets/avatar.png"
				style="max-width:260px;">

		</div>

	</div>

</section>

<div class="row text-center my-5">

	<div class="col-md-3">

		<div class="card shadow">

			<div class="card-body">

				<h2><?= $alumni['TOTAL']; ?></h2>

				<p>Total Alumni</p>

			</div>

		</div>

	</div>

	<div class="col-md-3">

		<div class="card shadow">

			<div class="card-body">

				<h2><?= $mentor['TOTAL']; ?></h2>

				<p>Mentors</p>

			</div>

		</div>

	</div>

	<div class="col-md-3">

		<div class="card shadow">

			<div class="card-body">

				<h2><?= $jobs['TOTAL']; ?></h2>

				<p>Jobs</p>

			</div>

		</div>

	</div>

	<div class="col-md-3">

		<div class="card shadow">

			<div class="card-body">

				<h2><?= $events['TOTAL']; ?></h2>

				<p>Events</p>

			</div>

		</div>

	</div>

</div>

<section class="mb-5">

	<h2 class="mb-4">

		Featured Mentors

	</h2>

	<div class="row">

		<?php while ($r = oci_fetch_assoc($s5)) { ?>

			<div class="col-md-4 mb-4">

				<div class="card shadow h-100">

					<div class="card-body text-center">

						<img
							src="assets/avatar.png"
							width="90"
							class="rounded-circle mb-3">

						<h5>

							<?= $r['FIRST_NAME'] . " " . $r['LAST_NAME']; ?>

						</h5>

						<p>

							<?= $r['CURRENT_JOB']; ?>

						</p>

						<p>

							<?= $r['CURRENT_COMPANY']; ?>

						</p>

						<p>

							<?= $r['CITY']; ?>

						</p>

					</div>

				</div>

			</div>

		<?php } ?>

	</div>

</section>

<div class="row">

	<div class="col-lg-6">

		<div class="card shadow mb-4">

			<div class="card-header">

				Latest Jobs

			</div>

			<div class="card-body">

				<table class="table">

					<?php while ($r = oci_fetch_assoc($s6)) { ?>

						<tr>

							<td>

								<strong>

									<?= $r['TITLE']; ?>

								</strong>

								<br>

								<?= $r['COMPANY']; ?>

							</td>

						</tr>

					<?php } ?>

				</table>

			</div>

		</div>

	</div>

	<div class="col-lg-6">

		<div class="card shadow mb-4">

			<div class="card-header">

				Upcoming Events

			</div>

			<div class="card-body">

				<table class="table">

					<?php while ($r = oci_fetch_assoc($s7)) { ?>

						<tr>

							<td>

								<strong>

									<?= $r['EVENT_NAME']; ?>

								</strong>

								<br>

								<?= date("d M Y", strtotime($r['EVENT_DATE'])); ?>

								<br>

								<?= $r['VENUE']; ?>

							</td>

						</tr>

					<?php } ?>

				</table>

			</div>

		</div>

	</div>

</div>

<?php include 'includes/public_footer.php'; ?>