<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;

 /**
  * Class CrudOrgaFiles
  */

class CrudOrgaFiles extends CRUDFiles {
	public function getViewIndex() {
		return "CrudOrga/index.html";
	}

	public function getViewDisplay() {
		return "CrudOrga/display.html";
	}

	public function getViewForm() {
		return "CrudOrga/form.html";
	}
}