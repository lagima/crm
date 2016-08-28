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
		if(!$this->postvalue('initial'))
			$this->setformerror("Please enter the initial", '__initial');

		$this->routeto("/research/property/$pi_propertyid");
	}

	public function saveownerAction() {

	}

}