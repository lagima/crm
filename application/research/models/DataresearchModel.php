<?
namespace Mercury\App\Research\Models;

use Mercury\Helper\Model;

class DataresearchModel extends Model {


	protected function initmodel() {

		// Set this because the table name is not in standard format
		// $this->settable('some_table');

	}


	public function getimportdata($pi_batchsize = 10000) {

		// Set the table to query
		$this->settable('import_propertyowner');

		$la_data = $this->getrows(['imported' => 0], $pi_batchsize);

		return $la_data;
	}

	public function markasimported($pi_ownerid, $pi_streetid) {

		// Set the table to query
		$this->settable('import_propertyowner');

		$lb_success = $this->updaterows(['imported' => 1], ['streetid' => $pi_streetid, 'ownerid' => $pi_ownerid]);

		return $lb_success;

	}

	public function insertprocesseddata($pa_data, $pa_updatefields) {

		$this->db->dbinsertupdate('rawpropertyowner', $pa_data, $pa_updatefields);
	}

}