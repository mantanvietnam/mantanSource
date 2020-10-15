<div class="inner-wrapper">
    <!-- start: sidebar -->
    <aside id="sidebar-left" class="sidebar-left">

        <div class="sidebar-header">
            <div class="sidebar-title">
                Menu
            </div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <div class="nano">
            <div class="nano-content">
                <nav id="menu" class="nav-main" role="navigation">
                    <ul class="nav nav-main">
                        <li class="">
                            <a href="<?php echo $urlHomes . 'homeManager';?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>
                        <?php
                            $menuSidebar= getMenuSidebarLeftManager();
                            $urlCheck= explode('?',$urlNow);
                            $urlCheck= $urlCheck[0];
                            $hrefManager= 'href="'.$urlHomes.'homeManager"';
                            
                            foreach($menuSidebar as $menu){
                                $checkMenuPermission= false;
                                if(!isset($menu['permission'])){
                                    if(!empty($menu['sub'])){
                                        foreach($menu['sub'] as $sub){
                                            if(!$_SESSION['infoManager']['Manager']['isStaff'] || in_array($sub['permission'],$_SESSION['infoManager']['Manager']['check_list_permission'])){
                                                $checkMenuPermission= true;
                                                break;
                                            }
                                        }
                                    }
                                }elseif(!$_SESSION['infoManager']['Manager']['isStaff'] || in_array($menu['permission'],$_SESSION['infoManager']['Manager']['check_list_permission'])){
                                    $checkMenuPermission= true;
                                }
                                
                                if($checkMenuPermission){
                                    if($menu['link']!=''){
                                        $href= 'href="'.$menu['link'].'"';
                                    }else{
                                        $href= '';
                                    }
                                    
                                    if(!empty($menu['sub'])){
                                        $class="nav-parent";
                                        
                                        foreach($menu['sub'] as $sub){
                                            if($sub['link']==$urlCheck){
                                                $class.= ' nav-expanded';
                                                break;
                                            }    
                                        }
                                    }else{
                                        $class="";
                                        
                                        if($menu['link']==$urlCheck){
                                                $class= 'nav-active';
                                        } 
                                    }
                                    
                                    echo '  <li class="'.$class.'">';
                                    if(!$_SESSION['infoManager']['Manager']['isStaff'] 
                                        || $href=='' 
                                        || $href==$hrefManager
                                        || (isset($menu['permission']) && in_array($menu['permission'],$_SESSION['infoManager']['Manager']['check_list_permission']))){
                                        echo    '<a '.$href.'>
                                                    <i class="fa '.@$menu['icon'].'" aria-hidden="true"></i>
                                                    <span>'.@$menu['name'].'</span>
                                                </a>';
                                    }
                                    if(!empty($menu['sub'])){
                                        echo '<ul class="nav nav-children">';
                                        foreach($menu['sub'] as $sub){
                                            if($sub['link']==$urlCheck){
                                                $classSub= 'nav-active';
                                            } else{
                                                $classSub= '';
                                            }
                                            
                                            if(!$_SESSION['infoManager']['Manager']['isStaff'] || in_array($sub['permission'],$_SESSION['infoManager']['Manager']['check_list_permission'])){
                                                echo '  <li class="'.$classSub.'">
                                                            <a href="'.@$sub['link'].'">'.@$sub['name'].'</a>
                                                        </li>';
                                            }
                                        }
                                        echo '</ul>';
                                    }
                                    
                                    echo '</li>';
                                }
                            }
                        ?>
                    </ul>
                </nav>
            </div>

        </div>

    </aside>
    <!-- end: sidebar -->