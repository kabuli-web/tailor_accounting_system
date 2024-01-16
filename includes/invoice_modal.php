<!-- Add -->
<div class="modal fade bd-example-modal-xl" id="addNewInvoice">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Create Invoice</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="invoice-add-form" method="POST" action="invoice_add.php">
                    <div class="form-group">
                        <label for="c_name" class="col-sm-3 control-label">Customer Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="c_name" name="c_name" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c_phone" class="col-sm-3 control-label">Customer Phone</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" max="999999999999" class="form-control price-input" id="c_phone" name="c_phone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c_address" class="col-sm-3 control-label">Customer Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="c_address" name="c_address" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c_vat" class="col-sm-3 control-label">Customer Vat</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" max="999999999999999"  step="1" class="form-control price-input" id="c_vat" name="c_vat" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="po_number" class="col-sm-3 control-label">PO Number</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" step="1" class="form-control price-input" id="po_number" name="po_number" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="datepicker_add" class="col-sm-3 control-label">Due Date</label>
                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_add" name="due_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group invoice-modal-products-form-group">
                        <div class="col-sm-4">
                          <label class="control-label">Product</label>
                            <select name="product" class="form-control select2">
                                <?php
                                $sql = "SELECT * FROM products";
                                $query = $conn->query($sql);
                                $selected = true;
                                while ($row = $query->fetch_assoc()) {
                                    ?>
                                    <option class="product" <?php echo $selected ? "selected" : null; ?> price="<?php echo $row['price']; ?>" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                    $selected = false;
                                }
                                ?>
                            </select>
                      </div>
                        
                        <div class="col-sm-2">
                          <label class="control-label">Quantity</label>
                          <input type="number" value="1" class="form-control" min="1" name="product-quantity">
                        </div>
                        
                        <div class="col-sm-2">
                          <label class="control-label">Price</label>
                          <input class="form-control price-input" type="number"  min="0" step=".01" name="product-price">
                        </div>
                        <div class="col-sm-2">
                          <label class="control-label">Total</label>
                          <input disabled class="form-control" value="" type="number" min="0" step="0.01" name="product-total">
                        </div>
                        <div class="col-sm-2">
                          <div class="d-flex align-items-center">
                              <a id="add-invoice-item" class="btn btn-default form-control"> Add </a>
                          </div>
                        </div>
                    </div>
                    <div class="form-group p-4 panel">
                        
                      <div class="panel-body ">
                        <h4 class="text-center mt-2">Items</h4>
                        <table class="table " id="invoice-items">
                          <thead class="row">
                          <th class="col-md-6"><div >Description</th>
                          <th class="col-md-1"><div >Quantity</th>
                          <th class="col-md-2"><div >Price(SAR)</th>
                          <th class="col-md-2"><div >Total(SAR)</th>
                          <th class="col-md-1"><div >Options</th>
                          <tbody>
                          </thead>
                          <tbody id="invoice-items-body">
                              
                          </tbody>
                        </table>
                      </div>
                      
                    </div>
                    <div class="form-group panel" >
                     
                        <div class="panel-body" style="border:1px solid #00000047" >
                        <div class="col-sm-6" style="padding: 20px; border-right:1px solid #00000047">
                          <div class="row ">
                            <div class="col-xs-4">
                              <h4> <strong>Sub-Total</strong></h4>
                            </div>
                            <div class="col-xs-8">
                            <h4 id="final-invoice-total"> <strong>SAR</strong> 0</h4>
                            </div>
                          </div>
                          <div class="row ">
                            <div class="col-xs-4">
                            <h4><strong>Vat</strong></h4>
                            </div>
                            <div class="col-xs-8">
                            <h4 id="final-invoice-vat"><strong>SAR</strong> 0</h4>
                            </div>
                          </div>
                          <div class="row ">
                            <div class="col-xs-4">
                            <h4><strong>Total with Vat</strong></h4>
                            </div>
                            <div class="col-xs-8">
                            <h4 id="final-invoice-total-with-vat"> <strong>SAR</strong> 0</h4>
                            </div>
                          </div>
                          
                          <div class="row ">
                            <div class="col-xs-4">
                            <h4><strong>Due Amount</strong></h4>
                            </div>
                            <div class="col-xs-8">
                            <h4 id="final-invoice-due-amount"> <strong>SAR</strong> 0</h4>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6" style="padding: 20px;">
                          <div class="form-group">
                          <label for="reciept-payment-amount" class="col-sm-6 control-label">Amount Paid </label>
                          <div class="col-sm-6">
                              <input type="number" min="0" step="0.01" class="form-control price-input" id="reciept-payment-amount" name="payment-amount" >
                          </div>
                          </div>
                          <div class="form-group">
                          <label for="reciept-payment-type" class="col-sm-6 control-label">Payment Type  </label>
                          <div class="col-sm-6">
                          <select name="payment-type" id="reciept-payment-type" class="form-control">
                            <option value="credit_card">
                                Credit Card
                            </option>
                            <option value="cash">
                                Cash
                            </option>
                            <option value="transfer">
                              Transfer
                            </option>
                          </select>
                          </div>
                          </div>
                        </div>
                        </div>
                        
                    </div>
                    <input type="hidden" name="add" value="1">
                    <div class="form-group">
                      <label for="description" style="margin-left: 10px; text-align:center; width:100%" class="control-label">Description</label>
                      <div style="padding:50px;">
                        <textarea id="myTextarea" name="description"></textarea>
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Close
                </button>
                <button type="submit" onclick="submitForm()" id="create-invoice-button" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Edit -->
