<?
namespace Mercury\App\Research\Controllers;

use Mercury\Helper\Controller;
use Mercury\App\Research\Models\DataresearchModel;

class ProcessdataController extends Controller {

	// Some constants used on this controller
	const BATCH_SIZE = 10000;


	public function initcontroller() {

		// Get the models needed
		$this->dataresearchmodel = new DataresearchModel($this->di);
	}

	public function indexAction() {

		/**
		 * Rules are:
		 * 1. Get the data that are not marked imported yet from import table
		 * 2. Go through the data and process them
		 * 3. Prepare the data fields for inserting into owner table
		 * 4. Prepare the data fields for inserting into property table
		 * 5. Update the processed data on import table as imported
		 */

		// 1. Get the data that are not marked imported yet from import table
		$la_importdata = $this->dataresearchmodel->getimportdata(self::BATCH_SIZE);


		// 2. Go through the data and process them
		foreach($la_importdata as $lo_data) {

			// Start the transaction mode for data protection
			$this->dataresearchmodel->starttransaction();

			// 3. Prepare the data fields for inserting into owner table

			// Split the owners into multiple entries
			$la_owners = explode(',', $lo_data->owners);

			foreach ($la_owners as $ls_owner) {

				$la_owner = [];

				// Santise the owner
				$ls_owner = trim($ls_owner);

				if(empty($ls_owner))
					continue;

				// Start building the owner data
				$la_owner['importownerid'] = $lo_data->importownerid;
				$la_owner['ownername'] = $ls_owner;

				// Get the unique id
				$li_ownerid = $this->dataresearchmodel->getuniqueownerid($la_owner);

				// We cant create the property id so no point in storing this
				if(empty($li_ownerid))
					continue;

				// Put the unit id to stack
				$la_owner['ownerid'] = $li_ownerid;

				// Look at the change and mark the owner as deleted
				if($lo_data->ownerchange == 'DELETE')
					$la_owner['deleted'] = 1;
				else
					$la_owner['deleted'] = 0;

				// Save the data now
				$this->dataresearchmodel->saveownerdata($la_owner);
			}


			// 4. Prepare the data fields for inserting into property table
			$la_property = [];

			// Extract unitno and street number from housenumber field
			$la_housenumber = $this->_processhousenumber($lo_data->housenumber);
			$lo_data->streetno = is_array($la_housenumber) ? array_pop($la_housenumber) : '';
			$lo_data->unitno = is_array($la_housenumber) ? array_pop($la_housenumber) : '';

			// Get the fields allowed
			$ls_propertytable = $this->dataresearchmodel->getpropertytable();
			$la_propertyfields = $this->dataresearchmodel->gettablefields($ls_propertytable);

			// Each property will have a property entry so build that first
			foreach($la_propertyfields as $ls_field) {

				if(property_exists($lo_data, $ls_field))
					$la_property[$ls_field] = trim($lo_data->{$ls_field});
			}

			$li_propertyid = $this->dataresearchmodel->getuniquepropertyid($la_property);

			// We cant create the property id so no point in storing this
			if(empty($li_propertyid))
				continue;

			// Put the generated key to the stack
			$la_property['propertyid'] = $li_propertyid;

			// Look at the change and mark the owner as deleted
			if($lo_data->streetchange == 'DELETE')
				$la_owner['deleted'] = 1;
			else
				$la_owner['deleted'] = 0;

			// Save the data now
			$this->dataresearchmodel->savepropertydata($la_property);



			// 5. Update the processed data on import table as imported
			$this->dataresearchmodel->markasimported($lo_data->importownerid, $lo_data->importstreetid);

			// Commit the transaction so data is written to db
			$this->dataresearchmodel->committransaction();
		}

		// $this->debug($la_importdata);
	}


