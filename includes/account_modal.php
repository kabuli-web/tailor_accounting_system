<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>اضافة حساب جديد</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="account_add.php">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">اسم الحساب</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="current_balance" class="col-sm-3 control-label">المبلغ الموجود في الحساب</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" step="0.01" class="form-control" id="current_balance" name="current_balance" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> الغاء
                </button>
                <button type="submit" class="btn btn-primary btn-flat" name="add">
                    <i class="fa fa-save"></i> حفظ
                </button>
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
            	<h4 class="modal-title"><b>تحديث الحساب</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="account_edit.php">
					<input type="number" hidden name="id">
				<div class="form-group">
                        <label for="name" class="col-sm-3 control-label">اسم الحساب</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="current_balance" class="col-sm-3 control-label">المبلغ الموجود في الحساب</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" readonly step="0.01" class="form-control" id="current_balance" name="current_balance" required>
                        </div>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> الغاء
                </button>
                <button type="submit" class="btn btn-primary btn-flat" name="edit">
                    <i class="fa fa-save"></i> حفظ
                </button>
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
            	<h4 class="modal-title"><b>جاري الحذف ...</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="account_delete.php">
            		<input type="hidden" id="id" name="id">
            		<div class="text-center">
	                	<p>حذف الحساب</p>
	                	<h2 id="del_account_name" class="bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> الغاء</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> حذف</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


     