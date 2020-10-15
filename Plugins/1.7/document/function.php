<?php
	$menus= array();
	$menus[0]['title']= 'Document';
    $menus[0]['sub'][0]= array('name'=>'List Document','classIcon'=>'fa-list-alt','url'=>$urlPlugins.'admin/document-view-listDocument.php','permission'=>'listDocument');
    $menus[0]['sub'][1]= array('name'=>'List Category','classIcon'=>'fa-users','url'=>$urlPlugins.'admin/document-view-categoryDocument.php','permission'=>'categoryDocument');
    
    
    addMenuAdminMantan($menus);

    global $modelOption;
    // $modelOption= new Option();
    $documentCategory= $modelOption->getOption('documentCategory');
    // echo "<pre>";
    // print_r($documentCategory);
    // echo "</pre>";die;
    $category= array();
    if(!empty($documentCategory['Option']['value']['allData'])){
        $category= array(array( 'title'=>'Document',
            'sub'=>changeTypeCategoryDoc($documentCategory['Option']['value']['allData'],'/document/')
            )
    );
    }
    

	addMenusAppearance($category);

	function changeTypeCategoryDoc($category,$link)
	{
		foreach($category as $key=>$cat)
        {
        	$category[$key]= array  ( 'url' => $link.$cat['slug'].'.html',
								      'name' => $cat['name']
								    );
		    if (isset($cat['sub'])) {
		    	if(count($cat['sub'])>0)
			    {
			    	$category[$key]['sub']= changeTypeCategory($cat['sub'],$link);
			    }
		    }
        }
        return $category;
	}

	function showListDocument($limit,$conditions)
	{
		global $urlHomes;
		global $infoSite;
		global $modelOption;
		$modelDocument= new Document();
		$listDocument= $modelDocument->getPage(1,$limit,$conditions);
		return $listDocument;
	}
    
    function getUrlCategoryDocument($slug){
    	global $urlHomes;
    	if(!empty($slug)){
    		return $urlHomes.'document/'.$slug.'.html';
    	}
    	
    }
	function showDocument()
	{
		global $modelOption;
		
		$listData= $modelOption->getOption('document');
		$listDataCategory= $modelOption->getOption('documentCategory');
		
		foreach($listData['Option']['value']['allData'] as $components)
		{
			if(!$category[ $components['category'] ])
			{
				$category[ $components['category'] ]= array();
			}
			array_push($category[ $components['category'] ], $components);
		}
		
		foreach($category as $key=>$components)
	    {
	    	echo '<script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>';
	    	echo '<div class="col2 support-yahoo">
	    			  <ul class="supportHead">
	    			  	  <li class="title"><h5>'.$listDataCategory['Option']['value']['allData'][ $key ]['name'].'</h5></li>';
			    		  foreach($components as $support)
			    		  {
				    		  echo '<li>';
				    		  if($support['typeNick']=='yahoo'){ 
				    		  ?>
				    		  
		                      <a href="ymsgr:sendim?<?php echo $support['nick'];?>">
		                          <img class="img-responsive" border="0" src="http://opi.yahoo.com/online?u=<?php echo $support['nick'];?>&amp;m=g&amp;t=<?php echo $support['style'];?>">
		                      </a>
		                      <?php }else if($support['typeNick']=='skype'){ ?>
		                        <a href="Skype:<?php echo $support['nick'];?>?chat"> 
		                        	<img src="http://mystatus.skype.com/bigclassic/<?php echo $support['nick'];?>" title="Skype Support" width="100%" alt=""> 
		                        </a>
		                      <?php }
		                      
				    		  echo '
				    		  </li>';
			    		  }
	    	echo '    </ul>
	    		  </div>';
	    } 
	}
?>