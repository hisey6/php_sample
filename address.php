<?php
    require_once ($classPath . '/includes/merit/address.php');
    
    class EventsAddress extends Address {
        
		// Arrays for lists
		private $idList = array();
		private $states = array();
		private $countries = array();
		
        function __construct()
        {
            parent::__construct();
  	
        }
  
        function __destruct()
        {
            parent::__destruct();
        }
		
		public function IDList($value = null)
		{
            if (empty($value)) {
                // get value
                return $this->idList;
            } else {
                // set value
                $this->idList = $value;
            }			
		}
		
		public function States($value = null)
		{
			if (empty($value)) {
				// get value
				return $this->states;
			} else {
				// set value
				$this->states = $value;
			}
		}
		
		public function Countries($value = null)
		{
			if (empty($value)) {
				// get value
				return $this->countries;
			} else {
				// set value
				$this->countries = $value;
			}
		}
		
		public function GetStates()
		{
			$xml = simplexml_load_file(dirname(dirname(dirname(__FILE__))) . "/files/states.xml");
			
			foreach ($xml->children() as $child) {
				$this->states[] = array("StateCode" => $child->attributes(),"StateName" => $child);
			}
		}
		
		public function GetCountries()
		{
			$xml = simplexml_load_file(dirname(dirname(dirname(__FILE__))) . "/files/countries.xml");
			
			foreach ($xml->children() as $child) {
				$this->countries[] = array("CountryCode" => $child->attributes(),"CountryName" => $child);
			}
		}
		
    }