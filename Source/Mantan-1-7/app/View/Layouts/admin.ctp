<?php global $infoMantanSource;?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
		Mantan System <?php echo ' | '.$userAdmins['Admin']['infoSite']['title'];?>
	</title>
	<link rel="shortcut icon" href="/app/webroot/images/favicon.png">
	
    <!-- Core CSS - Include with every page -->
    <link href="/app/webroot/css/bootstrap.min.css" rel="stylesheet">
    <link href="/app/webroot/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="/app/webroot/css/sb-admin.css" rel="stylesheet">
    
    <!-- JS -->
    <script type="text/javascript" src="/app/webroot/js/jquery-1.7.2.min.js"></script>
    <script src="/app/webroot/js/jquery.lightbox_me.js" type="text/javascript" charset="utf-8"></script>

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Mantan navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a target="_blank" class="navbar-brand" href="<?php echo @$infoMantanSource['web'];?>">
                	Mantan Admin <?php echo @$infoMantanSource['verName'];?>
                	<?php
						if(isset($_SESSION['checkVerMantan'])){
							$checkVerMantan= $_SESSION['checkVerMantan'];
						}else{
							if(isset($infoMantanSource['webCheckVer'])){
								$checkVerMantan= @simplexml_load_file($infoMantanSource['webCheckVer']);
								$checkVerMantan = json_decode(json_encode($checkVerMantan), true);
								$_SESSION['checkVerMantan']= $checkVerMantan;
							}else{
								$checkVerMantan= null;
							}
						}
	                	
	                	if($checkVerMantan){
		                	$newVer= (int) $checkVerMantan['ver'];
		                	$oldVer= (int) $infoMantanSource['ver'];
		                	if($newVer > $oldVer)
		                	{
			                	echo "( new ".$checkVerMantan['verName']." )";
		                	}
	                	}
                	?>
                </a>
                <?php
	                if(isset($infoSite['Option']['value']['title']))
	                {
		                echo '<a target="_blank" class="navbar-brand" href="'.$urlHomes.'">'.$infoSite['Option']['value']['title'].'</a> ';
	                }
                ?>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo $urlAdmins.'account/'.$userAdmins['Admin']['id'];?>"><i class="fa fa-user fa-fw"></i> <?php echo $languageMantan['changePassword'];?></a>
                        </li>
                        <li><a href="<?php echo $urlOptions.'infoSite';?>"><i class="fa fa-gear fa-fw"></i> <?php echo $languageMantan['setting'];?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $urlAdmins.'logout';?>"><i class="fa fa-sign-out fa-fw"></i> <?php echo $languageMantan['logout'];?></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php
                        	global $hookMenuAdminMantan;
		                    //var_dump($hookMenuAdminMantan);
		                    $urlNowLoction= explode('?', $urlNow);
		                    $urlNowLoction= $urlNowLoction[0];
		                    foreach($hookMenuAdminMantan as $menus)
							{
								echo '<li class="title">'.$menus['title'].'</li>';
								if(isset($menus['sub']) && count($menus['sub'])>0){
									foreach($menus['sub'] as $menu)
									{
										if(!isset($menu['classIcon'])) $menu['classIcon']= 'fa-files-o fa-fw';
										if(isset($userAdmins['Admin']['powers']) && in_array($menu['permission'], $userAdmins['Admin']['powers']))
										{
											if(!isset($menu['sub']) || count($menu['sub'])==0)
											{
												if($urlNowLoction!=$menu['url'])
												{
													$class= '';
												}
												else
												{
													$class= 'active';
												}
												
												echo '  <li class="'.$class.'">
									                        <a href="'.$menu['url'].'"><i class="fa '.$menu['classIcon'].'"></i> '.$menu['name'].'</a>
									                    </li>';
											}
											else
											{
												$class='';
												if($menu['url']==$urlNowLoction)
												{
													$class= 'active';
												}
												else
												{
													foreach($menu['sub'] as $subMenu)
													{
														if($urlNowLoction==$subMenu['url'])
														{
															$class= 'active';
															break;
														}
													}
												}
												
												
												if($class==''){
													$classSub= 'collapse';
												}else{
													$classSub= '';
												}
												
												echo ' <li class="'.$class.'">
									                        <a href="'.$menu['url'].'"><i class="fa '.$menu['classIcon'].'"></i> '.$menu['name'].'<span class="fa arrow"></span></a>';
									                        if(isset($menu['sub']) && count($menu['sub'])>0){
										                        echo '<ul class="nav nav-second-level '.$classSub.'">';
										                        foreach($menu['sub'] as $sub)
										                        {
										                        	if(in_array($sub['permission'], $userAdmins['Admin']['powers']))
																	{
											                        	if($urlNowLoction==$sub['url'])
																		{
																			$classSub= 'activeSub';
																		}
																		else
																		{
																			$classSub= '';
																		}
																		
											                        	echo '  <li class="'.$classSub.'">
													                                <a href="'.$sub['url'].'">'.$sub['name'].'</a>
													                            </li>';
													                }
										                        }
																echo '</ul>';
									            			}
									            echo '</li>';
											}
										}
									}
								}
							}
	                    ?>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <?php echo $this->Session->flash(); ?>
	    	<?php echo $this->fetch('content'); ?>
	    	<?php //echo $this->element('sql_dump'); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="/app/webroot/js/bootstrap.min.js"></script>
    <script src="/app/webroot/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <!-- Page-Level Plugin Scripts - Blank -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="/app/webroot/js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Blank - Use for reference -->

</body>

</html>
