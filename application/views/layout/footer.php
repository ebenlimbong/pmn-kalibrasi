    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto-close alert notifications after 3.5 seconds
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 3500);
        });

        // Force page reload when accessed via browser's Back/Forward button (bfcache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });

        // Prevent history bloat (multiple back button clicks) by handling Delete & Update via fetch + location.replace
        $(document).on('submit', 'form[action*="/delete"], form[action*="/deleteRiwayat"], form[action*="/storeRiwayat"]', function(e) {
            if (e.isDefaultPrevented()) return; // Skip if inline onsubmit (like confirm) returned false
            
            e.preventDefault();
            var form = this;
            var submitBtn = $(form).find('button[type="submit"]');
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

            fetch(form.action, {
                method: form.method,
                body: new FormData(form),
                redirect: 'manual' // Prevent browser from following redirect and pushing history
            }).then(function() {
                // Replace current history state so we don't trap the user with duplicate history entries
                window.location.replace(window.location.href);
            }).catch(function() {
                window.location.replace(window.location.href);
            });
        });
    </script>
</body>
</html>
