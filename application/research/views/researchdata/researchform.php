<?php $this->layout($gs_template, $ga_templatedata) ?>
<section class="content-header">
  <h1>
    Research Data
    <small>Preview</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Forms</a></li>
    <li class="active">General Elements</li>
  </ol>
</section>

<section class="content">
	<div class="row">
	    <!-- left column -->
	    <div class="col-md-12">

	    	<?= $this->getflashmessage() ?>

	    	<!-- general form elements -->
			<div class="box box-primary">
		        <div class="box-header with-border">
		        	<h3 class="box-title">Property Details</h3>
		        </div><!-- /.box-header -->
		        <!-- form start -->
		        <form role="form" action="/research/saveproperty/<?= $po_property->propertyid ?>" method="POST">
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Title No.</label>
									<input type="text" class="form-control" value="<?= $po_property->titleno ?>" id="" readonly="">
							    </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Property Type</label>
									<input type="text" class="form-control" value="<?= $po_property->propertytype ?>" id="" readonly="">
							    </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
							      	<label for="">Duplicate</label>
							      	<div class="checkbox">
										<label>
											<input type="checkbox"> Check if duplicate and click save
										</label>
							        </div>
							    </div>
							</div>
						</div>

			            <div class="form-group">
							<label for="">Estate Description</label>
							<textarea class="form-control" id="" readonly=""><?= $po_property->estatedescription ?></textarea>
			            </div>

			            <div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Unit No.</label>
									<input type="text" class="form-control" value="<?= $po_property->unitno ?>" id="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Street No</label>
									<input type="text" class="form-control" value="<?= $po_property->streetno ?>" id="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Street Name</label>
					              	<input type="text" class="form-control" value="<?= $po_property->roadname ?>" id="">
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Suburb</label>
									<input type="text" class="form-control" value="<?= $po_property->locality ?>" id="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">City</label>
									<input type="text" class="form-control" value="<?= $po_property->territorialauthority ?>" id="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Researcher Initial</label>
					              	<input type="text" class="form-control" name="__initial" value="<?= $po_property->researcher ?>" id="">
					            </div>
							</div>
						</div>
			        </div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
		        </form>
			</div><!-- /.box -->
		</div>
	</div>

	<?php foreach($pa_owners as $po_owner): ?>
	<div class="row">
	    <!-- left column -->
	    <div class="col-md-12">
	    	<!-- general form elements -->
			<div class="box box-primary">
		        <div class="box-header with-border">
		        	<h3 class="box-title">Owner - <?= $po_owner->ownername ?></h3>
		        </div><!-- /.box-header -->
		        <!-- form start -->
		        <form role="form">
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->ownername ?>" readonly="">
							    </div>
							</div>
							<div class="col-xs-6 col-xs-12">
								<div class="form-group">
					              	<label for="">Researcher Initial</label>
					              	<input type="text" class="form-control" value="<?= $po_owner->researcher ?>" id="">
					            </div>
							</div>
						</div>
			            <div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Phone 1</label>
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
					                    <input type="email" class="form-control" placeholder="Landline" value="<?= $po_owner->phone1 ?>">
					                </div>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Phone 2</label>
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
					                    <input type="email" class="form-control" placeholder="Mobile" value="<?= $po_owner->phone2 ?>">
					                </div>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Email</label>
					              	<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					                    <input type="email" class="form-control" placeholder="Email" value="<?= $po_owner->email ?>">
					                </div>
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Unit No.</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->unitno ?>">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Street No</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->streetno ?>">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Street Name</label>
					              	<input type="text" class="form-control" id="" value="<?= $po_owner->streetname ?>">
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="">Suburb</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->suburb ?>">
					            </div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="">City</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->city ?>">
					            </div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
					              	<label for="">Postcode</label>
					              	<input type="text" class="form-control" id="" value="<?= $po_owner->postcode ?>">
					            </div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="">Country</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->country ?>">
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-6">
								<h4>Similar Owners (Check to mark as same person)</h4>
								<div class="form-group">
									<?php foreach($po_owner->similarowners as $lo_similarowner): ?>
									<div class="checkbox">
										<label>
											<input type="checkbox"> <?= $lo_similarowner->ownertext ?>
										</label>
									</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="col-xs-6">
								<h4>Master Owner (Other records will get data from master)</h4>
								<div class="form-group">
									<div class="checkbox">
										<label>
											<input type="checkbox"> Checkbox 1
										</label>
									</div>

									<div class="checkbox">
										<label>
											<input type="checkbox"> Checkbox 2
										</label>
									</div>

									<div class="checkbox">
										<label>
											<input type="checkbox" disabled=""> Checkbox disabled
										</label>
									</div>
								</div>
							</div>
						</div>

			            <!-- checkbox -->
			        </div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
		        </form>
			</div><!-- /.box -->
		</div>
	</div>
	<?php endforeach; ?>
</section>