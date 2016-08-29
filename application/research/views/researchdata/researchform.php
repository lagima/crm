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
									<label for="" class="">
										Unit No.
									</label>
									<input type="text" class="form-control" name="__unitno" value="<?= $po_property->unitno ?>" id="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group <?= $this->validatefield('__streetno', 'has-error', 'PROPERTY') ?>">
									<label for="" class="<?= $this->validatefield('__streetno', 'inputError', 'PROPERTY') ?>">
										Street No. *
									</label>
									<input type="text"
											class="form-control"
											name="__streetno"
											value="<?= $this->postvalue('__streetno', $po_property->streetno) ?>"
											id=""
									>
									<?= $this->getfielderror('__streetno', 'PROPERTY') ?>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Street Name</label>
					              	<input type="text"
											class="form-control"
											name="__roadname"
											value="<?= $this->postvalue('__roadname', $po_property->roadname) ?>"
											id=""
									>
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Suburb</label>
									<input type="text" class="form-control" value="<?= $po_property->locality ?>" id="" readonly="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">City</label>
									<input type="text" class="form-control" value="<?= $po_property->territorialauthority ?>" id="" readonly="">
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group <?= $this->validatefield('__researcher', 'has-error', 'PROPERTY') ?>">
					              	<label for="" class="<?= $this->validatefield('__researcher', 'inputError', 'PROPERTY') ?>">Researcher Initial *</label>
					              	<input type="text"
											class="form-control"
											name="__researcher"
											value="<?= $this->postvalue('__researcher', $po_property->researcher) ?>"
											id=""
									>
					              	<?= $this->getfielderror('__researcher', 'PROPERTY') ?>
					            </div>
							</div>
						</div>
			        </div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
		        </form>
			</div><!-- /.box -->
		</div>
	</div>

	<?php foreach($pa_owners as $po_owner): ?>
	<?
	$ls_formref = 'OWNER-' . $po_owner->ownerid;
	?>
	<div class="row">
	    <!-- left column -->
	    <div class="col-md-12">
	    	<!-- general form elements -->
			<div class="box box-primary">
		        <div class="box-header with-border">
		        	<h3 class="box-title">Owner - <?= $po_owner->ownername ?></h3>
		        </div><!-- /.box-header -->
		        <!-- form start -->
		        <form role="form" action="/research/saveowner/<?= $po_owner->ownerid ?>/<?= $po_property->propertyid ?>" method="POST">
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" class="form-control" id="" value="<?= $po_owner->ownername ?>" readonly="">
							    </div>
							</div>
							<div class="col-xs-6 col-xs-12">
								<div class="form-group <?= $this->validatefield('__researcher', 'has-error', $ls_formref) ?>">
					              	<label for="" class="<?= $this->validatefield('__researcher', 'inputError', $ls_formref) ?>">Researcher Initial *</label>
					              	<input type="text"
										class="form-control"
										name="__researcher"
										value="<?= $this->postvalue('__researcher', $po_owner->researcher) ?>"
										id=""
									>
					              	<?= $this->getfielderror('__researcher', $ls_formref) ?>
					            </div>
							</div>
						</div>
			            <div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Phone 1</label>
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
					                    <input type="text"
											class="form-control"
											name="__phone1"
											value="<?= $this->postvalue('__phone1', $po_owner->phone1) ?>"
											id=""
										>
					                </div>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Phone 2</label>
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
					                    <input type="text"
											class="form-control"
											name="__phone2"
											value="<?= $this->postvalue('__phone2', $po_owner->phone2) ?>"
											id=""
										>
					                </div>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Email</label>
					              	<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					                    <input type="email"
											class="form-control"
											name="__email"
											value="<?= $this->postvalue('__email', $po_owner->email) ?>"
											id=""
										>
					                </div>
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Unit No.</label>
									<input type="text"
										class="form-control"
										name="__unitno"
										value="<?= $this->postvalue('__unitno', $po_owner->unitno) ?>"
										id=""
									>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="">Street No</label>
									<input type="text"
										class="form-control"
										name="__streetno"
										value="<?= $this->postvalue('__streetno', $po_owner->streetno) ?>"
										id=""
									>
					            </div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
					              	<label for="">Street Name</label>
					              	<input type="text"
										class="form-control"
										name="__streetname"
										value="<?= $this->postvalue('__streetname', $po_owner->streetname) ?>"
										id=""
									>
					            </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="">Suburb</label>
									<input type="text"
										class="form-control"
										name="__suburb"
										value="<?= $this->postvalue('__suburb', $po_owner->suburb) ?>"
										id=""
									>
					            </div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="">City</label>
									<input type="text"
										class="form-control"
										name="__city"
										value="<?= $this->postvalue('__city', $po_owner->city) ?>"
										id=""
									>
					            </div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
					              	<label for="">Postcode</label>
					              	<input type="text"
										class="form-control"
										name="__postcode"
										value="<?= $this->postvalue('__postcode', $po_owner->postcode) ?>"
										id=""
									>
					            </div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="">Country</label>
									<input type="text"
										class="form-control"
										name="__country"
										value="<?= $this->postvalue('__country', $po_owner->country) ?>"
										id=""
									>
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
												<input type="checkbox"
														name="sameowner[]"
														value="<?= $lo_similarowner->ownerid ?>"
														<?= $lo_similarowner->linkid ? 'checked=""' : ''?>
												>
												<?= $lo_similarowner->ownertext ?>
											</label>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="col-xs-6">
								<h4>Master Owner (Other records will get data from master)</h4>
								<div class="form-group <?= $this->validatefield('masterowner', 'has-error', $ls_formref) ?>">
									<?php foreach($po_owner->similarowners as $lo_similarowner): ?>
										<div class="radio">
											<label class="<?= $this->validatefield('masterowner', 'inputError', $ls_formref) ?>">
												<input type="radio"
														name="masterowner"
														value="<?= $lo_similarowner->ownerid ?>"
														<?= $lo_similarowner->ismaster ? 'checked=""' : ''?>
												>
												<?= $lo_similarowner->ownertext ?>
											</label>
											<?= $this->getfielderror('masterowner', $ls_formref) ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>

			            <!-- checkbox -->
			        </div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
		        </form>
			</div><!-- /.box -->
		</div>
	</div>
	<?php endforeach; ?>
</section>