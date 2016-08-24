<?
namespace Mercury\App\Backend\Models;

use Mercury\Helper\Model;

class SampleModel extends Model {


	protected function initmodel() {

		// Set this because the table name is not in standard format
		$this->settable('some_table');

	}

}