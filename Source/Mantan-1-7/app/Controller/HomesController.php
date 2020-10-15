<?php
   class HomesController extends AppController
   {

	    var $name = 'Homes';

        var $helpers = array('Session','Paginator');

        var $paginate = array();
		
		function index()
		{
			//Configure::write('debug', 2);
            Controller::loadModel('Option');
            
            $this->setup();
			global $isHome;
            global $urlLocal;
            global $urlLocalThemeActive;
            global $variableGlobal;
			
			$isHome= true;
			$this->layout='default';
            $themeActive= $this->Option->getOption('theme');
            
            $filename = $urlLocalThemeActive.'/controller.php';
            $url= $themeActive['Option']['value'].'/index.php';
		    
	        if(file_exists($filename))
	        {
	            include_once($filename);
	            if(function_exists('indexTheme'))
	            {
		            $input= array('fileProcess'=>$url,'request'=>$this->request);
			        indexTheme($input);
	            }
	        }
            
            foreach($variableGlobal as $variable){
        		global $$variable;
                $this->set($variable, $$variable);
        	}
		}
   }
?>