<?php
	class DatabaseUser {
	  // Properties
		public $hostname="localhost";
		public $username="webuser";
		public $userkey="rhAADbNrGJbc2Rx!";

		function get_key() {
			return $this->userkey;
	  	}
	  	function get_name() {
			return $this->username;
	  	}
		function get_host() {
			return $this->hostname;
	  	}
	}
?>