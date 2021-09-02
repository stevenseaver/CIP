 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center mb-2">
             <span>Copyright &copy; UD. Cakra Inti Plastik 2021</span>
         </div>
         <div class="copyright text-center my-auto">
             <span>Telp: +6231 70 11 529 | Email: cipsbp.donotreply@gmail.com</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

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

 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
 <script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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

     //js for menu change access checkbox onclick
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
     //  JavaScript for Edit Role Modal
     $('#editRoleModal').on('show.bs.modal', function(event) {

         //extract data from data-* attributes of modal's toggle button
         var roleid = $(event.relatedTarget).data('id');
         var rolename = $(event.relatedTarget).data('role');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(roleid);
         $(event.currentTarget).find('.modal-body input[name="role"]').val(rolename);
     });

     // JavaScript for Edit Menu Modal
     $('#editmenumodal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var menuid = $(event.relatedTarget).data('menu-id');
         var menuname = $(event.relatedTarget).data('menu-name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="edit_menu_id"]').val(menuid);
         $(event.currentTarget).find('.modal-body input[name="edit_menu_name"]').val(menuname);
     });

     // JavaScript for Delete Menu Modal
     $('#deletemenumodal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var menuid = $(event.relatedTarget).data('menu-id');
         var menuname = $(event.relatedTarget).data('menu-name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_menu_id"]').val(menuid);
         $(event.currentTarget).find('.modal-body input[name="delete_menu_name"]').val(menuname);
     });

     //  JavaScript for Edit Submenu Modal
     $('#editsubmenumodal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var submenuid = $(event.relatedTarget).data('sub_id');
         var submenuname = $(event.relatedTarget).data('title');
         var parentmenu = $(event.relatedTarget).data('menu_id');
         var submenuurl = $(event.relatedTarget).data('url');
         var submenuicon = $(event.relatedTarget).data('icon');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="sub_id"]').val(submenuid);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(submenuname);
         $(event.currentTarget).find('.modal-body select[name="menu_id"]').val(parentmenu);
         $(event.currentTarget).find('.modal-body input[name="url"]').val(submenuurl);
         $(event.currentTarget).find('.modal-body input[name="icon"]').val(submenuicon);
     });

     //  JavaScript for Delete Submenu Modal
     $('#deleteSubMenuModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var submenuid = $(event.relatedTarget).data('sub_id');
         var submenuname = $(event.relatedTarget).data('title');
         var parentmenu = $(event.relatedTarget).data('menu_id');
         var submenuurl = $(event.relatedTarget).data('url');
         var submenuicon = $(event.relatedTarget).data('icon');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="sub_id"]').val(submenuid);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(submenuname);
         $(event.currentTarget).find('.modal-body select[name="menu_id"]').val(parentmenu);
         $(event.currentTarget).find('.modal-body input[name="url"]').val(submenuurl);
         $(event.currentTarget).find('.modal-body input[name="icon"]').val(submenuicon);
     });

     //  JavaScript for Edit Web Menu Modal
     $('#editWebMenuModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var webmenuid = $(event.relatedTarget).data('id');
         var webmenutitle = $(event.relatedTarget).data('title');
         var webmenuurl = $(event.relatedTarget).data('url');
         var webmenuicon = $(event.relatedTarget).data('icon');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(webmenuid);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(webmenutitle);
         $(event.currentTarget).find('.modal-body input[name="url"]').val(webmenuurl);
         $(event.currentTarget).find('.modal-body input[name="icon"]').val(webmenuicon);
     });

     //  JavaScript for Edit Product Menu Modal
     $('#editProductMenu').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var webmenuid = $(event.relatedTarget).data('id');
         var webmenutitle = $(event.relatedTarget).data('title');
         var webmenuurl = $(event.relatedTarget).data('url');
         var webmenuicon = $(event.relatedTarget).data('icon');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(webmenuid);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(webmenutitle);
         $(event.currentTarget).find('.modal-body input[name="url"]').val(webmenuurl);
         $(event.currentTarget).find('.modal-body input[name="icon"]').val(webmenuicon);
     });

     //  JavaScript for Reply User Message
     $('#replyModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var email = $(event.relatedTarget).data('email');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="email"]').val(email);
     });

     //javascript for increment tools
     var quantity = 0;
     $('.quantity-right-plus').click(function(e) {
         // Stop acting like a button
         e.preventDefault();
         // Get the field name
         var quantity = parseInt($('#quantity').val());

         // If is not undefined
         // Increment
         $('#quantity').val(quantity + 1);
     });

     $('.quantity-left-minus').click(function(e) {
         // Stop acting like a button
         e.preventDefault();
         // Get the field name
         var quantity = parseInt($('#quantity').val());

         // If is not undefined
         // Increment
         if (quantity > 0) {
             $('#quantity').val(quantity - 1);
         }
     });

     //  //javascript for select roll
     $('#rolltype').on('change', function(event) {
         var code = $(this).find(':selected').data('code');
         var weight = $(this).find(':selected').data('weight');
         var lipatan = $(this).find(':selected').data('lipatan');

         document.getElementById("code").value = code;
         document.getElementById("weight").value = weight;
         document.getElementById("lipatan").value = lipatan;
     });

     $(document).ready(function() {
         var table = $('#cogstable').DataTable({
             columnDefs: [{
                 width: "2%",
                 targets: 0,
                 width: "45%",
                 targets: 1,
                 orderable: false,
                 targets: [1]
             }]
         });
     });
 </script>

 </body>

 </html>