<!-- Add -->
<div class="modal fade" id="addNewVac">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Vacation Deductions</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="vacation_deduction_add.php">
          		  <div class="form-group">
                  	<label for="description" class="col-sm-3 control-label">Description</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="description" name="description" required>
                  	</div>
                </div>
				
                <div class="form-group">
                    <label for="days" class="col-sm-3 control-label">Days to Deduct</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="days" name="days" required>
                    </div>
                </div>
				<div class="form-group">
                    <label for="datepicker_add" class="col-sm-3 control-label">Starting From Date</label>

                    <div class="col-sm-9"> 
                      <div class="date">
                        <input type="text" class="form-control" id="datepicker_add" name="date" required>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="days" class="col-sm-3 control-label">Employee</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="employee" name="employee" required>
                      <?php
                    $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      ?>
                      <option value="<?php echo $row['empid']; ?>" > <?php echo $row['firstname'].' '.$row['lastname']; ?></option>
                      <?php
                    }
                  ?>
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

<!-- Edit -->
<div class="modal fade" id="editVac">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Update Vacation Deduction</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="vacation_deduction_edit.php">
            		<input type="hidden" class="decid" name="id">
                <div class="form-group">
                    <label for="edit_description" class="col-sm-3 control-label">Description</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_description" name="description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_days" class="col-sm-3 control-label">Days</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_days" name="days">
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteVac">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Deleting...</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="vacation_deduction_delete.php">
            		<input type="hidden" class="decid" name="id">
            		<div class="text-center">
	                	<p>DELETE DEDUCTION</p>
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


     