<?
namespace Mercury\App\Callcenter\Controllers;

use Mercury\Helper\Controller;

class DashboardController extends Controller {


	public function initcontroller() {

		/**
		* Avoid defining a constructor use this method instead
		*/
	}

	public function dashboardAction() {

		// echo "Sample file test git.";
		$this->buildresponse(['ls_pagetitle' => 'Controller']);
	}

}