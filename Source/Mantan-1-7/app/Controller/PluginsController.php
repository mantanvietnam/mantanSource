<?php

   class PluginsController extends AppController
   {
	   
	    var $name = 'Plugins';

        var $helpers = array('Session','Paginator');

        var $paginate = array();
		
		function admin($url,$var1=null,$var2=null,$var3=null,$var4=null,$var5=null,$var6=null,$var7=null,$var8=null,$var9=null,$var10=null)
		{
			global $isRequestPost;
			global $isRequestPut;
			global $isRequestGet;
			global $isRequestAjax;
			
			//Configure::write('debug', 2);
			$urlLocal= $this->getUrlLocal();
			$users= $this->Session->read('infoAdminLogin');
	        if($users)
	        {
				$this->setup();
				
	        	if(isset($routesPlugin[$url]))
				{
					$url= $routesPlugin[$url];
				}
				else
				{
					$url= str_replace('-', '/', $url);
				}
				
				$this->set('urlFilePlugin', $url);
				
				if(isset($_GET['layout']))
				{
					$this->layout= $_GET['layout'];
				}
				
				$this->set('var1', $var1);
				$this->set('var2', $var2);
				$this->set('var3', $var3);
				$this->set('var4', $var4);
				$this->set('var5', $var5);
				$this->set('var6', $var6);
				$this->set('var7', $var7);
				$this->set('var8', $var8);
				$this->set('var9', $var9);
				$this->set('var10', $var10);
				
				$isRequestPost= $this->request->is('post');
				$isRequestPut= $this->request->is('put');
				$isRequestGet= $this->request->is('get');
				$isRequestAjax= $this->request->is('ajax');
				
				$plugin= explode('/', $url);
				
				$filename = $urlLocal['urlLocalPlugin'].$plugin[0].'/controller.php';
		        if (file_exists($filename))
		        {
		            include_once($filename);
		            $count= count($plugin)-1;
		            $plugin= explode('.', $plugin[$count]);
		            if(function_exists($plugin[0]))
		            {
		            	$input= array('fileProcess'=>$url,'request'=>$this->request);
			            $plugin[0]($input);
			            
		            }elseif(!file_exists($urlLocal['urlLocalPlugin'].$url)){
				        $this->redirect($urlLocal['urlAdmins']);
			        }
		        }elseif(!file_exists($urlLocal['urlLocalPlugin'].$url)){
			        $this->redirect($urlLocal['urlAdmins']);
		        }
			}
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
		}
		
		function theme($url,$var1=null,$var2=null,$var3=null,$var4=null,$var5=null,$var6=null,$var7=null,$var8=null,$var9=null,$var10=null)
		{
			global $isRequestPost;
			global $isRequestPut;
			global $isRequestGet;
			global $isRequestAjax;
			
			//Configure::write('debug', 2);
			$users= $this->Session->read('infoAdminLogin');
			$urlLocal= $this->getUrlLocal();
			
	        if($users)
	        {
	        	$this->setup();
	        	
	        	if(isset($routesPlugin[$url]))
				{
					$url= $routesPlugin[$url];
				}
				else
				{
					$url= str_replace('-', '/', $url);
				}
				
				$this->set('urlFileTheme', $url);
				
				if(isset($_GET['layout']))
				{
					$this->layout= $_GET['layout'];
				}
				
				$this->set('var1', $var1);
				$this->set('var2', $var2);
				$this->set('var3', $var3);
				$this->set('var4', $var4);
				$this->set('var5', $var5);
				$this->set('var6', $var6);
				$this->set('var7', $var7);
				$this->set('var8', $var8);
				$this->set('var9', $var9);
				$this->set('var10', $var10);
				
				$plugin= explode('/', $url);
				
				$isRequestPost= $this->request->is('post');
				$isRequestPut= $this->request->is('put');
				$isRequestGet= $this->request->is('get');
				$isRequestAjax= $this->request->is('ajax');
				
				$filename = $urlLocal['urlLocalTheme'].$plugin[0].'/controller.php';

		        if (file_exists($filename))
		        {
		            include_once($filename);
		            $count= count($plugin)-1;
		            $plugin= explode('.', $plugin[$count]);
		            if(function_exists($plugin[0]))
		            {
			            $input= array('fileProcess'=>$url,'request'=>$this->request);
			            $plugin[0]($input);
		            }elseif(!file_exists($urlLocal['urlLocalTheme'].$url)){
			        	$this->redirect($urlLocal['urlAdmins']);
			        }
		        }elseif(!file_exists($urlLocal['urlLocalTheme'].$url)){
		        	$this->redirect($urlLocal['urlAdmins']);
		        }
			}
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
		}
		
		function index($url,$var1=null,$var2=null,$var3=null,$var4=null,$var5=null,$var6=null,$var7=null,$var8=null,$var9=null,$var10=null)
		{
			//Configure::write('debug', 2);
			
			global $routesPlugin;
			global $routesTheme;
			global $isPlugin;
			global $isRequestPost;
			global $isRequestPut;
			global $isRequestGet;
			global $isRequestAjax;
			global $urlHomes;
			
			$this->setup();
			$urlLocal= $this->getUrlLocal();
			
			$isPlugin= true;
			
			if(isset($routesPlugin[$url]))
			{
				$url= $routesPlugin[$url];
				$routesType= 'Plugin';
			}elseif(isset($routesTheme[$url])){
				$url= $routesTheme[$url];
				$routesType= 'Theme';
			}else{
				$url= str_replace('-', '/', $url);
				$routesType= '';
			}
			
			$this->set('urlFilePlugin', $url);
			$this->set('routesType', $routesType);
			
			if(isset($_GET['layout'])&&$_GET['layout']!='')
			{
				$this->layout= $_GET['layout'];
			}else{
				$this->layout= 'default';
			}
			
			$this->set('var1', $var1);
			$this->set('var2', $var2);
			$this->set('var3', $var3);
			$this->set('var4', $var4);
			$this->set('var5', $var5);
			$this->set('var6', $var6);
			$this->set('var7', $var7);
			$this->set('var8', $var8);
			$this->set('var9', $var9);
			$this->set('var10', $var10);
			
			$isRequestPost= $this->request->is('post');
			$isRequestPut= $this->request->is('put');
			$isRequestGet= $this->request->is('get');
			$isRequestAjax= $this->request->is('ajax');
			
			$plugin= explode('/', $url);
			
			if($routesType=='Plugin'){
				$filename = $urlLocal['urlLocalPlugin'].$plugin[0].'/controller.php';
		        if(file_exists($filename))
		        {
		            include_once($filename);
		            $count= count($plugin)-1;
		            $plugin= explode('.', $plugin[$count]);
		            if(function_exists($plugin[0]))
		            {
			            $input= array('fileProcess'=>$url,'request'=>$this->request);
				        $plugin[0]($input);
		            }elseif(!file_exists($urlLocal['urlLocalPlugin'].$url)){
			        	$this->redirect($urlHomes);
			        }
		        }elseif(!file_exists($urlLocal['urlLocalPlugin'].$url)){
		        	$this->redirect($urlHomes);
		        }
		    }else{

		    	$filename = $urlLocal['urlLocalTheme'].$plugin[0].'/controller.php';
		    
		        if(file_exists($filename))
		        {
		            include_once($filename);
		            $count= count($plugin)-1;
		            $plugin= explode('.', $plugin[$count]);
		            if(function_exists($plugin[0]))
		            {
			            $input= array('fileProcess'=>$url,'request'=>$this->request);
				        $plugin[0]($input);
		            }elseif(!file_exists($urlLocal['urlLocalTheme'].$url)){
			        	$this->redirect($urlHomes);
			        }
		        }elseif(!file_exists($urlLocal['urlLocalTheme'].$url)){
		        	$this->redirect($urlHomes);
		        }
		    }
		}
   }
?>