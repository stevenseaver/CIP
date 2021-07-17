 <!-- Footer -->
 <div class="containter-fluid">
     <footer class="sticky-footer bg-white">
         <div class="container-fluid my-auto">
             <div class="row align-items-center">
                 <div class="col-lg-4 mb-3">
                     <div class="copyright text-left">
                         <span>Copyright &copy; UD. Cakra Inti Plastik 2021</span>
                     </div>
                 </div>
                 <div class="col-lg-4 mb-3 text-center">
                     <a href="<?= base_url('web/privacy_policy') ?>" class="text-secondary small">Privacy Policy</a>
                     |
                     <a href="<?= base_url('web/site_map') ?>" class="text-secondary small">Site Map</a>
                     |
                     <a href="<?= base_url('web/terms') ?>" class="text-secondary small">Terms and Condition</a>
                 </div>
                 <div class="col-lg-4 mb-3 text-right">
                     <a href="https://wa.me/+6282232057755" class="btn btn-success btn-circle" target="_blank">
                         <i class="fab fa-fw fa-whatsapp"></i>
                     </a>
                     <a href="#" class="btn btn-danger btn-circle" target="_blank">
                         <i class="far fa-fw fa-envelope"></i>
                     </a>
                     <a href="https://instagram.com/sbplastik" class="btn btn-warning btn-circle" target="_blank">
                         <i class="fab fa-fw fa-instagram"></i>
                     </a>
                 </div>
             </div>
         </div>
     </footer>
     <!-- End of Footer -->
 </div>

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
             </div>
         </div>
     </div>
 </div>


 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- Bootstrap core JavaScript
 <script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
 <script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>

 <!-- Page level datatables plugins -->
 <script src="<?= base_url('asset/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('asset/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

 <!-- Page level datatables custom scripts -->
 <script src="<?= base_url('asset/') ?>js/demo/datatables-demo.js"></script>

 <script>
     $('.custom-file-input').on('change', function() {
         let fileName = $(this).val().split('\\').pop();
         $(this).next('.custom-file-label').addClass("selected").html(fileName);
     });


     $('.form-check-input').on('click', function() {
         const menuId = $(this).data('menu');
         const roleId = $(this).data('role');

         $.ajax({
             url: "<?= base_url('admin/changeaccess'); ?>",
             type: 'post',
             data: {
                 menuId: menuId,
                 roleId: roleId
             },
             success: function() {
                 document.location.href = "<?= base_url('admin/roleaccess/')  ?>" + roleId;
             }
         });
     });
 </script>

 </body>

 </html>