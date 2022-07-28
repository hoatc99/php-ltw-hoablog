<!-- Jquery JS-->
<!-- <script src="assets/vendor/jquery-3.2.1.min.js"></script> -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS-->
<!-- <script src="assets/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="assets/vendor/bootstrap-4.1/bootstrap.min.js"></script> -->
<script src="assets/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="assets/vendor/slick/slick.min.js"></script>
<script src="assets/vendor/wow/wow.min.js"></script>
<script src="assets/vendor/animsition/animsition.min.js"></script>
<script src="assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<script src="assets/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="assets/vendor/counter-up/jquery.counterup.min.js"></script>
<script src="assets/vendor/circle-progress/circle-progress.min.js"></script>
<script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="assets/vendor/select2/select2.min.js"></script>

<!-- Main JS-->
<script src="assets/js/main.js"></script>

<!-- Summernote Js -->
<script src="assets/summernote/summernote.min.js"></script>

<!-- Set Sidebar Active Js -->
<script src="assets/js/set-sidebar-active.js"></script>

<!-- Datatable JS -->
<script src="assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/datatables/js/dataTables.bootstrap4.min.js"></script>

<script>
    $().ready(() => {
        $('#dataTables').DataTable();

        $('#summernote_summary').summernote({
            placeholder: 'Blog summary',
            height: '100',
        });
        $('#summernote_content').summernote({
            placeholder: 'Blog content',
            height: '200',
        });
        $('#summernote_profile').summernote({
            placeholder: 'Something about me',
            height: '200',
        });
    });
</script>