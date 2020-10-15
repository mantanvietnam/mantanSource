<?php
		
	
	
	class Admin_Model_Order extends Admin_Model_System
	{
		public $invoiceId;
		
		public function create()
		{
			////////////////////
			//	PROCESS TO ADD ORDER
			//	AND GENERATE INVOICE ID TO TRACKING
			$this->invoiceId = rand(1000000, 9999999);
			
			return true;
		}
	}