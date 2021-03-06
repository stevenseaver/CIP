 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center mb-2">
             <span>Copyright &copy; UD. Cakra Inti Plastik 2021</span>
         </div>
         <div class="copyright text-center my-auto">
             <span>Telp: +6231 80 11 529 | Email: cs.sbplastik@gmail.com</span>
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

     //  JavaScript for Delete User Account modal
     $('#deleteAccount').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
     });

     //  JavaScript for Delete User Account modal
     $('#deleteEmployee').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
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

     //  JavaScript for Delete Webmenu Modal
     $('#deleteWebMenuModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         //extract data from data-* attributes of modal's toggle button
         var menuid = $(event.relatedTarget).data('menu-id');
         var menuname = $(event.relatedTarget).data('menu-name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_webmenu_id"]').val(menuid);
         $(event.currentTarget).find('.modal-body input[name="delete_webmenu_name"]').val(menuname);
     });

     //  JavaScript for Delete Product Menu Modal
     $('#deleteProductMenuModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         //extract data from data-* attributes of modal's toggle button
         var menuid = $(event.relatedTarget).data('menu-id');
         var menuname = $(event.relatedTarget).data('menu-name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_productmenu_id"]').val(menuid);
         $(event.currentTarget).find('.modal-body input[name="delete_productmenu_name"]').val(menuname);
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

     //  JavaScript for Create QR invt. Asset Modal
     $('#createQR').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var date = $(event.relatedTarget).data('date');
         var pos = $(event.relatedTarget).data('pos');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="date"]').val(date);
         $(event.currentTarget).find('.modal-body input[name="pos"]').val(pos);
     });

     //  JavaScript for Edit invt. Asset Modal
     $('#editAssetModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var user = $(event.relatedTarget).data('user');
         var spec = $(event.relatedTarget).data('spec');
         var value = $(event.relatedTarget).data('value');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="user"]').val(user);
         $(event.currentTarget).find('.modal-body input[name="spec"]').val(spec);
         $(event.currentTarget).find('.modal-body input[name="value"]').val(value);
     });

     //  JavaScript for Delete invt. Asset Modal
     $('#deleteAssetModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_asset_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_asset_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="delete_asset_name"]').val(name);
     });

     //  JavaScript for Transfer invt. Asset Modal
     $('#transferAssetModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var position = $(event.relatedTarget).data('position');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="transfer_asset_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="transfer_asset_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="asset_departure"]').val(position);
     });

     //  JavaScript for Assign User Invt. Asset Modal
     $('#assignUserModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var position = $(event.relatedTarget).data('position');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="assign_asset_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="assign_asset_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="assign_asset_position"]').val(position);
     });

     //  JavaScript for Use Invt. Asset Modal
     $('#useAssetModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var position = $(event.relatedTarget).data('position');
         var user = $(event.relatedTarget).data('user');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="assign_asset_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="assign_asset_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="assign_asset_position"]').val(position);
         $(event.currentTarget).find('.modal-body input[name="assign_asset_user"]').val(user);
     });

     //  JavaScript for Delete Assign User Invt. Asset Modal
     $('#deleteAssignedUser').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var position = $(event.relatedTarget).data('position');
         var user = $(event.relatedTarget).data('user');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_user_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="delete_user_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_user_position"]').val(position);
         $(event.currentTarget).find('.modal-body input[name="delete_user_user"]').val(user);
     });

     //  JavaScript for Delete Assign User Invt. Asset Modal
     $('#deleteUserModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var code = $(event.relatedTarget).data('code');
         var name = $(event.relatedTarget).data('name');
         var position = $(event.relatedTarget).data('position');
         var user = $(event.relatedTarget).data('user');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_user_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="delete_user_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_user_position"]').val(position);
         $(event.currentTarget).find('.modal-body input[name="delete_user_user"]').val(user);
     });

     //  JavaScript for Edit Customer Data Modal
     $('#editCustomerModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var address = $(event.relatedTarget).data('address');
         var phone = $(event.relatedTarget).data('phone');
         var email = $(event.relatedTarget).data('email');
         var account = $(event.relatedTarget).data('account');
         var terms = $(event.relatedTarget).data('terms');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="address"]').val(address);
         $(event.currentTarget).find('.modal-body input[name="phone_number"]').val(phone);
         $(event.currentTarget).find('.modal-body input[name="email"]').val(email);
         $(event.currentTarget).find('.modal-body input[name="account"]').val(account);
         $(event.currentTarget).find('.modal-body input[name="terms"]').val(terms);
     });

     //  JavaScript for Delete Customer Data Modal
     $('#deleteCustomerModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
     });

     //  JavaScript for Edit Supplier Data Modal
     $('#editSupplierModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var address = $(event.relatedTarget).data('address');
         var phone = $(event.relatedTarget).data('phone');
         var email = $(event.relatedTarget).data('email');
         var account = $(event.relatedTarget).data('account');
         var terms = $(event.relatedTarget).data('terms');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="address"]').val(address);
         $(event.currentTarget).find('.modal-body input[name="phone_number"]').val(phone);
         $(event.currentTarget).find('.modal-body input[name="email"]').val(email);
         $(event.currentTarget).find('.modal-body input[name="account"]').val(account);
         $(event.currentTarget).find('.modal-body input[name="terms"]').val(terms);
     });

     //  JavaScript for Delete Supploer Data Modal
     $('#deleteSupplierModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
     });

     //  JavaScript for Edit GBJ item Modal
     $('#editItemModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
     });

     //  JavaScript for Delete GBJ item Modal
     $('#deleteItemModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_code"]').val(code);
     });

     //  JavaScript for Delete GBJ item Modal
     $('#deleteMaterialItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_code"]').val(code);
     });

     //  JavaScript for Edit material warehouse item Modal
     $('#editMaterial').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var price = $(event.relatedTarget).data('price');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="price"]').val(price);
     });

     //  JavaScript for Edit GBJ item Modal
     $('#editItemModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var pcs = $(event.relatedTarget).data('pcs');
         var pack = $(event.relatedTarget).data('pack');
         var price = $(event.relatedTarget).data('price');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="pcsperpack"]').val(pcs);
         $(event.currentTarget).find('.modal-body input[name="packpersack"]').val(pack);
         $(event.currentTarget).find('.modal-body input[name="price"]').val(price);
     });

     //  JavaScript for Adjust GBJ item Modal
     $('#adjustItemModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="adjust_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="adjust_code"]').val(code);
     });

     //  JavaScript for Edit Blog Post  Modal
     $('#editPostModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var title = $(event.relatedTarget).data('title');
         var meta = $(event.relatedTarget).data('meta');
         var summary = $(event.relatedTarget).data('summary');
         var content = $(event.relatedTarget).data('content');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(title);
         $(event.currentTarget).find('.modal-body input[name="meta"]').val(meta);
         $(event.currentTarget).find('.modal-body input[name="summary"]').val(summary);
         $(event.currentTarget).find('.modal-body input[name="content"]').val(content);
     });

     //  JavaScript for Delete Blog Post  Modal
     $('#deletePostModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var title = $(event.relatedTarget).data('title');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_title"]').val(title);
     });

     //  JavaScript for Add new Transaction Material details transaction
     $('#newTransMatModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
     });

     //  JavaScript for Add new Transaction GBJ details transaction
     $('#newTransModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
     });

     //  JavaScript for Adjust Material WH transaction details 
     $('#adjustMatTrans').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var status = $(event.relatedTarget).data('categories');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="categories"]').val(status);
     });

     //  JavaScript for Adjust GBJ WH transaction details 
     $('#adjustGBJTrans').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var status = $(event.relatedTarget).data('categories');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="categories"]').val(status);
     });

     //  JavaScript for Adjust GBJ details transaction
     $('#deleteTransaction').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var cat = $(event.relatedTarget).data('cat');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_trans_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_trans_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_trans_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="delete_trans_cat"]').val(cat);
         $(event.currentTarget).find('.modal-body input[name="delete_amount"]').val(amount);
     });

     //  JavaScript for Adjust GBJ details transaction
     $('#deleteMaterialTransaction').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var cat = $(event.relatedTarget).data('cat');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_trans_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_trans_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_trans_code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="delete_trans_cat"]').val(cat);
         $(event.currentTarget).find('.modal-body input[name="delete_amount"]').val(amount);
     });

     //  JavaScript for Reply User Message
     $('#replyModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var email = $(event.relatedTarget).data('email');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="email"]').val(email);
     });

     //  JavaScript for Delete Individual cart item Message
     $('#deleteCartIndividualItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var custName = $(event.relatedTarget).data('cust');
         var itemName = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="cust_name"]').val(custName);
         $(event.currentTarget).find('.modal-body input[name="delete_ind_item"]').val(itemName);
     });

     //  JavaScript for Delete All cart item Message
     $('#deleteCartItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
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

 <script>
     $('#btnPrint').click(function() {
         window.print();
     });
 </script>

 </body>

 </html>