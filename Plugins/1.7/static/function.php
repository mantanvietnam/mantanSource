<?php
	$menus= array();
	$menus[0]['title']= 'Static';
    $menus[0]['sub'][0]= array('name'=>'Static Setting','classIcon'=>'fa-bar-chart','url'=>$urlPlugins.'admin/static-setting.php','permission'=>'staticSetting');
    addMenuAdminMantan($menus);
    
    function getStatic()
	{
		$today= getdate();
		global $modelOption;
		global $infoSite;
		
		$static= $modelOption->getOption('static');
		
        if(isset($static['Option']['value']['oldMon']) && $today['mon']== $static['Option']['value']['oldMon'])
        {

          $static['Option']['value']['mon'] += 1;

        }
        else
        {

          $static['Option']['value']['oldMon']= $today['mon'];

          $static['Option']['value']['mon'] = 1;

        }



        if(isset($static['Option']['value']['oldMday']) && $today['mday']== $static['Option']['value']['oldMday'])

        {

          $static['Option']['value']['mday'] += 1;

        }

        else

        {

          $static['Option']['value']['oldMday']= $today['mday'];

          $static['Option']['value']['mday'] = 1;

        }


        if(isset($static['Option']['value']['total'])){
        	$static['Option']['value']['total'] += 1;
    	}else{
    		$static['Option']['value']['total'] = 1;
    	}

        $modelOption->saveOption('static',$static['Option']['value']);
        
        return $static;
	}
    
	function showStatic()
	{
		$today= getdate();
		global $modelOption;
		global $infoSite;
        global $urlHomes;
		
		$static= $modelOption->getOption('static');
		$urlPluginStatic= $urlHomes.'/app/Plugin/static/';
		
        if(isset($static['Option']['value']['oldMon']) && $today['mon']== $static['Option']['value']['oldMon'])
        {

          $static['Option']['value']['mon'] += 1;

        }
        else
        {

          $static['Option']['value']['oldMon']= $today['mon'];

          $static['Option']['value']['mon'] = 1;

        }



        if(isset($static['Option']['value']['oldMday']) && $today['mday']== $static['Option']['value']['oldMday'])

        {

          $static['Option']['value']['mday'] += 1;

        }

        else

        {

          $static['Option']['value']['oldMday']= $today['mday'];

          $static['Option']['value']['mday'] = 1;

        }


        if(isset($static['Option']['value']['total'])){
        	$static['Option']['value']['total'] += 1;
    	}else{
    		$static['Option']['value']['total'] = 1;
    	}

        $modelOption->saveOption('static',$static['Option']['value']);
        
        ?>
        <ul>
	          <li>
	            <img width="16" height="16" alt="Đang truy cập" src="<?php echo $urlPluginStatic;?>images/users.png">
	            Đang truy cập : <strong><?php echo rand(1,$static['Option']['value']['mday']);?></strong>
	          </li>
	      
	          <li>
	            <img width="16" height="16" alt="Hôm nay" src="<?php echo $urlPluginStatic;?>images/today.png">
	            Hôm nay : <strong><?php echo $static['Option']['value']['mday'];?></strong>
	          </li>
	    
	          <li>
	            <img width="16" height="16" alt="Tháng hiện tại" src="<?php echo $urlPluginStatic;?>images/month.png">
	            Tháng hiện tại : <strong><?php echo $static['Option']['value']['mon'];?></strong>
	          </li>
	    
	          <li>
	            <img width="16" height="16" alt="Tổng lượt truy cập" src="<?php echo $urlPluginStatic;?>images/hits.png">
	            Tổng lượt truy cập : <strong><?php echo $static['Option']['value']['total'];?></strong>
	          </li>

        </ul>
        <?php
	}
?>