	public function changesetAction($ps_type) {

		// Standardise them
		$ps_type = strtoupper($ps_type);

		switch($ps_type) {

			case 'OWNERS':

				/**
				 * So the rules are:
				 * 1. Get the changeset data from changeset table
				 * 2. Update owners data and mark them as not imported so the import script will pick them up again
				 * 3. Mark the owners as deleted if asked to be deleted (dont actually delete them)
				 * 4. Insert them into import_owner if its a new record then it gets picked up in import action
				 * 5. Mark the updated records to be researched again
				 */

				// 1. Get the changeset data from changeset table
				$la_changeset = $this->dataresearchmodel->getchangesetdata($ps_type, self::BATCH_SIZE);

				// Get the table
				$ls_table = $this->dataresearchmodel->getimportownertable();

				// Begin the actions
				foreach ($la_changeset as $lo_data) {

					// Start the transaction mode for data protection
					$this->dataresearchmodel->starttransaction();

					// Now that we got the data built identify the action UPDATE, DELETE, INSERT
					switch($lo_data->__change__) {

						// 2. Update owners data and mark them as not imported so the import script will pick them up again
						case 'UPDATE':

							// Build the data
							$la_data = $this->_processchangeset($ls_table, $lo_data);

							// If cannot find useful data skip
							if(empty($la_data))
								continue;

							// If we cant find a shape dont update that
							if(isset($la_data['WKT']) && empty($la_data['WKT']))
								unset($la_data['WKT']);

							$this->dataresearchmodel->updateownerdata($la_data, $lo_data->id);

						break;

						// 3. Mark the owners as deleted if asked to be deleted (dont actually delete them)
						case 'DELETE':

							$la_data = [];
							$la_data['change'] = $lo_data->__change__;

							$this->dataresearchmodel->updateownerdata($la_data, $lo_data->id);

						break;

						// 4. Insert them into import_owner if its a new record then it gets picked up in import action
						case 'INSERT':

							// Build the data
							$la_data = $this->_processchangeset($ls_table, $lo_data);

							// If cannot find useful data skip
							if(empty($la_data))
								continue;

							// If we cant find a shape no point in inserting
							if(!isset($la_data['WKT']) || empty($la_data['WKT']))
								continue;

							$this->dataresearchmodel->importownerdata($la_data, array_keys($la_data));

						break;
					}


					// 5. Flag the processed data
					$this->dataresearchmodel->processedchangesetdata($ps_type, $lo_data->id);

					// Commit the transaction so data is written to db
					$this->dataresearchmodel->committransaction();
				}
				// $this->debug($la_changeset);

			break;

			case 'STREET':

				/**
				 * So the rules are:
				 * 1. Get the changeset data from changeset table
				 * 2. Update owners data and mark them as not imported so the import script will pick them up again
				 * 3. Mark the owners as deleted if asked to be deleted (dont actually delete them)
				 * 4. Insert them into import_street if its a new record then it gets picked up in import action
				 * 5. Mark the updated records to be researched again
				 */

				// 1. Get the changeset data from changeset table
				$la_changeset = $this->dataresearchmodel->getchangesetdata($ps_type, self::BATCH_SIZE);

				// Get the table
				$ls_table = $this->dataresearchmodel->getimportstreettable();

				// Begin the actions
				foreach ($la_changeset as $lo_data) {

					// Start the transaction mode for data protection
					$this->dataresearchmodel->starttransaction();

					// Now that we got the data built identify the action UPDATE, DELETE, INSERT
					switch($lo_data->__change__) {

						// 2. Update owners data and mark them as not imported so the import script will pick them up again
						case 'UPDATE':

							// Build the data
							$la_data = $this->_processchangeset($ls_table, $lo_data);

							// If cannot find useful data skip
							if(empty($la_data))
								continue;

							// If we cant find a shape dont update that
							if(isset($la_data['WKT']) && empty($la_data['WKT']))
								unset($la_data['WKT']);

							$this->dataresearchmodel->updatestreetdata($la_data, $lo_data->id);

						break;

						// 3. Mark the owners as deleted if asked to be deleted (dont actually delete them)
						case 'DELETE':

							$la_data = [];
							$la_data['change'] = $lo_data->__change__;

							$this->dataresearchmodel->updatestreetdata($la_data, $lo_data->id);

						break;

						// 4. Insert them into import_owner if its a new record then it gets picked up in import action
						case 'INSERT':

							// Build the data
							$la_data = $this->_processchangeset($ls_table, $lo_data);

							// If cannot find useful data skip
							if(empty($la_data))
								continue;

							// If we cant find a shape no point in inserting
							if(!isset($la_data['WKT']) || empty($la_data['WKT']))
								continue;

							$this->dataresearchmodel->importstreetdata($la_data, array_keys($la_data));

						break;
					}


					// 5. Flag the processed data
					$this->dataresearchmodel->processedchangesetdata($ps_type, $lo_data->id);

					// Commit the transaction so data is written to db
					$this->dataresearchmodel->committransaction();
				}
				// $this->debug($la_changeset);

			break;

			default:

				$this->debug("Invalid changeset type");

			break;
		}
	}


	public function normalisedataAction() {

		$this->debug(crc32("NA19D/12831916656"));
		$this->debug(crc32("NA19D/12841916656"));
		$this->debug(crc32("NA19D/12851916656"));

	}


	private function _processchangeset($ps_table, $po_data) {

		// Get the fields allowed
		$la_fields = $this->dataresearchmodel->gettablefields($ps_table);

		// Build the data
		$la_data = [];

		foreach($la_fields as $ls_field) {

			// If the field is `shape` map it to `WKT`
			if($ls_field == 'shape')
				$la_data['WKT'] = $po_data->{$ls_field};

			elseif(property_exists($po_data, $ls_field))
				$la_data[$ls_field] = $po_data->{$ls_field};
		}

		// If cannot find useful data skip
		if(empty($la_data))
			return [];

		// If we cant find a shape dont update that
		if(isset($la_data['WKT']) && empty($la_data['WKT']))
			unset($la_data['WKT']);

		// Also tag them as not imported so it will be processed by data import again
		if(isset($la_fields['imported']))
			$la_data['imported'] = 0;

		// Set the change type
		$la_data['change'] = $po_data->__change__;

		// Set it to be researched again cos we just might have changed it
		if(isset($la_fields['researched']))
			$la_data['researched'] = 0;

		return $la_data;
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