<?
namespace Mercury\App\Research\Controllers;

use Mercury\Helper\Controller;
use Mercury\App\Research\Models\DataresearchModel;

class ResearchdataController extends Controller {


	public function initcontroller() {

		// Get the models needed
		$this->dataresearchmodel = new DataresearchModel($this->di);
	}

	public function indexAction($pi_propertyid) {
		// Set the view
		$this->setview('researchform');

		// Get the porperty
		$lo_property = $this->dataresearchmodel->getproperty($pi_propertyid);

		// If we cant find the property stop here
		if(!is_object($lo_property))
			$this->redirect('/research');

		// Get the owners of the property
		$la_owners = $this->dataresearchmodel->getownersbyimportid($lo_property->importownerid);

		if(empty($la_owners))
			$this->redirect('/research');

		// Get the similar owners
		foreach ($la_owners as $lo_owner) {

			// Placeholder
			$lo_owner->similarowners = [];

			$la_similarowners = $this->dataresearchmodel->getownersbyname($lo_owner->ownername);

			if(!is_array($la_similarowners))
				continue;

			foreach ($la_similarowners as $lo_similarowner) {

				$lo_similarowner->currentowner = $lo_similarowner->ownerid == $lo_owner->ownerid;
				$lo_similarowner->ownertext = $lo_similarowner->ownername  . ($lo_similarowner->currentowner ? ' (Current)' : '');

				$lo_owner->similarowners[] = $lo_similarowner;
			}

		}

		// Build the response for the view
		$this->buildresponse(['po_property' => $lo_property]);
		$this->buildresponse(['pa_owners' => $la_owners]);
	}

	public function savepropertyAction($pi_propertyid) {

		// Validate
		if(!$this->postvalue('__researcher'))
			$this->setformerror("Please enter the initial", '__researcher', 'PROPERTY');

		if(!$this->postvalue('__streetno'))
			$this->setformerror("Please enter the Street No.", '__streetno', 'PROPERTY');

		// Save to db if validation passes
		if(!$this->hasformerrors('PROPERTY')) {
			// Get the table
			$ls_table = $this->dataresearchmodel->getpropertytable();
			$this->dataresearchmodel->commitupdatefrompost('propertyid', $pi_propertyid, $ls_table);

			// All good so can redirect
			$this->setflashmessage("Property updated!", 'SUCCESS');
			$this->redirect("/research/property/$pi_propertyid");
		}

		$this->setflashmessage("Property not updated!");
		$this->routeto("/research/property/$pi_propertyid");
	}

	public function saveownerAction($pi_ownerid, $pi_propertyid) {

		// Get the table
		$ls_table = $this->dataresearchmodel->getownertable();
		$ls_tableref = 'OWNER-' . $pi_ownerid;

		// Validate
		if(!$this->postvalue('__researcher'))
			$this->setformerror("Please enter the initial", '__researcher', $ls_tableref);

		// Check if the owners are marked similar
		$lb_groupowner = false;
		$li_masterowner = $this->postvalue('masterowner');
		$la_sameowner = $this->postvalue('sameowner');

		// $this->debugx($la_sameowner);
		if(!empty($la_sameowner)) {

			// We need a master owner to group the owners
			if(empty($li_masterowner))
				$this->setformerror("Please choose the master", 'masterowner', $ls_tableref);
			else
				$lb_groupowner = true;
		}

		// Save to db if validation passes
		if(!$this->hasformerrors($ls_tableref)) {

			// Save the post data into table
			$this->dataresearchmodel->commitupdatefrompost('ownerid', $pi_ownerid, $ls_table);

			// If asked to group the owners do that too
			if($lb_groupowner) {
				$this->dataresearchmodel->groupwoners($la_sameowner, $li_masterowner);
			}

			// All good so can redirect
			$this->setflashmessage("Owner updated!", 'SUCCESS');
			$this->redirect("/research/property/$pi_propertyid");
		}

		$this->routeto("/research/property/$pi_propertyid");

	}

}