<div class="modal fade" id="editInvoice">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Update inovice</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="invoice-edit-form" method="POST" action="invoice_edit.php">
            		<input type="hidden" id="edit-invoice-id" name="invoice_id">
                <input type="hidden" name="edit" value="1">
                <div class="form-group">
                        <label for="edit_c_name" class="col-sm-3 control-label">Customer Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_c_name" name="edit_c_name" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_c_phone" class="col-sm-3 control-label">Customer Phone</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" max="999999999999" class="form-control price-input" id="edit_c_phone" name="edit_c_phone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_c_address" class="col-sm-3 control-label">Customer Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_c_address" name="edit_c_address" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_c_vat" class="col-sm-3 control-label">Customer Vat</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" max="999999999999999"  step="1" class="form-control price-input" id="edit_c_vat" name="edit_c_vat" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_po_number" class="col-sm-3 control-label">PO Number</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" step="1" class="form-control price-input" id="edit_po_number" name="edit_po_number" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">Due Date</label>
                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_edit" name="edi_due_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group invoice-modal-products-form-group">
                        <div class="col-sm-4">
                          <label class="control-label">Product</label>
                            <select name="edit-product" class="form-control select2">
                                <?php
                                $sql = "SELECT * FROM products";
                                $query = $conn->query($sql);
                                $selected = true;
                                while ($row = $query->fetch_assoc()) {
                                    ?>
                                    <option class="edit-product" <?php echo $selected ? "selected" : null; ?> price="<?php echo $row['price']; ?>" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                    $selected = false;
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-2">
                          <label class="control-label">Quantity</label>
                          <input type="number" value="1" class="form-control" min="1" name="edit-product-quantity">
                        </div>
                        
                        <div class="col-sm-2">
                          <label class="control-label">Price</label>
                          <input class="form-control price-input" type="number"  min="0" step=".01" name="edit-product-price">
                        </div>
                        <div class="col-sm-2">
                          <label class="control-label">Total</label>
                          <input disabled class="form-control" value="" type="number" min="0" step="0.01" name="edit-product-total">
                        </div>
                        <div class="col-sm-2">
                          <div class="d-flex align-items-center">
                              <a id="add-edit-invoice-item" class="btn btn-default form-control"> Add </a>
                          </div>
                        </div>
                    </div>
                    <div class="form-group p-4 panel">
                        
                      <div class="panel-body ">
                        <h4 class="text-center mt-2">Items</h4>
                        <table class="table " id="edit-invoice-items">
                          <thead class="row">
                          <th class="col-md-6"><div >Description</th>
                          <th class="col-md-1"><div >Quantity</th>
                          <th class="col-md-2"><div >Price(SAR)</th>
                          <th class="col-md-2"><div >Total(SAR)</th>
                          <th class="col-md-1"><div >Options</th>
                          <tbody>
                          </thead>
                          <tbody id="edit-invoice-items-body">
                              
                          </tbody>
                        </table>
                      </div>
                      
                    </div>
                    <div class="form-group">
                            <div class="col-sm-6" style="padding: 20px;">
                              <div class="row ">
                                <div class="col-xs-4">
                                  <h4> <strong>Sub-Total</strong></h4>
                                </div>
                                <div class="col-xs-8">
                                <h4 id="edit-final-invoice-total"> <strong>SAR</strong> 0</h4>
                                </div>
                              </div>
                              <div class="row ">
                                <div class="col-xs-4">
                                <h4><strong>Vat</strong></h4>
                                </div>
                                <div class="col-xs-8">
                                <h4 id="edit-final-invoice-vat"><strong>SAR</strong> 0</h4>
                                </div>
                              </div>
                              <div class="row ">
                                <div class="col-xs-4">
                                <h4><strong>Total with Vat</strong></h4>
                                </div>
                                <div class="col-xs-8">
                                <h4 id="edit-final-invoice-total-with-vat"> <strong>SAR</strong> 0</h4>
                                </div>
                              </div>
                              <div class="row ">
                                <div class="col-xs-4">
                                <h4><strong>Due Amount</strong></h4>
                                </div>
                                <div class="col-xs-8">
                                <h4 id="edit-final-invoice-due-amount"> <strong>SAR</strong> 0</h4>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6" style="padding: 20px;">
                              <div class="form-group">
                              <label for="reciept-payment-amount" class="col-sm-6 control-label">Total Amount Paid </label>
                                <div class="col-sm-6">
                                    <input type="number" readonly min="0" step="0.01" class="form-control price-input" id="edit-reciept-payment-amount" name="payment-amount" >
                                </div>
                              </div>
                        </div>
                    </div>
                    <input type="hidden" name="add" value="1">
                    <div class="form-group">
                      <label for="description" style="margin-left: 10px; text-align:center; width:100%" class="control-label">Description</label>
                      <div style="padding:50px;">
                        
                        <textarea id="edit_description" style="width:100%"name="edit_description"></textarea>
                      </div>
                    </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" id="edit-invoice-submit-button" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteInvoice">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Deleting...</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="invoice_delete.php">
            		<input type="hidden" class="delete-invoice-id" name="id">
            		<div class="text-center">
	                	<p>DELETE Invoice?</p>
	                	<h2 id="del_deduction" class="bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


     