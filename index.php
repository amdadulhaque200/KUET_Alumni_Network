<?php
require_once 'config/db.php';
include 'includes/header.php';
?>

<section class="page-hero">
	<div class="row align-items-center g-4 position-relative" style="z-index:1;">
		<div class="col-lg-8">
			<p class="text-uppercase fw-semibold mb-2">Welcome to KUET Alumni Network</p>
			<h1 class="display-5 mb-3">Manage alumni, donations, events, and reports from one clean workspace.</h1>
			<p class="mb-4">
				This Oracle and PHP system keeps the alumni database connected to the core management modules with a polished front end.
			</p>
			<div class="mini-actions">
				<a class="btn-add" href="dashboard.php">Open Dashboard</a>
				<a class="btn-search" href="alumni/list.php">Browse Alumni</a>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="section-card bg-white text-dark">
				<div class="section-card-header">System Status</div>
				<div class="section-card-body">
					<p class="mb-2 fw-semibold">Oracle connection is active.</p>
					<p class="mb-0 text-muted">Use the navigation above to move through the modules and reports.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="stats-grid">
	<div class="section-card">
		<div class="section-card-body">
			<h5 class="fw-bold">Alumni</h5>
			<p class="text-muted mb-0">View, search, and manage alumni records.</p>
		</div>
	</div>
	<div class="section-card">
		<div class="section-card-body">
			<h5 class="fw-bold">Donations</h5>
			<p class="text-muted mb-0">Track gift entries, totals, and active campaigns.</p>
		</div>
	</div>
	<div class="section-card">
		<div class="section-card-body">
			<h5 class="fw-bold">Events</h5>
			<p class="text-muted mb-0">Keep reunion and networking events organized.</p>
		</div>
	</div>
</div>

<?php include 'includes/footer.php'; ?>