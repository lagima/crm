<?
namespace Mercury\App\Research\Models;

use Mercury\Helper\Model;

class DataresearchModel extends Model {

	// Some constants for this model
	const TABLE_IMPORTOWNER = 'import_owner';
	const TABLE_IMPORTSTREET = 'import_street';
	const TABLE_IMPORTSTREETOWNER = 'import_streetowner';
	const TABLE_IMPORTCHANGESETOWNER = 'import_changesetowner';
	const TABLE_IMPORTCHANGESETSTREET = 'import_changesetstreet';
	const TABLE_PROPERTY = 'property';
	const TABLE_OWNER = 'owner';


	protected function initmodel() {

		// Set this because the table name is not in standard format
		// $this->settable('some_table');

	}


	public function getimportownertable() {
		return self::TABLE_IMPORTOWNER;
	}


	public function getimportstreettable() {
		return self::TABLE_IMPORTSTREET;
	}

	public function getpropertytable() {
		return self::TABLE_PROPERTY;
	}


	public function getownertable() {
		return self::TABLE_OWNER;
	}


	public function getimportfieldsmapping() {

		return [
			'title_no' => 'titleno',
			'estate_description' => 'estatedescription',
		];
	}


	public function getuniquepropertyid($pa_property) {

		if(!is_array($pa_property)) {
			trigger_error("Cannot create unique property id", E_USER_ERROR);
			return false;
		}

		// Prepare the data
		$ls_titleno = $pa_property['titleno'] ?? '';
		$ls_importstreetid = $pa_property['importstreetid'] ?? '';

		if(empty($ls_titleno) || empty($ls_importstreetid)) {
			trigger_error("Invalid data given to create unique property id", E_USER_ERROR);
			return false;
		}

		return crc32($ls_titleno . $ls_importstreetid);
	}


	public function getuniqueownerid($pa_owner) {

		if(!is_array($pa_owner)) {
			trigger_error("Cannot create unique owner id", E_USER_ERROR);
			return false;
		}

		// Prepare the data
		$ls_importownerid = $pa_owner['importownerid'] ?? '';
		$ls_ownername = $pa_owner['ownername'] ?? '';

		if(empty($ls_importownerid) || empty($ls_ownername)) {
			trigger_error("Invalid data given to create unique owner id", E_USER_ERROR);
			return false;
		}

		return crc32($ls_importownerid . $ls_ownername);
	}


	public function getimportdata($pi_batchsize = 10000) {

		// Set the table to query
		$this->settable(self::TABLE_IMPORTSTREETOWNER);

		$la_data = $this->getrows(['imported' => 0], $pi_batchsize);

		return $la_data;
	}


	/**
	 * This imports data into owner table
	 * used when the changeset got INSERT type records
	 */
	public function importownerdata($pa_data, $pa_updatefields) {
		$this->db->dbinsertupdate(self::TABLE_IMPORTOWNER, $pa_data, $pa_updatefields);
	}


	/**
	 * This imports data into street table
	 * used when the changeset got INSERT type records
	 */
	public function importstreetdata($pa_data, $pa_updatefields) {
		$this->db->dbinsertupdate(self::TABLE_IMPORTSTREET, $pa_data, $pa_updatefields);
	}


	public function updateimportownerdata($pa_data, $pi_ownerid) {

		// Set the table to query
		$this->settable(self::TABLE_IMPORTOWNER);

		$lb_success = $this->update($pa_data, ['id' => $pi_ownerid]);

		return $lb_success;
	}


	public function updateimportstreetdata($pa_data, $pi_ownerid) {

		// Set the table to query
		$this->settable(self::TABLE_IMPORTSTREET);

		$lb_success = $this->update($pa_data, ['id' => $pi_ownerid]);

		return $lb_success;
	}


	public function markasimported($pi_ownerid, $pi_streetid) {

		// Set the table to query
		$this->settable(self::TABLE_IMPORTSTREET);

		$la_data = ['imported' => 1];
		$la_condition = ['id' => $pi_streetid];
		$this->update($la_data, $la_condition);

		// Set the table to query
		$this->settable(self::TABLE_IMPORTOWNER);

		$la_data = ['imported' => 1];
		$la_condition = ['id' => $pi_ownerid];
		$this->update($la_data, $la_condition);

		return true;
	}


	public function getchangesetdata($ps_type, $pi_batchsize) {

		// Set the table based on type
		if($ps_type == 'OWNERS')
			$this->settable(self::TABLE_IMPORTCHANGESETOWNER);

		elseif($ps_type == 'STREET')
			$this->settable(self::TABLE_IMPORTCHANGESETSTREET);

		// Return nothing if not of desired type
		else
			return [];

		$la_data = $this->getrows(['processed' => 0], $pi_batchsize);

		return $la_data;
	}


	public function processedchangesetdata($ps_type, $pi_id) {

		$lb_result = false;

		// Set the table based on type
		if($ps_type == 'OWNERS') {
			$this->settable(self::TABLE_IMPORTCHANGESETOWNER);
			$lb_result = $this->update(['processed' => 1], ['id' => $pi_id]);
		}

		elseif($ps_type == 'STREET') {
			$this->settable(self::TABLE_IMPORTCHANGESETSTREET);
			$lb_result = $this->update(['processed' => 1], ['id' => $pi_id]);
		}

		return $lb_result;
	}


	public function getproperty($pi_propertyid) {

		// Set the table to query
		$this->settable(self::TABLE_PROPERTY);

		$lo_property = $this->getrow(['propertyid' => $pi_propertyid]);

		return $lo_property;
	}


	public function savepropertydata($pa_data, $pa_updatefields = null) {

		if(is_null($pa_updatefields))
			$pa_updatefields = ['propertytype', 'estatedescription', 'locality', 'territorialauthority'];

		$this->db->dbinsertupdate(self::TABLE_PROPERTY, $pa_data, $pa_updatefields);
	}


	public function getowner($pi_ownerid) {

		// Set the table to query
		$this->settable(self::TABLE_OWNER);

		$lo_owner = $this->getrow(['ownerid' => $pi_ownerid]);

		return $lo_owner;
	}


	public function getownersbyimportid($pi_importownerid) {

		// Set the table to query
		$this->settable(self::TABLE_OWNER);

		$la_owners = $this->getrows(['importownerid' => $pi_importownerid]);

		return $la_owners;
	}


	public function getownersbyname($ps_name) {

		// Set the table to query
		$this->settable(self::TABLE_OWNER);

		$la_owners = $this->getrows(['ownername' => $ps_name]);

		return $la_owners;
	}


	public function saveownerdata($pa_data, $pa_updatefields = null) {

		if(is_null($pa_updatefields))
			$pa_updatefields = ['ownername', 'deleted'];

		$this->db->dbinsertupdate(self::TABLE_OWNER, $pa_data, $pa_updatefields);
	}


	public function groupwoners($pa_ownerid, $pi_masterownerid) {

		// Set the table to query
		$this->settable(self::TABLE_OWNER);

		$lb_result = $this->update(['linkid' => $pi_masterownerid], ['ownerid' => $pa_ownerid]);

		if($lb_result)
			$lb_result = $this->update(['ismaster' => 1], ['ownerid' => $pi_masterownerid]);

		return $lb_result;
	}

}