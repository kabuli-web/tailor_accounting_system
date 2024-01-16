<!-- Add -->
<!-- <div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Reciept</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="reciept_add.php">
          		  <div class="form-group">
                  	<label for="description" class="col-sm-3 control-label">Description</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="description" name="description" required>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="amount" class="col-sm-3 control-label">Amount</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="amount" name="amount" required>
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div> -->


<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Reciept</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="reciept_add.php">
					<div class="form-group">
						<label for="invoice" class="col-sm-3 control-label">Invoice</label>
						<div class="col-sm-9">
						<select required id="invoice-id" name="invoice" class="form-control">
									<?php
									$sql = "SELECT * FROM invoices WHERE division_id = '".$user['division_id']."' AND closed=0";
									$query = $conn->query($sql);
									$selected = false;
									while ($row = $query->fetch_assoc()) {
										?>
										<option class="invoice" <?php echo !$selected? "selected":""; ?>  value="<?php echo $row['id']; ?>"><?php echo $row['customer_name'] . "  |  ". $row['id'] ; ?></option>
										<?php
										$selected = true;
									}
									?>
							</select>
						</div>
                	</div>
					<div class="form-group">
						<label for="invoice" class="col-sm-3 control-label">Due amount</label>
						<div class="col-sm-9">
						<input type="number" id="due-amount" step="0.01" value="0" disabled class="form-control price-input" >
						</div>
                	</div>
                <div class="form-group">
                    <label for="amount" class="col-sm-3 control-label">Amount to be Paid</label>
                    <div class="col-sm-9">
                      <input type="text" min="0" step="0.01" class="form-control price-input" id="amount" name="amount" required>
                    </div>
                </div>

				<div class="form-group">
                  	<label for="payment_method" class="col-sm-3 control-label">Payment Method</label>
                  	<div class="col-sm-9">
					  <select required name="payment_method" class="form-control">
                                <option value="credit_card">Credit Card</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


     