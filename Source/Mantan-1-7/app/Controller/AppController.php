<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

include('MantanFunctions.php');

App::uses('Controller', 'Controller');
App::uses('ConnectionManager', 'Model');
App::uses('ExportsController', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    var $helpers = array('Session','Paginator');
    
    function isDBConnected()
    {
    	//Configure::write('debug', 2);
        $datasource = ConnectionManager::getDataSource('default');
        if($datasource->config['database']!='') return true;
        else return false;
    } 
	    
    function getUrlLocal()
    {
    	//Configure::write('debug', 2);
    	$urlBase= ($this->webroot=='/')?getDomainUrl():getDomainUrl().$this->webroot;
    	$urlBase= str_replace('/app/webroot/', '', $urlBase);
    	
    	$url['urlHomes']= $urlBase;
    	$url['urlAdmins']= $urlBase.'admins/';
    	$url['urlOptions']= $urlBase.'options/';
    	$url['urlNotices']= $urlBase.'notices/';
    	$url['urlAlbums']= $urlBase.'albums/';
    	$url['urlPlugins']= $urlBase.'plugins/';
    	$url['urlVideos']= $urlBase.'videos/';
		$url['urlUsers']= $urlBase.'users/';
    	$url['webRoot']= $this->webroot;
         
	 	if(@file_exists('../Config/database.php')){
        	$url['urlLocalPlugin']= '../Plugin/';
        	$url['urlLocalTheme']= '../Theme/';
        	$url['urlLocalLanguage']= '../Language/';
        	$url['urlLocalWebroot']= '../webroot/';
        }else{
            $url['urlLocalPlugin']= 'app/Plugin/';
            $url['urlLocalTheme']= 'app/Theme/';
            $url['urlLocalLanguage']= 'app/Language/';
            $url['urlLocalWebroot']= 'app/webroot/';
        }

        return $url;
    }
         
     function setup($notCheckDomain= false)
     {    
     	  //Configure::write('debug', 2);
     	  
     	  if($this->isDBConnected())
     	  {
     	  	  $datasource = ConnectionManager::getDataSource('default');

     	  	  if($datasource->isConnected()){
		          global $urlAdmins;
				  global $urlOptions;
				  global $urlNotices;
				  global $urlAlbums;
				  global $urlPlugins;
				  global $urlVideos;
				  global $urlUsers;
				  global $urlHomes;
				  global $urlNow;
				  global $urlThemeActive;
				  global $urlLocalThemeActive;
				  global $urlLocal;
				  global $webRoot;
				  global $infoSite;
				  global $contactSite;
				  global $smtpSite;
				  
				  global $metaTitleMantan;
				  global $metaKeywordsMantan;
				  global $metaDescriptionMantan;
				  
				  global $routesPlugin;
				  global $userAdmins;
				  
				  global $hookMenuAdminMantan;
				  global $infoMantanSource;

				  global $dataInput;
				  global $modelOption;
			      global $modelNotice;
			      global $modelAlbum;
			      global $modelAdmin;
			      global $modelVideo;
				  global $modelUser;
			      
			      Controller::loadModel('Option');
			      Controller::loadModel('Notice');
			      Controller::loadModel('Album');
			      Controller::loadModel('Admin');
			      Controller::loadModel('Video');
				  Controller::loadModel('User');
			      
			      $modelOption= new Option();
			      $modelNotice= new Notice();
			      $modelAlbum= new Album();
			      $modelAdmin= new Admin();
			      $modelVideo= new Video();
				  $modelUser= new User();

				  $dataInput= $this->request;
				  
	              $userAdmins= $this->Session->read('infoAdminLogin');
	              $userHome= $this->Session->read('infoUserLogin');
	              
	              $infoSite= $this->Option->getOption('infoSite');
	              $smtpSite= $this->Option->getOption('smtpSetting');
	              
	              if(!isset($infoSite['Option']['value']['domain']) && !$notCheckDomain)
	              {
	              	  $this->redirect(array('controller' => 'options', 'action' => 'infoSite'));
	              }
	              
	              $language= $this->Option->getOption('language');
	              $infoSite['Option']['value']['language']= $language['Option']['value'];
	              $urlLocal= $this->getUrlLocal();
	              
	              $metaTitleMantan= (isset($infoSite['Option']['value']['title']))?$infoSite['Option']['value']['title']:'';
	              $metaKeywordsMantan= (isset($infoSite['Option']['value']['key']))?$infoSite['Option']['value']['key']:'';
	              $metaDescriptionMantan= (isset($infoSite['Option']['value']['description']))?$infoSite['Option']['value']['description']:'';
	              
	              $this->layout= 'admin';
	              
	
	              $this->set('userAdmins', $userAdmins);
	              $this->set('userHomes', $userHome);
	              
	              $plugins= $this->Option->getOption('plugins');
				  if(!isset($plugins['Option']['value'])){
					  $plugins['Option']['value']= array();
				  }
	              $this->set('menuPlugins', $plugins['Option']['value']);
	              
	              if(!empty($_GET['themeActive'])){
	              	$_SESSION['themeActive']= $_GET['themeActive'];
	              }
	              
	              if(empty($_SESSION['themeActive'])){
	              	$themeActive= $this->Option->getOption('theme');
	              	$_SESSION['themeActive']= $themeActive['Option']['value'];
	              }
	              
	              $themeActive['Option']['value']= $_SESSION['themeActive'];
	         
	              $this->set('themeActive', $urlLocal['urlLocalTheme'].$themeActive['Option']['value'].'/' );
	              
	              
	              $this->set('infoSite', $infoSite);
	              
	              $contactSite= $this->Option->getOption('contact');
	              $this->set('contactSite', $contactSite);
	              
	            
	              include($urlLocal['urlLocalLanguage'].'/'.$language['Option']['value']['file']);
	              $this->set('languageMantan', $languageMantan );
	              
	              $urlNow= curPageURL(1);
	              $urlAdmins= $urlLocal['urlAdmins'];
	              $urlOptions= $urlLocal['urlOptions'];
	              $urlNotices= $urlLocal['urlNotices'];
	              $urlAlbums= $urlLocal['urlAlbums'];
	              $urlPlugins= $urlLocal['urlPlugins'];
	              $urlVideos= $urlLocal['urlVideos'];
	              $urlHomes= $urlLocal['urlHomes'];
				  $urlUsers= $urlLocal['urlUsers'];
	              
	              $urlThemeActive= $urlLocal['urlHomes'].'app/Theme/'.$themeActive['Option']['value'].'/';
	              $urlLocalThemeActive= $urlLocal['urlLocalTheme'].$themeActive['Option']['value'].'/';
	              $webRoot= $urlLocal['webRoot'];
	              
	              $this->set('urlLocal', $urlLocal );
	              $this->set('urlNow', $urlNow );
	              $this->set('urlAdmins', $urlAdmins );
	              $this->set('urlOptions', $urlOptions );
	              $this->set('urlNotices', $urlNotices );
	              $this->set('urlAlbums', $urlAlbums );
	              $this->set('urlPlugins', $urlPlugins );
	              $this->set('urlVideos', $urlVideos );
				  $this->set('urlUsers', $urlUsers );
	              $this->set('urlHomes', $urlHomes );
	              $this->set('urlThemeActive', $urlThemeActive );
	              $this->set('urlLocalThemeActive', $urlLocalThemeActive );
	              $this->set('webRoot', $webRoot );
	              
	              
	              foreach($plugins['Option']['value'] as $plugin)
				  {
				  	  $filename = $urlLocal['urlLocalPlugin'].'/'.$plugin.'/routes.php';
					  if (file_exists($filename))
					  {
						  include($filename);
					  }

					  $filename = $urlLocal['urlLocalPlugin'].'/'.$plugin.'/model.php';
					  if (file_exists($filename))
					  {
						  include($filename);
					  }

					  $filename = $urlLocal['urlLocalPlugin'].'/'.$plugin.'/function.php';
					  if (file_exists($filename))
					  {
						  include($filename);
					  }
				  }
				   
				  $filename = $urlLocal['urlLocalTheme'].'/'.$themeActive['Option']['value'].'/function.php';
			      if (file_exists($filename))
			      {
			          include($filename);
			      }

			      $filename = $urlLocal['urlLocalTheme'].'/'.$themeActive['Option']['value'].'/routes.php';
				  if (file_exists($filename))
				  {
					  include($filename);
				  }
                  
			      
                  if($this->Session->check('infoMantanLoc')){
                    $infoMantanSource= $this->Session->read('infoMantanLoc');
                  }else{
                    $infoMantanSource= @simplexml_load_file($webRoot.'/info.xml');
                    $infoMantanSource = json_decode(json_encode($infoMantanSource), true);
                    if(isset($infoMantanSource['verName'])){
                        $this->Session->write('infoMantanLoc',$infoMantanSource);
                    }
                  }
			      
			        if(!is_array($hookMenuAdminMantan)) $hookMenuAdminMantan= array();
                        	
	            	$menus= array();
	            	$menus['title']= $languageMantan['system'];
	                $menus['sub'][0]= array( 'name'=>$languageMantan['setting'],'url'=>$urlOptions.'infoSite','classIcon'=>'fa-wrench','permission'=>'infoSite');
	                $menus['sub'][1]= array( 'name'=>$languageMantan['news'],
			                				 'url'=>$urlNotices.'listNotices',
			                				 'classIcon'=>'fa-newspaper-o',
			                				 'permission'=>'listNotices',
			                				 'sub'=>array( array('name'=>$languageMantan['allPosts'],'url'=>$urlNotices.'listNotices','permission'=>'listNotices'),
			                							   array('name'=>$languageMantan['newsCategories'],'url'=>$urlOptions.'categoryNotice','permission'=>'categoryNotice')
			                							) 
			                			   );
	                $menus['sub'][2]= array('name'=>$languageMantan['pages'],'url'=>$urlNotices.'listPages','classIcon'=>'fa-file-o','permission'=>'listPages');
	                $menus['sub'][3]= array('name'=>$languageMantan['album'],'url'=>$urlAlbums.'listAlbums','classIcon'=>'fa-camera-retro','permission'=>'listAlbums');
	                $menus['sub'][4]= array('name'=>$languageMantan['video'],'url'=>$urlVideos.'listVideos','classIcon'=>'fa-file-video-o','permission'=>'listVideos');
	                $menus['sub'][5]= array('name'=>$languageMantan['fileManagement'],'url'=>$urlAdmins.'listFiles','classIcon'=>'fa-file-archive-o','permission'=>'listFiles');
	                
	                $menus['sub'][6]= array('name'=>$languageMantan['languages'],'url'=>$urlOptions.'languages','classIcon'=>'fa-language','permission'=>'languages');
	                $menus['sub'][7]= array( 'name'=>$languageMantan['appearance'],
			                				 'url'=>$urlOptions.'themes',
			                				 'classIcon'=>'fa-file-image-o',
			                				 'permission'=>'themes',
			                				 'sub'=>array( array('name'=>$languageMantan['interfaceStorage'],'url'=>$urlOptions.'themes','permission'=>'themes'),
			                							   array('name'=>$languageMantan['menu'],'url'=>$urlOptions.'menus','permission'=>'menus')
			                							) 
			                			   );
	                $menus['sub'][8]= array('name'=>$languageMantan['expand'],'url'=>$urlOptions.'plugins','classIcon'=>'fa-arrows-alt','permission'=>'plugins');
	                $menus['sub'][9]= array('name'=>'Site map','url'=>$urlOptions.'sitemap','classIcon'=>'fa-sitemap','permission'=>'sitemap');
					$menus['sub'][10]= array('name'=>$languageMantan['userList'],'url'=>$urlUsers.'listUser','classIcon'=>'fa-users','permission'=>'listUser');
	                $menus['sub'][11]= array('name'=>$languageMantan['account'],'url'=>$urlAdmins.'listAccount','classIcon'=>'fa-user-secret','permission'=>'listAccount');
	                $menus['sub'][12]= array('name'=>$languageMantan['logout'].' ['.$userAdmins['Admin']['user'].']','url'=>$urlAdmins.'logout','classIcon'=>'fa-sign-out','permission'=>'logout');
	                
	                			   
	                $hookMenuAdminMantan= array_merge(array($menus),$hookMenuAdminMantan);
	            }else{
	            	$this->redirect(array('controller' => 'homes', 'action' => 'index'));
	            }
          }
          else
          {
              $this->redirect(array('controller' => 'admins', 'action' => 'installMantan'));
          }
     }
     
     function sendDataPost($url,$data)
     {
        $options = array('http' => array(
				        				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				        				'method'  => 'POST',
				        				'content' => http_build_query($data),
				        			   )
				        );
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		return $result;
     }
}
?>