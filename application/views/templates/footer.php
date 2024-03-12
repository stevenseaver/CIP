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
 <script src="<?= base_url('asset/'); ?>js/sb-admin-2.js"></script>

 <!-- Page level datatables plugins -->
 <script src="<?= base_url('asset/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('asset/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

 <!-- Page level datatables custom scripts -->
 <script src="<?= base_url('asset/') ?>js/demo/datatables-demo.js"></script>

 <script>
     function visibilePassword() {
         var x = document.getElementById("password1");
         var y = document.getElementById("password2");
         if (x.type === "password" & y.type === "password") {
             x.type = "text";
             y.type = "text";
         } else {
             x.type = "password";
             y.type = "password";
         }
     }

     $('.custom-file-input').on('change', function() {
         let fileName = $(this).val().split('\\').pop();
         $(this).next('.custom-file-label').addClass("selected").html(fileName);
     });

     //js for check prod_category
     function category_check(category) {
         if (category.value == "6") {
             document.getElementById("packing_product").style.display = "none";
             document.getElementById("weighted_product").style.display = "none";
             document.getElementById("pcsperpack").value = 0;
             document.getElementById("packpersack").value = 0;
             document.getElementById("conversion").value = 25;
         } else if (category.value == "7") {
             document.getElementById("packing_product").style.display = "";
             document.getElementById("weighted_product").style.display = "";
         } else {
             document.getElementById("packing_product").style.display = "";
             document.getElementById("weighted_product").style.display = "none";
             document.getElementById("conversion").value = 1;
         } 
     }
        
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

     //js for menu change cart quantity on input on change
     $('.input-qty').on('change', function() {
         //const qtyID = $(this).data('qty');
         const itemID = $(this).data('item');
         const id = $(this).data('id');
         const qtyID = document.getElementById("qtyAmount-" + id).value;
         const priceID = $(this).data('price');

         $.ajax({
             url: "<?= base_url('customer/update_cart'); ?>",
             type: 'post',
             data: {
                 qtyID: qtyID,
                 itemID: itemID,
                 id: id,
                 priceID: priceID
             },
             success: function() {
                 document.location.href = "<?= base_url('customer/cart')  ?>";
             }
         });
     });

     //js for menu change cart quantity on input on change
     $('.input-qty-so').on('change', function() {
         //const qtyID = $(this).data('qty');
         const item_name = $(this).data('item');
         const ref = $(this).data('ref');
         const id = $(this).data('id');
         const qtyID = document.getElementById("qtyAmount-" + id).value;
         const priceID = $(this).data('price');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID
             },
             success: function() {
                 window.location.reload();  
             }
         });
     });
     
     //js for menu change cart quantity on input on change
     $('.input-price-so').on('change', function() {
         //const qtyID = $(this).data('qty');
         const item_name = $(this).data('item');
         const ref = $(this).data('ref');
         const id = $(this).data('id');
         const priceID = document.getElementById("priceAmount-" + id).value;
         const qtyID = $(this).data('amount');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID
             },
             success: function() {
                 window.location.reload();  
             }
         });
     });

     //js for amount change on purchase order quantity on input on change
     $('.edit-qty').on('change', function() {
         const id = $(this).data('id');
         const qtyID = document.getElementById("receiveAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('purchasing/update_amount'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on receive order quantity on input on change
     $('.receive-qty').on('change', function() {
         const id = $(this).data('id');
         const qtyID = document.getElementById("receiveAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('purchasing/update_amount'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });
     
     //js for amount change on receive order quantity on input on change
     $('.return-qty').on('change', function() {
         const id = $(this).data('id');
         const qtyID = document.getElementById("returnAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('purchasing/update_amount_return'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     $('.btn-add-item').on('click', function() {
         //const qtyID = $(this).data('qty');
         const po_id = $(this).data('po');

         $.ajax({
             url: "<?= base_url('purchasing/add_item_po'); ?>",
             type: 'post',
             data: {
                 po_id: po_id
             },
             success: function() {
                 document.location.href = "<?= base_url('purchasing/add_po')  ?>";
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.material-qty').on('change', function() {
         const id = $(this).data('id');
         const prodID = $(this).data('prodID');

         const qtyID = document.getElementById("materialAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_amount'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID,
                 prodID: prodID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.desc-qty').on('change', function() {
         const id = $(this).data('id');
         const prodID = $(this).data('prodID');

         const qtyID = document.getElementById("descAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_desc'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID,
                 prodID: prodID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on roll item prod order quantity input on change
     $('.roll-qty').on('change', function() {
         const id = $(this).data('id');
         const prodID = $(this).data('prodID');

         const qtyID = document.getElementById("rollAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_roll_amount'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID,
                 prodID: prodID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.roll-desc').on('change', function() {
         const id = $(this).data('id');

         const descRoll = document.getElementById("rollDesc-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_roll_details/1'); ?>",
             type: 'post',
             data: {
                 id: id,
                 descRoll: descRoll
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.roll-batch').on('change', function() {
         const id = $(this).data('id');

         const batchRoll = document.getElementById("rollBatch-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_roll_details/2'); ?>",
             type: 'post',
             data: {
                 id: id,
                 batchRoll: batchRoll
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.roll-price').on('change', function() {
         const id = $(this).data('id');

         const priceRoll = document.getElementById("rollPrice-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_roll_details/3'); ?>",
             type: 'post',
             data: {
                 id: id,
                 priceRoll: priceRoll
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on gbj item prod order quantity input on change
     $('.gbj-qty').on('change', function() {
         const id = $(this).data('id');
         const prodID = $(this).data('prodID');
         const cat = $(this).data('cat');
         const status = $(this).data('status');

         const qtyID = document.getElementById("gbjAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_gbj_amount'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID,
                 prodID: prodID,
                 cat : cat,
                 status : status
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.gbj-desc').on('change', function() {
         const id = $(this).data('id');

         const descGBJ = document.getElementById("gbjDesc-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_gbj_details/1'); ?>",
             type: 'post',
             data: {
                 id: id,
                 descGBJ: descGBJ
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.gbj-price').on('change', function() {
         const id = $(this).data('id');

         const priceGBJ = document.getElementById("gbjPrice-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_gbj_details/2'); ?>",
             type: 'post',
             data: {
                 id: id,
                 priceGBJ: priceGBJ
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.gbj-batch').on('change', function() {
         const id = $(this).data('id');

         const batchGBJ = document.getElementById("gbjBatch-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_gbj_details/3'); ?>",
             type: 'post',
             data: {
                 id: id,
                 batchGBJ: batchGBJ
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.cogs-qty').on('change', function() {
         const id = $(this).data('id');
         const qtyID = document.getElementById("materialAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_cogs_amount'); ?>",
             type: 'post',
             data: {
                 id: id,
                 qtyID: qtyID
             },
             success: function() {
                 document.location.href = "<?= base_url('production/cogs_calculator/') ?>";
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.cogs-price').on('change', function() {
         const id = $(this).data('id');
         const price = document.getElementById("materialPrice-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_cogs_price'); ?>",
             type: 'post',
             data: {
                 id: id,
                 price: price
             },
             success: function() {
                 document.location.href = "<?= base_url('production/cogs_calculator/') ?>";
             }
         });
     });

     //  JavaScript for add item to sales order database cart
     $(".select-customer").click(function() {
         //extract data from data-* attributes of modal's add button
         var $row = $(this).closest("tr"); // Find the row
         var $cust_name = $row.find(".cust_name").text();
         var $id = $row.find(".id").text();
         var $address = $row.find(".address").text();

         // input passed data using JS to object INPUT from modal #newItem 
         document.getElementById("cust_name").value = $cust_name;
         document.getElementById("cust_id").value = $id;
         document.getElementById("address").value = $address;
        //  document.getElementById("pcsperpack").value = pcs;
        //  document.getElementById("packpersack").value = pack;
     });

     //  JavaScript for add item to sales order database cart
     $(".select-item").click(function() {
         //extract data from data-* attributes of modal's add button
         var $row = $(this).closest("tr"); // Find the row
         var $name = $row.find(".name").text();
         var $code = $row.find(".code").text();
         var $in_stock = $row.find(".in_stock").text();
         var $price = $row.find(".price").text();
         var $pcsperpack = $row.find(".pcsperpack").text();
         var $packpersack = $row.find(".packpersack").text();
         var $unit = $row.find(".unit").text();

         // input passed data using JS to object INPUT from modal #newItem 
         document.getElementById("name").value = $name;
         document.getElementById("code").value = $code;
         document.getElementById("instock").value = $in_stock;
         document.getElementById("price").value = $price;
         document.getElementById("pcsperpack").value = $pcsperpack;
         document.getElementById("packpersack").value = $packpersack;
         document.getElementById("unit").innerText = $unit;
        //  document.getElementById("pcsperpack").value = pcs;
        //  document.getElementById("packpersack").value = pack;
     });
     
     //  JavaScript for add item to sales order database cart
     $(".select-item-po").click(function() {
         //extract data from data-* attributes of modal's add button
         var $row = $(this).closest("tr"); // Find the row
         var $id = $row.find(".id").text();
         var $name = $row.find(".name").text();
         var $unit = $row.find(".unit").text();
         var $price = $row.find(".price").text();

         // input passed data using JS to object INPUT from modal #newItem 
         document.getElementById("material").value = $id;
         document.getElementById("materialName").value = $name;
         document.getElementById("price").value = $price;
         document.getElementById("unit_amount").innerText = $unit;
     });

     //  JavaScript for add item to sales order database cart
     $(".select-item-prod").click(function() {
         //extract data from data-* attributes of modal's add button
         var $row = $(this).closest("tr"); // Find the row
         var $id = $row.find(".id").text();
         var $name = $row.find(".name").text();
         var $in_stock = $row.find(".in_stock").text();
         var $price = $row.find(".price").text();
         var $unit = $row.find(".unit").text();

         // input passed data using JS to object INPUT from modal #newItem 
         document.getElementById("materialSelect").value = $id;
         document.getElementById("materialName").value = $name;
         document.getElementById("stock").value = $in_stock;
         document.getElementById("price").value = $price;
         document.getElementById("unit_amount").innerText = $unit;
         document.getElementById("unit_instock").innerText = $unit;
     });

     //  JavaScript for add item to sales order database cart
     $(".select-item-roll").click(function() {
         //extract data from data-* attributes of modal's add button
         var $row = $(this).closest("tr"); // Find the row
         var $name = $row.find(".name").text();
         var $code = $row.find(".code").text();
         var $weight = $row.find(".weight").text();
         var $lipatan = $row.find(".lipatan").text();
         var $price = $row.find(".price").text();

         // input passed data using JS to object INPUT from modal #newItem =
         document.getElementById("rollName").value = $name;
         document.getElementById("code").value = $code;
         document.getElementById("weight").value = $weight;
         document.getElementById("lipatan").value = $lipatan;
         document.getElementById("price").value = $price;
        //  document.getElementById("pcsperpack").value = pcs;
        //  document.getElementById("packpersack").value = pack;
     });
     
     //  JavaScript for add item to sales order database cart
     $(".select-item-gbj").click(function() {
         //extract data from data-* attributes of modal's add button
         var $row = $(this).closest("tr"); // Find the row
         var $name = $row.find(".name").text();
         var $code = $row.find(".code").text();
         var $pcsperpack = $row.find(".pcsperpack").text();
         var $packpersack = $row.find(".packpersack").text();
         var $price = $row.find(".price").text();
         var $in_stock = $row.find(".in_stock").text();

         // input passed data using JS to object INPUT from modal #newItem =
         document.getElementById("gbjSelect").value = $name;
         document.getElementById("code").value = $code;
         document.getElementById("pcsperpack").value = $pcsperpack;
         document.getElementById("packpersack").value = $packpersack;
         document.getElementById("price").value = $price;
         document.getElementById("instock").value = $in_stock;
        //  document.getElementById("pcsperpack").value = pcs;
        //  document.getElementById("packpersack").value = pack;
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

     //  JavaScript for Delete Sales order modal
     $('#deleteSalesOrder').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');

         // input passed data using JS to object INPUT inside modal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_ref"]').val(name);
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

     //  JavaScript for Delete Product Menu/Category Modal
     $('#deleteProductMenuModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         //extract data from data-* attributes of modal's toggle button
         var menuid = $(event.relatedTarget).data('menu-id');
         var menuname = $(event.relatedTarget).data('menu-name');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_productmenu_id"]').val(menuid);
         $(event.currentTarget).find('.modal-body input[name="delete_productmenu_name"]').val(menuname);
     });

     //  JavaScript for Delete Material Category Modal
     $('#deleteMaterialCat').on('show.bs.modal', function(event) {
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

     //  JavaScript for Edit Product Menu/Category Modal
     $('#editProductMenu').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var webmenuid = $(event.relatedTarget).data('id');
         var webmenutitle = $(event.relatedTarget).data('title');
         var unit = $(event.relatedTarget).data('unit');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(webmenuid);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(webmenutitle);
         $(event.currentTarget).find('.modal-body input[name="unit"]').val(unit);
     });

     //  JavaScript for Edit Material Category Modal
     $('#editMaterialCat').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var webmenuid = $(event.relatedTarget).data('id');
         var webmenutitle = $(event.relatedTarget).data('title');
         var unit = $(event.relatedTarget).data('unit');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(webmenuid);
         $(event.currentTarget).find('.modal-body input[name="title"]').val(webmenutitle);
         $(event.currentTarget).find('.modal-body input[name="unit"]').val(unit);
     });

     //  JavaScript for Edit Product Menu Modal
     $('#editSpecItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var spec = $(event.relatedTarget).data('spec');
         var content = $(event.relatedTarget).data('content');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="edit_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="edit_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="edit_spec"]').val(spec);
         $(event.currentTarget).find('.modal-body input[name="edit_content"]').val(content);
     });

     //  JavaScript for Edit Product Menu Modal
     $('#deleteSpecItemModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var spec = $(event.relatedTarget).data('spec');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_spec"]').val(spec);
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
         $(event.currentTarget).find('.modal-body select[name="terms"]').val(terms);
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

         // input passed data using JS to object INPUT inside modal #editSupplierModal
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="address"]').val(address);
         $(event.currentTarget).find('.modal-body input[name="phone_number"]').val(phone);
         $(event.currentTarget).find('.modal-body input[name="email"]').val(email);
         $(event.currentTarget).find('.modal-body input[name="account"]').val(account);
         $(event.currentTarget).find('.modal-body select[name="terms"]').val(terms);
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
         var supplier = $(event.relatedTarget).data('supplier');
         var price = $(event.relatedTarget).data('price');
         var cat = $(event.relatedTarget).data('cat');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body select[name="supplier"]').val(supplier);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="price"]').val(price);
         $(event.currentTarget).find('.modal-body select[name="category"]').val(cat);
     });

     //  JavaScript for Edit production warehouse item  item Modal
     $('#editProdModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var cogs = $(event.relatedTarget).data('cogs');
         var weight = $(event.relatedTarget).data('weight');
         var lipatan = $(event.relatedTarget).data('lip');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="cogs"]').val(cogs);
         $(event.currentTarget).find('.modal-body input[name="grammage"]').val(weight);
         $(event.currentTarget).find('.modal-body input[name="lipatan"]').val(lipatan);
     });

     //  JavaScript for Delete production warehouse item Modal
     $('#deleteProdModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
     });

     //  JavaScript for Edit GBJ warehouse item Modal
     $('#editItemModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var cat = $(event.relatedTarget).data('cat');
         var pcs = $(event.relatedTarget).data('pcs');
         var pack = $(event.relatedTarget).data('pack');
         var price = $(event.relatedTarget).data('price');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="pcsperpack"]').val(pcs);
         $(event.currentTarget).find('.modal-body input[name="packpersack"]').val(pack);
         $(event.currentTarget).find('.modal-body input[name="price"]').val(price);
         $(event.currentTarget).find('.modal-body select[name="category"]').val(cat);
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

     //  JavaScript for Sales Info Payment 
     $('#paymentModal').on('show.bs.modal', function(event) {
     //extract data from data-* attributes of modal's toggle button
        var ref_id = $(event.relatedTarget).data('po');

        // input passed data using JS to object INPUT inside modal #deleteItemPOModal
        $(event.currentTarget).find('.modal-body input[name="ref_id"]').val(ref_id);
     });

     //  JavaScript for Adjust Material WH transaction details 
     $('#adjustProdTrans').on('show.bs.modal', function(event) {
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

     //  JavaScript for Adjust GBJ details transaction
     $('#deleteProdTransaction').on('show.bs.modal', function(event) {
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

     //  JavaScript for delete PO per item transaction
     $('#deleteItemPOModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_amount"]').val(amount);
     });


     //  JavaScript for print roll input ticket
     $('#printDetails').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var batch = $(event.relatedTarget).data('batch');
         var name = $(event.relatedTarget).data('name');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="batch"]').val(batch);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="amount"]').val(amount);
     });

     //  JavaScript for delete Production Order per item transaction
     $('#deleteItemProdOrder').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_amount"]').val(amount);
     });

     //  JavaScript for delete Production Order per item transaction
     $('#cutRollItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_amount"]').val(amount);
     });
     
     //  JavaScript for delete Production Order per item transaction
     $('#convertPack').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var code = $(event.relatedTarget).data('code');
         var amount = $(event.relatedTarget).data('amount');
         var price = $(event.relatedTarget).data('price');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="code"]').val(code);
         $(event.currentTarget).find('.modal-body input[name="kg_amount"]').val(amount);
         $(event.currentTarget).find('.modal-body input[name="kg_price"]').val(price);
     });

     //  JavaScript for delete Production Order per item transaction
     $('#deleteItemGBJ').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var name = $(event.relatedTarget).data('name');
         var amount = $(event.relatedTarget).data('amount');
         var status = $(event.relatedTarget).data('status');
         var cat = $(event.relatedTarget).data('cat');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="trans_status"]').val(status);
         $(event.currentTarget).find('.modal-body input[name="item_cat"]').val(cat);
         $(event.currentTarget).find('.modal-body input[name="delete_name"]').val(name);
         $(event.currentTarget).find('.modal-body input[name="delete_amount"]').val(amount);
     });

     //  JavaScript for Delete Purchase Order transaction
     $('#returnPurchaseModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');
         var id = $(event.relatedTarget).data('id');
         var amount = $(event.relatedTarget).data('amount');
         
         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_po_id"]').val(po_id);
         $(event.currentTarget).find('.modal-body input[name="trans_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="qtyID"]').val(amount);
        });
        
     //  JavaScript for Save Return Purchase transaction
     $('#deletePOModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_po_id"]').val(po_id);
     });

     //  JavaScript for Adjust GBJ details transaction
     $('#deleteRollModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_roll_id"]').val(po_id);
     });

     //  JavaScript for Adjust GBJ details transaction
     $('#deleteGBJ').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var po_id = $(event.relatedTarget).data('po');

         // input passed data using JS to object INPUT inside modal #deleteItemPOModal
         $(event.currentTarget).find('.modal-body input[name="delete_gbj_id"]').val(po_id);
     });
     
     //  JavaScript for Delete Customer Message 
     $('#deleteMessage').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var $id = $(event.relatedTarget).data('id');

         // input passed data using JS to object INPUT inside modal #deleteMessage
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val($id);
     });

     //  JavaScript for Reply User Message
     $('#replyModal').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var $email = $(event.relatedTarget).data('email');
         var $ticket = $(event.relatedTarget).data('ticket');
         var $header = 'Hello! We have received your message and please give us some time to assign a customer service officer to handle your message. We will get to you by 1x24 business hour.'; // Find the row
         
         var $ticket2 = $ticket + '- Ticket Opened '
         
         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="email"]').val($email);
         $(event.currentTarget).find('.modal-body input[name="subject"]').val($ticket2);
         document.getElementById("message").value = $header;
     });

     //  JavaScript for Delete Individual cart item Message
     $('#deleteCartIndividualItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var custName = $(event.relatedTarget).data('cust');
         var itemName = $(event.relatedTarget).data('name');
         var amount = $(event.relatedTarget).data('amount');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_item_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="cust_name"]').val(custName);
         $(event.currentTarget).find('.modal-body input[name="delete_item_name"]').val(itemName);
         $(event.currentTarget).find('.modal-body input[name="item_amount"]').val(amount);
     });

     //  JavaScript for Delete All cart item Message
     $('#deleteCartItem').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');
         var custName = $(event.relatedTarget).data('cust');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
         $(event.currentTarget).find('.modal-body input[name="cust_name"]').val(custName);
     });

     //  JavaScript for Delete All cart item Message
     $('#deleteCartItemSO').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var id = $(event.relatedTarget).data('id');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="delete_id"]').val(id);
     });

     //  JavaScript for Invoice  Checkout
     $('#transDetail').on('show.bs.modal', function(event) {
         //extract data from data-* attributes of modal's toggle button
         var inv = $(event.relatedTarget).data('inv');

         // input passed data using JS to object INPUT inside modal #editModal
         $(event.currentTarget).find('.modal-body input[name="ref"]').val(inv);
         //  const invoiceID = $(this).data('inv');

         //  $.ajax({
         //      url: "<?= base_url('customer/history'); ?>",
         //      type: 'post',
         //      data: {
         //          invoiceID: invoiceID
         //      },
         //      success: function() {
         //          document.location.href = "<?= base_url('customer/history')  ?>";
         //      }
         //  });
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

     //javascript for select material for production order
     $('#material').on('change', function(event) {
         var unit = $(this).find(':selected').data('unit');

         document.getElementById("unit_instock").innerText = unit;
     });

     //javascript for select material for production order
     $('#materialSelect').on('change', function(event) {
         var price = $(this).find(':selected').data('price');
         var stock = $(this).find(':selected').data('stock');
         var unit = $(this).find(':selected').data('unit');

         document.getElementById("stock").value = stock;
         document.getElementById("price").value = price;
         document.getElementById("unit_instock").innerText = unit;
         document.getElementById("unit_amount").innerText = unit;
     });

     //javascript for select term for purchase order
     $('#supplier').on('change', function(event) {
         var term = $(this).find(':selected').data('term');

         document.getElementById("term").value = term;
     });

     //javascript for select roll for roll input form
     $('#rollSelect').on('change', function(event) {
         var weight = $(this).find(':selected').data('weight');
         var lipatan = $(this).find(':selected').data('lipatan');
         var code = $(this).find(':selected').data('code');

         document.getElementById("weight").value = weight;
         document.getElementById("lipatan").value = lipatan;
         document.getElementById("code").value = code;
     });

     //javascript for select gbj for gbj input form
     $('#gbjSelect').on('change', function(event) {
         var pcsperpack = $(this).find(':selected').data('pcsperpack');
         var packpersack = $(this).find(':selected').data('packpersack');
         var code = $(this).find(':selected').data('code');
         var stock = $(this).find(':selected').data('instock');

         document.getElementById("pcsperpack").value = pcsperpack;
         document.getElementById("packpersack").value = packpersack;
         document.getElementById("code").value = code;
         document.getElementById("instock").value = stock;
     });

     //javascript for select roll
     //  $('#rolltype').on('change', function(event) {
     //      var code = $(this).find(':selected').data('code');
     //      var weight = $(this).find(':selected').data('weight');
     //      var lipatan = $(this).find(':selected').data('lipatan');

     //      document.getElementById("code").value = code;
     //      document.getElementById("weight").value = weight;
     //      document.getElementById("lipatan").value = lipatan;
     //  });

     $(document).ready(function() {
         var table = $('#cogstable').DataTable({
             columnDefs: [{
                 width: "2%",
                 targets: 0,
                 width: "45%",
                 targets: 2,
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