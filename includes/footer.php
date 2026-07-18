    </main>
    <footer class="site-footer">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>KUET Alumni Network & Donation Tracking System</span>
            <span>Built for alumni, events, donations, and reporting</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.searchable').select2({
                width: '100%',
                placeholder: 'Type to search...',
                allowClear: true
            });

        });
    </script>
    </body>

    </html>