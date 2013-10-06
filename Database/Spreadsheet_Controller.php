<?php
/**
 * @see Zend_Loader
 */
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/ZendGdata-1.11.11/library/Zend/Loader.php';

class Spreadsheet_Controller {
	
	private $service;
	private $http;
	private $client;
	private $spreadsheetFeed;
	private $currKey;
	private $spreadsheetKey;
	private $aWorksheetKeys;
	private $aQueries;
	
    // Sets up the spreadsheet interactor to allow for queries and actions to be performed on the spreadsheet
	public function __construct(){
		set_include_path('/home/content/c/j/c/cjcornell3/html/bluegame/ZendGdata-1.11.11/library/');
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
		Zend_Loader::loadClass('Zend_Gdata_App_AuthException');
		Zend_Loader::loadClass('Zend_Http_Client');
		$this->service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
		$this->http = Zend_Gdata_ClientLogin::getHttpClient('beermantesting@gmail.com','beermantesting',$this->service);
		$this->client = new Zend_Gdata_Spreadsheets($this->http);
		$this->spreadsheetFeed = $this->client->getSpreadsheetFeed();
		$this->currKey = explode('/', $this->spreadsheetFeed->entries[0]->id->text); // We are assuming the first entry of worksheets for this user is the Capstone Database
		$this->spreadsheetKey = $this->currKey[5];
		$this->aWorksheetKeys = array();
		$this->getWorksheetKeys($this->spreadsheetKey); 
	}
	
	public function AddRow($worksheetName, $aToInsert){
		$this->client->insertRow($aToInsert, $this->spreadsheetKey, $this->aWorksheetKeys[$worksheetName]);		
	}
	
	public function GetLastID($worksheetName){
		if (!isset($this->aQueries[$worksheetName])){
			$this->aQueries[$worksheetName] = new Zend_Gdata_Spreadsheets_ListQuery();
			$this->aQueries[$worksheetName]->setSpreadsheetKey($this->spreadsheetKey);
			$this->aQueries[$worksheetName]->setWorksheetId($this->aWorksheetKeys[$worksheetName]);
		}
		$rowFeed = $this->client->getListFeed($this->aQueries[$worksheetName]);
		return count($rowFeed->entries) + 1;
	}
	
	public function GetRowsNoPredicate($worksheetName){ // equivalent of SELECT * FROM worksheetKey WHERE column=value
		if (!isset($this->aQueries[$worksheetName])){
			$this->aQueries[$worksheetName] = new Zend_Gdata_Spreadsheets_ListQuery();
			$this->aQueries[$worksheetName]->setSpreadsheetKey($this->spreadsheetKey);
			$this->aQueries[$worksheetName]->setWorksheetId($this->aWorksheetKeys[$worksheetName]);
		}
		// $query = '"' . $column . '=' . $value . '"';
		// echo $query;
		// $this->aQueries[$worksheetName]->setSpreadsheetQuery($query);
		$rowFeed = $this->client->getListFeed($this->aQueries[$worksheetName]);
		// $aResult = array();
		// $i = 0;
		// foreach ($rowFeed->entries as $entry){
			// $row = $entry->getCustom();
			// foreach($row as $col){
				// $aResult[$i][$col->getColumnName()] = $col->getText();
			// }
			// $i++;
		// }
		// return $aResult;
		$rowNums = array();
		$currRowNumber = 0;
		foreach ($rowFeed->entries as $entry){
			$row = $entry->getCustom();
			$rowNums[] = $currRowNumber;
			$currRowNumber++;
		}
		if (!count($rowNums)) {
			return NULL;
		}
		else {
			$aResult = array();
			$i = 0;
			foreach ($rowNums as $rowNum){
				$row = $rowFeed->entries[$rowNum];
				$customRow = $row->getCustom();
				foreach ($customRow as $customCol){
					$aResult[$i][$customCol->getColumnName()] = $customCol->getText();
			    }
				$i++;
			}
			return $aResult;
		}
	}
	
	public function GetRows($worksheetName, $column, $value){ // equivalent of SELECT * FROM worksheetKey WHERE column=value
		if (!isset($this->aQueries[$worksheetName])){
			$this->aQueries[$worksheetName] = new Zend_Gdata_Spreadsheets_ListQuery();
			$this->aQueries[$worksheetName]->setSpreadsheetKey($this->spreadsheetKey);
			$this->aQueries[$worksheetName]->setWorksheetId($this->aWorksheetKeys[$worksheetName]);
		}
		// $query = '"' . $column . '=' . $value . '"';
		// echo $query;
		// $this->aQueries[$worksheetName]->setSpreadsheetQuery($query);
		$rowFeed = $this->client->getListFeed($this->aQueries[$worksheetName]);
		// $aResult = array();
		// $i = 0;
		// foreach ($rowFeed->entries as $entry){
			// $row = $entry->getCustom();
			// foreach($row as $col){
				// $aResult[$i][$col->getColumnName()] = $col->getText();
			// }
			// $i++;
		// }
		// return $aResult;
		$rowNums = array();
		$currRowNumber = 0;
		foreach ($rowFeed->entries as $entry){
			$row = $entry->getCustom();
			foreach ($row as $col) {
				if ($col->getText() == $value && $col->getColumnName() == $column){
					$rowNums[] = $currRowNumber;
				}
			}
			$currRowNumber++;
		}
		if (!count($rowNums)) {
			return NULL;
		}
		else {
			$aResult = array();
			$i = 0;
			foreach ($rowNums as $rowNum){
				$row = $rowFeed->entries[$rowNum];
				$customRow = $row->getCustom();
				foreach ($customRow as $customCol){
					$aResult[$i][$customCol->getColumnName()] = $customCol->getText();
			    }
				$i++;
			}
			return $aResult;
		}
	}

	public function UpdateRow($worksheetName, $rowID, $aToInsert){
		if (!isset($this->aQueries[$worksheetName])){
			$this->aQueries[$worksheetName] = new Zend_Gdata_Spreadsheets_ListQuery();
			$this->aQueries[$worksheetName]->setSpreadsheetKey($this->spreadsheetKey);
			$this->aQueries[$worksheetName]->setWorksheetId($this->aWorksheetKeys[$worksheetName]);
		}
		$rowFeed = $this->client->getListFeed($this->aQueries[$worksheetName]);
		foreach ($rowFeed->entries as $entry){
			$row = $entry->getCustom();
			if ($row[0] == $rowID) $this->client->updateRow($entry, $aToInsert);
		}
	}

	public function RunQuery($worksheetName, $query){
		if (!isset($this->aQueries[$worksheetName])){
			$this->aQueries[$worksheetName] = new Zend_Gdata_Spreadsheets_ListQuery();
			$this->aQueries[$worksheetName]->setSpreadsheetKey($this->spreadsheetKey);
			$this->aQueries[$worksheetName]->setWorksheetId($this->aWorksheetKeys[$worksheetName]);
		}
		$this->aQueries[$worksheetName]->setSpreadsheetQuery($search);
		$rowFeed = $this->client->getListFeed($this->aQueries[$worksheetName]);
		
	}

	private function getWorksheetKeys($spreadsheetKey){ // Retrieves the keys of the worksheets for ease of reference later
		$query = new Zend_Gdata_Spreadsheets_DocumentQuery();
		$query->setSpreadsheetKey($spreadsheetKey);
		$worksheetFeed = $this->client->getWorksheetFeed($query);
		foreach ($worksheetFeed->entries as $entry) {
			$this->aWorksheetKeys[$entry->title->text] = array_pop(explode("/",$entry->id->text));
		}
	}
	
}

?>
