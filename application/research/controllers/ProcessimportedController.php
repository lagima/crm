<?
namespace Mercury\App\Research\Controllers;

use Mercury\Helper\Controller;
use Mercury\App\Research\Models\DataresearchModel;

class ProcessimportedController extends Controller {


	public function initcontroller() {

		// Get the models needed
		$this->dataresearchmodel = new DataresearchModel($this->di);
	}

	public function indexAction() {

		// Placeholders
		// $la_imported = [];
		// $la_insert = [];

		/**
		 * Rules are:
		 * 1. Get the data that are not marked imported yet from `import_propertyowner`
		 * 2. Go through the data and process them
		 * 3. Extract unitno and street number from housenumber field
		 * 4. Prepare the data fields for inserting
		 * 5. Insert the processed data to staging table
		 * 6. Update the processed data on import table as imported
		 */

		// 1. Get the data that are not marked imported yet from `import_propertyowner`
		$la_importdata = $this->dataresearchmodel->getimportdata(10);


		// 2. Go through the data and process them
		foreach($la_importdata as $lo_data) {

			// 3. Extract unitno and street number from housenumber field
			$la_housenumber = $this->_processhousenumber($lo_data->housenumber);
			$lo_data->streetno = is_array($la_housenumber) ? array_pop($la_housenumber) : '';
			$lo_data->unitno = is_array($la_housenumber) ? array_pop($la_housenumber) : '';

			// 4. Prepare the data fields for inserting

			// Remove any additional fields that we wont need for the new table
			unset($lo_data->imported);

			// Change this later to be dynamic
			$la_data = (array)$lo_data;

			// 5. Insert the processed data to staging table
			$this->dataresearchmodel->insertprocesseddata($la_data, array_keys($la_data));

			// 6. Update the processed data on import table as imported
			// $la_importdata[] = $lo_data;
			$this->dataresearchmodel->markasimported($lo_data->ownerid, $lo_data->streetid);
		}

		$this->debug($la_importdata);
	}


	private function _processhousenumber($ps_housenumber) {

		// We can safely retun this if following rules are not matched
		$la_split[] = $ps_housenumber;

		// only if they are separated by just ‘/‘ leave rest to researchers
		if(preg_match("~^[0-9A-Za-z]{1,}(\/[0-9A-Za-z]{1,})?$~", $ps_housenumber)) {
			$la_split = explode('/', $ps_housenumber);
			$la_split = !is_array($la_split) ? [$la_split] : $la_split;
		}

		return $la_split;
	}

}