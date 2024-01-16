<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b> اضافة فاتورة</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="fatoora_add.php">

				<div class="col">
					<h2 class="modal-input-section-header" id="sizes-input-section">تفاصيل العميل</h2>
					<div class="modal-input-section-container customer">
						<div class="modal-input-container">
							<label for="name" >
								الاسم </br> Name
							</label>
							<div>
								<input required type="text" class="form-control" value="test" name="name">
							</div>
						</div>

						<div class="modal-input-container">
							<label for="phone" >
								رقم جوال </br> Phone Number
							</label>
							<div>
							<span class="input-group-addon">+966</span>
							<input required min="500000000" max="599999999" value="599999998" type="number" class="form-control" name="phone_number">								
							</div>
						</div>
						
					</div>


				</div>

                <div class="col">
					<h2 class="modal-input-section-header" id="sizes-input-section">المقاسات</h2>
					<div class="modal-input-section-container">
						<div class="modal-input-container">
							<label for="length" >
								الطول </br> Length
							</label>
							<div>
								<input required min="1" step="0.01" type="number" value="1" class="form-control" name="length">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						
						<div class="modal-input-container">
							<label for="shoulder" >
								الكتف </br> Shoulder
							</label>
							<div>
								<input required type="number" class="form-control" value="1" name="shoulder">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="sleeve" >
								حقول كم </br> Sleeve
							</label>
							<div>
								<input required type="number" class="form-control" value="1" name="sleeve">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="chest" >
								وسع صدر </br> Chest
							</label>
							<div>
								<input required type="number" class="form-control" value="1" name="chest">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="waist" >
								وسع الوسط </br> Waist/Hip
							</label>
							<div>
								<input required type="number" class="form-control" value="1" name="waist">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="neck" >
								الرقبة </br> neck
							</label>
							<div>
								<input required type="number" class="form-control" value="1" name="neck">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="hand_loosing" >
								وسع اليد </br> Hand Loosing
							</label>
							<div>
								<div>
									<span class="input-group-addon">L</span>
									<input  type="number"  class="form-control" value="1" place_holder="يسار" name="hand_loosing_left">
									<span class="input-group-addon">cm</span>

								</div>
								<div>
									<span class="input-group-addon">R</span>
									<input type="number"  class="form-control" value="1" place_holder="يمين" name="hand_loosing_right">
									<span class="input-group-addon">cm</span>

								</div>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="expand_down" >
								وسع اسفل </br> expand down
							</label>
							<div>
								<input required type="number" class="form-control" value="1" name="expand_down">
								<span class="input-group-addon">cm</span>
							</div>

						</div>
					</div>
				</div>
				 
				<div class="col">
					<h2 class="modal-input-section-header" >التصميم </h2>
					<div class="modal-input-section-container" id="design-input-section">
						<div class="modal-input-container">
							<label for="type" >
							نوع الخياطة</br>  type
							</label>
							<div>
								<input  type="checkbox" name="dd" value="1">
								<label class="radio_label" >DD - دبل خياطة</label>
							</div>
							<div>
								<input required type="radio" checked name="thob_type" value="saudi">
								<label class="radio_label" >سعودي</label>
							</div>
							<div>
								<input  type="radio" name="thob_type" value="qatari">
								<label class="radio_label" >قطري</label>
							</div>
							<div>
								<input  type="radio" name="thob_type" value="kuwaiti">
								<label class="radio_label" >كويتي</label>
							</div>
							<div>
								<input  type="number" name="tatriz">
								<label class="radio_label"  for="type" >
								التطريز-  tatriz No
								</label>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="type" >
							نوع الازار</br>  buttons
							</label>
							
							<div>
							<input type="radio" checked required name="buttons_type" value="plastick">
							<label class="radio_label" for="age1">تك تك بلاستيك</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="iron_sadaf">
							<label class="radio_label"  for="age1">تك تك مخفي حديد صدف</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="killer_iron">
							<label class="radio_label"  for="age1">كف كلر حديد</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="iron">
							<label class="radio_label"  for="age1">تك تك حديد</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="tarkebea">
							<label class="radio_label"  for="age1">تركيبة</label><br>
							</div>
							
							
						</div>
						<div class="modal-input-container" >
							<label for="addons" >
							اضافات</br>  addons
							</label>
							<div>
								<input  type="checkbox" name="addons[]" value="pen_pocket">
								<label class="radio_label" >جيب قلم</label>
							</div>
							<div>
								<input  type="checkbox" name="addons[]" value="mobile_pocket">
								<label class="radio_label" >جيب جوال</label>
							</div>
						</div>
						<div class="modal-input-container radio-with-images" id="side_pocket_input_container" >
							<label for="middle_design" >
							التمصيم الوسطي</br>  middle design
							</label>
							<div>
								<div>
									<input checked type="radio" required name="middle_design" value="middle_long_v">
									<img src="./images/middle_long_v.png" alt="middle_long_v">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_square">
									<img src="./images/middle_square.png" alt="middle_square">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_square_3_buttons_stripe">
									<img src="./images/middle_square_3_buttons_stripe.png" alt="middle_square_3_buttons_stripe">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_v_3_buttons">
									<img src="./images/middle_v_3_buttons.png" alt="middle_v_3_buttons">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_zip">
									<img src="./images/middle_zip.png" alt="middle_zip">
								</div>
							</div>
						</div>
						<div class="modal-input-container radio-with-images" id="side_pocket_input_container" >
							<label for="side_pockets" >
							تصميم الجيوب الجانبية</br>  side pockets
							</label>
							<div>
								<div>
									<input checked type="radio" required name="side_pocket_design" value="side_pocket_square">
									<img src="./images/side_pocket_square.png" alt="side_pocket_square">
								</div>
								<div>
									<input  type="radio"  name="side_pocket_design" value="side_pocket_v">
									<img src="./images/side_pocket_v.png" alt="side_pocket_v">
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
                
				<div class="col">
					<div class="modal-input-section-container" id="design-input-section">
						
						<div class="modal-input-container radio-with-images wide" id="pocket_input_container" >
							<label for="pockets" >
							تصميم الجيوب</br>  Pocket Design
							</label>
							<div>
								<div>
									<input checked type="radio" required name="pocket_design" value="pocket_middle_v">
									<img src="./images/pocket_middle_v.png" alt="pocket_middle_v">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_side_curve">
									<img src="./images/pocket_side_curve.png" alt="pocket_side_curve">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_stripes">
									<img src="./images/pocket_stripes.png" alt="pocket_stripes">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_stripes_square">
									<img src="./images/pocket_stripes_square.png" alt="pocket_stripes_square">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket">
									<img src="./images/pocket.png" alt="pocket">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_left_v">
									<img src="./images/pocket_left_v.png" alt="pocket_left_v">
								</div>
							</div>
						</div>
						
						<div class="modal-input-container radio-with-images wide" id="sleeve_input_container" >
							<label for="cuffs" >
							تصميم كبك</br>  Sleeve Design
							</label>
							<div>
								<div>
									<input checked type="radio" required name="sleeve_design" value="cuffs_corner_curve_2_stripe">
									<img src="./images/cuffs_corner_curve_2_stripe.png" alt="cuffs_corner_curve_2_stripe">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_corner_cut_2_stripe">
									<img src="./images/cuffs_corner_cut_2_stripe.png" alt="cuffs_corner_cut_2_stripe">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_square">
									<img src="./images/cuffs_square.png" alt="cuffs_square">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_square_button_stripe">
									<img src="./images/cuffs_square_button_stripe.png" alt="cuffs_square_button_stripe">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_square_button_stripe_square">
									<img src="./images/cuffs_square_button_stripe_square.png" alt="cuffs_square_button_stripe_square">
								</div>
								
							</div>
						</div>
						

					</div>
				</div>

				<div class="col">
					<div class="modal-input-section-container" id="design-input-section">
						
						
						
						<div class="modal-input-container radio-with-images wide" id="neck_input_container" >
							<label for="addons" >
							تصميم الرقبة</br>  Neck Design
							</label>
							<div>
								<div>
									<input checked required type="radio" name="neck_design" value="neck_1_button">
									<img src="./images/neck_1_button.png" alt="neck_1_button">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_2_buttons">
									<img src="./images/neck_2_buttons.png" alt="neck_2_buttons">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_chinese">
									<img src="./images/neck_chinese.png" alt="neck_chinese">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_curve_long">
									<img src="./images/neck_curve_long.png" alt="neck_curve_long">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_curve_short">
									<img src="./images/neck_curve_short.png" alt="neck_curve_short">
								</div>
								
								<div>
									<input  type="radio" name="neck_design" value="neck_french_long">
									<img src="./images/neck_french_long.png" alt="neck_french_long">
								</div>

								<div>
									<input  type="radio" name="neck_design" value="neck_french_short">
									<img src="./images/neck_french_short.png" alt="neck_french_short">
								</div>

							</div>
							<div>
								<input checked type="number" name="neck_design_size">
								<label class="radio_label"  for="type" >
								مقاس تصميم الرقبة	
								</label>
							</div>
						</div>
						

					</div>
				</div>
				<div class="col">
					<div class="modal-input-section-container" >
						
						<div class="modal-input-container" style="width:100%;">
							<label for="addons" >
							ملاحظة</br>  Note
							</label>
							<div>
								<textarea style="width:100%;" name="note" id="" cols="30" rows="10">

								</textarea>
							</div>
						</div>
						

					</div>
				</div>
				<div class="col">
					<h2 class="modal-input-section-header" id="sizes-input-section">المدفوعات</h2>
					<div class="modal-input-section-container customer">
						
						<div class="modal-input-container">
							<label for="total" >
								الاجمالي </br> Total
							</label>
							
							<div>
								<input required min="1" max="10000" type="number" value="10" class="form-control" id="total" name="total">								
							<span class="input-group-addon">ريال</span>	
							</div>
						</div>

						<div class="modal-input-container">
							<label for="total_paid" >
								المبلغ المدفوع </br> Total Paid
							</label>
							<div>
								<input required min="1" max="10000" type="number" value="7" class="form-control" id="total_paid" name="total_paid">								
							<span class="input-group-addon">ريال</span>	
							</div>
						</div>
						<div class="form-group">
                  	<label for="account_id" class="col-sm-3 control-label">طريقة الدفع</label>

						<div class="col-sm-12">
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
					<h2 class="modal-input-section-header" id="total_Left"></h2>

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
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span id="edit_modal_title">تعديل الفاتورة رقم:</span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="fatoora_edit.php">

				<input type="hidden" name="fatoora_id" >
				<div class="col">
					<h2 class="modal-input-section-header" id="sizes-input-section">تفاصيل العميل</h2>
					<div class="modal-input-section-container customer">
						<div class="modal-input-container">
							<label for="name" >
								الاسم </br> Name
							</label>
							<div>
								<input required readonly type="text" class="form-control" name="name">
							</div>
						</div>

						<div class="modal-input-container">
							<label for="phone" >
								رقم جوال </br> Phone Number
							</label>
							<div>
							<span class="input-group-addon">+966</span>
							<input readonly required min="500000000" max="599999999" type="number" class="form-control" name="phone_number">								
							</div>
						</div>
						<div class="modal-input-container">
							<label for="phone" >
								لطلب جاهز؟
							</label>
							<div>
							<input type="checkbox" name="ready" value="1">							
							</div>
						</div>
					</div>


				</div>

                <div class="col">
					<h2 class="modal-input-section-header" id="sizes-input-section">المقاسات</h2>
					<div class="modal-input-section-container">
						<div class="modal-input-container">
							<label for="length" >
								الطول </br> Length
							</label>
							<div>
								<input required min="1" step="0.01" type="number" class="form-control" name="length">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						
						<div class="modal-input-container">
							<label for="shoulder" >
								الكتف </br> Shoulder
							</label>
							<div>
								<input required type="number" class="form-control" name="shoulder">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="sleeve" >
								حقول كم </br> Sleeve
							</label>
							<div>
								<input required type="number" class="form-control" name="sleeve">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="chest" >
								وسع صدر </br> Chest
							</label>
							<div>
								<input required type="number" class="form-control" name="chest">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="waist" >
								وسع الوسط </br> Waist/Hip
							</label>
							<div>
								<input required type="number" class="form-control" name="waist">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="neck" >
								الرقبة </br> neck
							</label>
							<div>
								<input required type="number" class="form-control" name="neck">
								<span class="input-group-addon">cm</span>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="hand_loosing" >
								وسع اليد </br> Hand Loosing
							</label>
							<div>
								<div>
									<span class="input-group-addon">L</span>
									<input  type="number"  class="form-control" place_holder="يسار" name="hand_loosing_left">
									<span class="input-group-addon">cm</span>

								</div>
								<div>
									<span class="input-group-addon">R</span>
									<input type="number"  class="form-control" place_holder="يمين" name="hand_loosing_right">
									<span class="input-group-addon">cm</span>

								</div>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="expand_down" >
								وسع اسفل </br> expand down
							</label>
							<div>
								<input required type="number" class="form-control" name="expand_down">
								<span class="input-group-addon">cm</span>
							</div>

						</div>
					</div>
				</div>
				 
				<div class="col">
					<h2 class="modal-input-section-header" >التصميم </h2>
					<div class="modal-input-section-container" id="design-input-section">
						<div class="modal-input-container">
							<label for="type" >
							نوع الخياطة</br>  type
							</label>
							<div>
								<input  type="checkbox" name="dd" value="1">
								<label class="radio_label" >DD - دبل خياطة</label>
							</div>
							<div>
								<input  type="radio" name="thob_type" value="saudi">
								<label class="radio_label" >سعودي</label>
							</div>
							<div>
								<input  type="radio" name="thob_type" value="qatari">
								<label class="radio_label" >قطري</label>
							</div>
							<div>
								<input  type="radio" name="thob_type" value="kuwaiti">
								<label class="radio_label" >كويتي</label>
							</div>
							<div>
								<input  type="number" name="tatriz">
								<label class="radio_label"  for="type" >
								التطريز-  tatriz No
								</label>
							</div>
						</div>
						<div class="modal-input-container">
							<label for="type" >
							نوع الازار</br>  buttons
							</label>
							
							<div>
							<input type="radio" required name="buttons_type" value="plastick">
							<label class="radio_label" for="age1">تك تك بلاستيك</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="iron_sadaf">
							<label class="radio_label"  for="age1">تك تك مخفي حديد صدف</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="killer_iron">
							<label class="radio_label"  for="age1">كف كلر حديد</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="iron">
							<label class="radio_label"  for="age1">تك تك حديد</label><br>
							</div>
							<div>
							<input type="radio" name="buttons_type" value="tarkebea">
							<label class="radio_label"  for="age1">تركيبة</label><br>
							</div>
							
							
						</div>
						<div class="modal-input-container" >
							<label for="addons" >
							اضافات</br>  addons
							</label>
							<div>
								<input  type="checkbox" name="addons[]" value="pen_pocket">
								<label class="radio_label" >جيب قلم</label>
							</div>
							<div>
								<input  type="checkbox" name="addons[]" value="mobile_pocket">
								<label class="radio_label" >جيب جوال</label>
							</div>
						</div>
						<div class="modal-input-container radio-with-images" id="side_pocket_input_container" >
							<label for="addons" >
							التمصيم الوسطي</br>  middle design
							</label>
							<div>
								<div>
									<input  type="radio" required name="middle_design" value="middle_long_v">
									<img src="./images/middle_long_v.png" alt="middle_long_v">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_square">
									<img src="./images/middle_square.png" alt="middle_square">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_square_3_buttons_stripe">
									<img src="./images/middle_square_3_buttons_stripe.png" alt="middle_square_3_buttons_stripe">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_v_3_buttons">
									<img src="./images/middle_v_3_buttons.png" alt="middle_v_3_buttons">
								</div>
								<div>
									<input  type="radio" name="middle_design" value="middle_zip">
									<img src="./images/middle_zip.png" alt="middle_zip">
								</div>
							</div>
						</div>
						<div class="modal-input-container radio-with-images" id="side_pocket_input_container" >
							<label for="addons" >
							تصميم الجيوب الجانبية</br>  side pockets
							</label>
							<div>
								<div>
									<input  type="radio" required name="side_pocket_design" value="side_pocket_square">
									<img src="./images/side_pocket_square.png" alt="side_pocket_square">
								</div>
								<div>
									<input  type="radio"  name="side_pocket_design" value="side_pocket_v">
									<img src="./images/side_pocket_v.png" alt="side_pocket_v">
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
                
				<div class="col">
					<div class="modal-input-section-container" id="design-input-section">
						
						<div class="modal-input-container radio-with-images wide" id="pocket_input_container" >
							<label for="addons" >
							تصميم الجيوب</br>  Pocket Design
							</label>
							<div>
								<div>
									<input  type="radio" required name="pocket_design" value="pocket_middle_v">
									<img src="./images/pocket_middle_v.png" alt="pocket_middle_v">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_side_curve">
									<img src="./images/pocket_side_curve.png" alt="pocket_side_curve">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_stripes">
									<img src="./images/pocket_stripes.png" alt="pocket_stripes">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_stripes_square">
									<img src="./images/pocket_stripes_square.png" alt="pocket_stripes_square">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket">
									<img src="./images/pocket.png" alt="pocket">
								</div>
								<div>
									<input  type="radio" name="pocket_design" value="pocket_left_v">
									<img src="./images/pocket_left_v.png" alt="pocket_left_v">
								</div>
							</div>
						</div>
						
						<div class="modal-input-container radio-with-images wide" id="sleeve_input_container" >
							<label for="addons" >
							تصميم كبك</br>  Sleeve Design
							</label>
							<div>
								<div>
									<input  type="radio" required name="sleeve_design" value="cuffs_corner_curve_2_stripe">
									<img src="./images/cuffs_corner_curve_2_stripe.png" alt="cuffs_corner_curve_2_stripe">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_corner_cut_2_stripe">
									<img src="./images/cuffs_corner_cut_2_stripe.png" alt="cuffs_corner_cut_2_stripe">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_square">
									<img src="./images/cuffs_square.png" alt="cuffs_square">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_square_button_stripe">
									<img src="./images/cuffs_square_button_stripe.png" alt="cuffs_square_button_stripe">
								</div>
								<div>
									<input  type="radio" name="sleeve_design" value="cuffs_square_button_stripe_square">
									<img src="./images/cuffs_square_button_stripe_square.png" alt="cuffs_square_button_stripe_square">
								</div>
								
							</div>
						</div>
						

					</div>
				</div>

				<div class="col">
					<div class="modal-input-section-container" id="design-input-section">
						
						
						
						<div class="modal-input-container radio-with-images wide" id="neck_input_container" >
							<label for="addons" >
							تصميم الرقبة</br>  Neck Design
							</label>
							<div>
								<div>
									<input required type="radio" name="neck_design" value="neck_1_button">
									<img src="./images/neck_1_button.png" alt="neck_1_button">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_2_buttons">
									<img src="./images/neck_2_buttons.png" alt="neck_2_buttons">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_chinese">
									<img src="./images/neck_chinese.png" alt="neck_chinese">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_curve_long">
									<img src="./images/neck_curve_long.png" alt="neck_curve_long">
								</div>
								<div>
									<input  type="radio" name="neck_design" value="neck_curve_short">
									<img src="./images/neck_curve_short.png" alt="neck_curve_short">
								</div>
								
								<div>
									<input  type="radio" name="neck_design" value="neck_french_long">
									<img src="./images/neck_french_long.png" alt="neck_french_long">
								</div>

								<div>
									<input  type="radio" name="neck_design" value="neck_french_short">
									<img src="./images/neck_french_short.png" alt="neck_french_short">
								</div>

							</div>
							<div>
								<input  type="number" name="neck_design_size">
								<label class="radio_label"  for="type" >
								مقاس تصميم الرقبة	
								</label>
							</div>
						</div>
						

					</div>
				</div>

				<div class="col">
					<div class="modal-input-section-container" >
						
						<div class="modal-input-container" style="width:100%;">
							<label for="addons" >
							ملاحظة</br>  Note
							</label>
							<div>
								<textarea style="width:100%;" name="note" id="" cols="30" rows="10">

								</textarea>
							</div>
						</div>
						

					</div>
				</div>

				<div class="col">
					<h2 class="modal-input-section-header" id="sizes-input-section">المدفوعات</h2>
					<div class="modal-input-section-container customer">
						
						<div class="modal-input-container">
							<label for="total" >
								الاجمالي </br> Total
							</label>
							
							<div>
								<input required min="1" max="10000" type="number" class="form-control" class="total" name="total">								
							<span class="input-group-addon">ريال</span>	
							</div>
						</div>

						<div class="modal-input-container">
							<label for="total_paid" >
							المبلغ المدفوع  </br> Total Paid
							</label>
							<div>
								<input  readonly min="1" max="10000" type="number" class="form-control" class="total_paid" name="total_paid">								
							<span class="input-group-addon">ريال</span>	
							</div>
						</div>
					</div>
					<h2 class="modal-input-section-header" id="total_Left"></h2>

				</div>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> Save</button>
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
            	<h4 class="modal-title"><b><span id="overtime_date"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="fatoora_delete.php">
            		<input type="hidden" class="fatoora_id" name="delete_fatoora_id">
            		<div class="text-center">
	                	<p> حذف الفاتورة</p>
	                	<h2 class="employee_name bold"></h2>
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


     