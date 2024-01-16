<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>اضافة سند قبض</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="sanad_add.php">
          		  <div class="form-group">
                  	<label for="fatoora" class="col-sm-3 control-label">الفاتورة</label>

						<div class="col-sm-9">
							<select required class="form-control select2" name="fatoora_id" id="fatoora_id">
							<?php 
								include $_SERVER['DOCUMENT_ROOT'] . '/conn.php';
								$sql = "SELECT * FROM fatoora";
								$query = $conn->query($sql);

								while ($fatoora = $query->fetch_assoc()) {
									echo '<option value="' . $fatoora['id'] . '">' . $fatoora['id'] . '</option>';
								}
							?>
							</select>
						</div>
                	</div>

					<div class="form-group">
                  	<label for="amount" class="col-sm-3 control-label">المبلغ</label>

						<div class="col-sm-9" style="display:flex;">
							<input required type="number" name="amount" min="0" step="0.01" class="form-control">
							<span class="input-group-addon" style="width:fit-content">ريال</span>
						</div>
                	</div>

					<div class="form-group">
                  	<label for="account_id" class="col-sm-3 control-label">طريقة الدفع</label>
						<div class="col-sm-9">
							<select required name="account_id" class="form-control" id="account_id">
							<?php 
								include $_SERVER['DOCUMENT_ROOT'] . '/conn.php';
								$sql = "SELECT * FROM account";
								$query = $conn->query($sql);

								while ($account = $query->fetch_assoc()) {
									echo '<option value="' . $account['id'] . '">' . $account['name'] . '</option>';
								}
							?>
							</select>
						</div>
                	</div>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> الغاء</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> حفظ</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="employee_name"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="sanad_edit.php">
					<input type="number" hidden name="sanad_id">
					<div class="form-group">
                  	<label for="amount" class="col-sm-3 control-label">رقم الفاتورة</label>

						<div class="col-sm-9">
							<input required readonly type="number" name="fatoora_id" min="0" step="0.01" class="form-control">
						
						</div>
                	</div>

					<div class="form-group">
                  	<label for="amount" class="col-sm-3 control-label">المبلغ</label>

						<div class="col-sm-9" style="display:flex;">
							<input required type="number" name="amount" min="0" step="0.01" class="form-control">
							<span class="input-group-addon" style="width:fit-content">ريال</span>
						</div>
                	</div>

					<div class="form-group">
                  	<label for="account_id" class="col-sm-3 control-label">طريقة الدفع</label>

						<div class="col-sm-9">
							<select required name="account_id" class="form-control" id="account_id">
							<?php 
								include $_SERVER['DOCUMENT_ROOT'] . '/conn.php';
								$sql = "SELECT * FROM account";
								$query = $conn->query($sql);

								while ($account = $query->fetch_assoc()) {
									echo '<option value="' . $account['id'] . '">' . $account['name'] . '</option>';
								}
							?>
							</select>
						</div>
                	</div>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> الغاء</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> حفظ</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span id="sanad_id_title"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="sanad_delete.php">
            		<input type="hidden" class="sanad_id" name="sanad_id">
            		<input type="hidden" class="fatoora_id" name="fatoora_id">

            		<div class="text-center">
	                	<p>حذف سند القبض</p>
	                	
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


     