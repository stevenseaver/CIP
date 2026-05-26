 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center mb-2">
             <span>Licensed by Rukun Gemilang Perkasa 2024</span>
         </div>
         <div class="copyright text-center my-auto">
             <span>Telp: +627862413070 | Email: cs@plastikrukun.com</span>
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

 <!-- Built In scripts -->
 <script src="<?= base_url('asset/js/scipts.js') ?>"></script>

 <script>
    if ($(window).width() < 768) {
        $('.sidebar').addClass('toggled');
    }

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
            document.getElementById("weighted_product").style.display = "";
            document.getElementById("pcsperpack").value = 0;
            document.getElementById("packpersack").value = 0;
            document.getElementById("conversion").value = 25;
        } else if (category.value == "7") {
            document.getElementById("packing_product").style.display = "";
            document.getElementById("weighted_product").style.display = "";
            document.getElementById("conversion").value = 0;
        } else {
            document.getElementById("packing_product").style.display = "";
            document.getElementById("weighted_product").style.display = "none";
            document.getElementById("conversion").value = 0;
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
         const discID = $(this).data('discount');
         const sackID = $(this).data('sack');
         const weightID = $(this).data('weight');
         const refID = $(this).data('description');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID,
                 discID: discID,
                 sackID: sackID,
                 weightID: weightID,
                 refID: refID
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
         const discID = $(this).data('discount');
         const sackID = $(this).data('sack');
         const weightID = $(this).data('weight');
         const refID = $(this).data('description');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID,
                 discID: discID,
                 sackID: sackID,
                 weightID: weightID,
                 refID: refID
             },
             success: function() {
                 window.location.reload();  
             }
         });
     });

     //js for menu change cart discount on input on change
     $('.input-discount-so').on('change', function() {
         //const qtyID = $(this).data('qty');
         const item_name = $(this).data('item');
         const ref = $(this).data('ref');
         const id = $(this).data('id');
         const priceID = $(this).data('price');
         const discID = document.getElementById("discountAmount-" + id).value;
         const qtyID = $(this).data('amount');
         const sackID = $(this).data('sack');
         const weightID = $(this).data('weight');
         const refID = $(this).data('description');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID,
                 discID: discID,
                 sackID: sackID,
                 weightID: weightID,
                 refID: refID
             },
             success: function() {
                 window.location.reload();  
             }
         });
     });

     //js for menu change cart discount on input on change
     $('.input-sack-so').on('change', function() {
         //const qtyID = $(this).data('qty');
         const item_name = $(this).data('item');
         const ref = $(this).data('ref');
         const id = $(this).data('id');
         const qtyID = $(this).data('amount');
         const discID = $(this).data('discount');
         const priceID = $(this).data('price');
         const sackID = document.getElementById("sackEdit-" + id).value;
         const weightID = $(this).data('weight');
         const refID = $(this).data('description');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID,
                 discID: discID,
                 sackID: sackID,
                 weightID: weightID,
                 refID: refID
             },
             success: function() {
                 window.location.reload();  
             }
         });
     });

     //js for menu change cart discount on input on change
     $('.input-weight-so').on('change', function() {
         //const qtyID = $(this).data('qty');
         const item_name = $(this).data('item');
         const ref = $(this).data('ref');
         const id = $(this).data('id');
         const qtyID = $(this).data('amount');
         const discID = $(this).data('discount');
         const priceID = $(this).data('price');
         const sackID = $(this).data('sack');
         const weightID = document.getElementById("weightEdit-" + id).value;
         const refID = $(this).data('description');

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID,
                 discID: discID,
                 sackID: sackID,
                 weightID: weightID,
                 refID: refID
             },
             success: function() {
                 window.location.reload();  
             }
         });
     });
     
     //js for menu change cart discount on input on change
     $('.input-reference-so').on('change', function() {
         //const qtyID = $(this).data('qty');
         const item_name = $(this).data('item');
         const ref = $(this).data('ref');
         const id = $(this).data('id');
         const qtyID = $(this).data('amount');
         const discID = $(this).data('discount');
         const priceID = $(this).data('price');
         const sackID = $(this).data('sack');
         const weightID = $(this).data('weight');
         const refID = document.getElementById("referenceEdit-" + id).value;

         $.ajax({
             url: "<?= base_url('sales/update_so'); ?>",
             type: 'post',
             data: {
                 ref: ref,
                 qtyID: qtyID,
                 item_name: item_name,
                 id: id,
                 priceID: priceID,
                 discID: discID,
                 sackID: sackID,
                 weightID: weightID,
                 refID: refID
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

     //js for reference description change on purchase order form on input change
     $('.edit-po').on('change', function() {
         const id = $(this).data('id');
         const refID = document.getElementById("editPOrder-" + id).value;

         $.ajax({
             url: "<?= base_url('purchasing/update_desc'); ?>",
             type: 'post',
             data: {
                 selector : 1,
                 id: id,
                 refID: refID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });
     
     //js for reference description change on purchase order form on input change
     $('.edit-pur-desc').on('change', function() {
         const id = $(this).data('id');
         const refID = document.getElementById("editDESCrder-" + id).value;

         $.ajax({
             url: "<?= base_url('purchasing/update_desc'); ?>",
             type: 'post',
             data: {
                 selector : 3,
                 id: id,
                 refID: refID
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });
    
     //js for price change on purchase order form on input change
     $('.edit-POprice').on('change', function() {
         const id = $(this).data('id');
         const priceID = document.getElementById("editPriceOrder-" + id).value;

         $.ajax({
             url: "<?= base_url('purchasing/update_desc'); ?>",
             type: 'post',
             data: {
                 selector : 2,
                 id: id,
                 priceID : priceID 
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

     //js for amount change on production order product name
     $('.change_prod_name').on('change', function() {
         const id = $(this).data('id');

         const newName = document.getElementById("change_product_name").value;

         $.ajax({
             url: "<?= base_url('production/update_product_name'); ?>",
             type: 'post',
             data: {
                 id : id,
                 newName: newName
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order product name
     $('.change_ref_purchasing').on('change', function() {
         const id = $(this).data('id');

         const newName = document.getElementById("change_ref_item").value;

         $.ajax({
             url: "<?= base_url('purchasing/update_purchasing_ref'); ?>",
             type: 'post',
             data: {
                 id : id,
                 newName: newName
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order product name
     $('.change_ref_sales').on('change', function() {
         const id = $(this).data('id');

         const newName = document.getElementById("change_ref_sales").value;

         $.ajax({
             url: "<?= base_url('sales/update_sales_ref'); ?>",
             type: 'post',
             data: {
                 id : id,
                 newName: newName
             },
             success: function() {
                $(document).ajaxStop(function(){
                    window.location.reload();   
                });
             }
         });
     });

     //js for amount change on production order quantity per item input on change
     $('.material-qty').on('change', function() {
         const id = $(this).data('id');
         const prodID = $(this).data('prodid');
         
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
         const prodID = $(this).data('prodid');

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
     
     //js for amount change on material mixing usage per item input on change (mixed materials aggregate)
     $('.usage-qty').on('change', function() {
         const id = $(this).data('id');
         const prodID = $(this).data('prodid');

         const qtyID = document.getElementById("usageAmount-" + id).value;

         $.ajax({
             url: "<?= base_url('production/update_usage'); ?>",
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
         const prodID = $(this).data('prodid');

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

 </script>
 </body>

 </html>