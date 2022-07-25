<!DOCTYPE html>
<html class="fixed">
<head>
  <!-- Basic -->
  <meta charset="UTF-8"/>
  <title>Quản lý quay số trúng thưởng</title>
  <link rel="shortcut icon" href="/app/Plugin/quayso/view/manager/img/logoQuaySo.png" type="image/x-icon">
  
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Web Fonts  -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css"/>

  <!-- CSS ManagerListOrderProcess -->

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/font-awesome.css" />
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/magnific-popup.css" />
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/select2.css" />
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/datatables.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  

  <!-- Specific Page Vendor CSS -->
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/jquery-ui-1.10.4.custom.css" />
  <!-- <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/bootstrap-multiselect.css" /> -->
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/morris.css" />

  <!-- Theme CSS -->
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/theme.css" />

  <!-- Skin CSS -->
  <!-- <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/default.css" /> -->

  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/default.css" />
  <link href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/menu.css " rel="stylesheet"/>

  <!-- Responsive -->
  <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/responsive.css" />

  <!-- Head Libs -->
 
  <link href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager/css/style.css'; ?>" rel="stylesheet"/>
  <link href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager/css/style_d.css'; ?>" rel="stylesheet"/> 
  <link rel='stylesheet prefetch' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'/>
  
  <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/modernizr.js"></script>
  <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager/js/script.js' ; ?>"></script>
  <script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

</head>
<body>
 <section class="body">
  <div class="header_m">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1">
          <div class="h_logo">
            <a href="/">
              <img src="/app/Plugin/quayso/view/manager/img/logoQuaySo.png" width="36" alt="" />
            </a>
          </div>
        </div>
        <div class="col-md-9" style="padding-left:0; padding-right:0;">
          <div id='cssmenu'>
            <ul>
              <?php
              $menuSidebar= getMenuSidebarLeftManager();
              $stringMenuMobile= '';
              foreach($menuSidebar as $menu){
                if(empty($menu['sub'])){
                  echo '<li><a target="'.@$menu['target'].'" href="'.$menu['link'].'"><i class="fa '.$menu['icon'].'"></i> '.$menu['name'].'</a></li>';
                  $stringMenuMobile .= '<li><a target="'.@$menu['target'].'"  href="'.$menu['link'].'"> <i class="fa '.$menu['icon'].'"></i>  '.$menu['name'].'</a></li>';
                }else{
                  $check= false;
                  if(!empty($menu['sub'])){
                    $check= true;
                  }
                  
                  if($check){
                    $active= (empty($permission) || !in_array($permission, $menu['active']))?'':'active';
                    echo '  <li class="'.$active.' has-sub"><a href="javascript:void(0)" > <i class="fa '.$menu['icon'].'"></i>  '.$menu['name'].'</a>
                    <ul>';
                    $stringMenuMobile .= '<li class="h_sub '.$active.'"><a href="javascript:void(0)"> <i class="fa '.$menu['icon'].'"></i>  '.$menu['name'].'</a><ul class="list-unstyled m_sub">';
                    foreach($menu['sub'] as $sub){
                      if(empty($sub['sub'])){
                        echo '<li><a target="'.@$sub['target'].'"  href="'.$sub['link'].'"> <i class="fa '.$sub['icon'].'"></i>  '.$sub['name'].'</a></li>';
                        $stringMenuMobile .= '<li><a target="'.@$sub['target'].'"  href="'.$sub['link'].'"><i class="fa '.$sub['icon'].'"></i>  '.$sub['name'].'</a></li>';
                      }else{
                        echo '  <li class="has-sub"><a target="'.@$sub['target'].'"  href="'.$sub['link'].'"> <i class="fa '.$sub['icon'].'"></i>  '.$sub['name'].'</a>
                          <ul>';
                        $stringMenuMobile .= '<li class="h_sub"><a target="'.@$sub['target'].'"  href="'.$sub['link'].'"> <i class="fa '.$sub['icon'].'"></i>  '.$sub['name'].'</a><ul class="list-unstyled m_sub">';

                        foreach($sub['sub'] as $menusub){
                          echo '<li><a target="'.@$menusub['target'].'"  href="'.$menusub['link'].'"> <i class="fa '.$menusub['icon'].'"></i>  '.$menusub['name'].'</a></li>';
                          $stringMenuMobile .= '<li><a target="'.@$menusub['target'].'"  href="'.$menusub['link'].'"> <i class="fa '.$menusub['icon'].'"></i>  '.$menusub['name'].'</a></li>';
                        }
                        echo        '</ul>
                        </li>';
                        $stringMenuMobile .= '</ul></li>';
                      }

                    }
                    echo  '   </ul>
                    </li>';
                    $stringMenuMobile .= '</ul></li>';
                  }
                }
              }
              ?>
            </ul>
          </div>
        </div>
        <div class="col-sm-2 col-md-2">



        </div>
      </div>

    </div>


  </div>



  <div class="menu_mobile">
    <ul class="list-unstyled">
      <?php echo $stringMenuMobile;?>
    </ul>
  </div>


  

  <div class="icon_mb">
    <i class="fa fa-bars"></i>
  </div>


  <script>
    $(document).ready(function() {

      var dem=0;
      $('.has_sub a').click(function(){
        $(this).next('.menu_sub').slideToggle();

      });$('.has_sub1 a').click(function(){
        $(this).next('.menu_sub1').slideToggle();
      });

      if($(window).innerWidth()<=768){
        var dem=0, dem1=0;
        $('.has_sub.ab').click(function(){
          dem++;
          if(dem%2!=0){
            $(this).css({'box-shadow': '0 1px 5px 0 rgba(0,0,0,0.2),0 4px 4px 0 rgba(0,0,0,0.19) '});
          } else{
            $(this).css({'box-shadow': 'none'});
          }

        });
        $('#cssmenu').css({'box-shadow': '0 1px 5px 0 rgba(0,0,0,0.2),0 4px 4px 0 rgba(0,0,0,0.19) '});
      }

      if($(window).innerWidth()<1200){
        $('.icon_mb').click(function(){
          $('.menu_mobile').slideToggle();
        });

        // $('.icon_mb').show();
        // $('#cssmenu').css({'display': 'none'});
        // $('.h_account').css({'right': '48px'});
        // $('.header_m').css({'height': '48px'});
      }

      $('.h_sub a').click(function(){
        if($(this).next('.m_sub').hasClass('open')){
          $(this).next('.m_sub').slideUp();
          $(this).next('.m_sub').removeClass('open');
        } else{
          $(this).next('.m_sub').slideDown();
          $(this).next('.m_sub').addClass('open');
        }
      });



    });

    // jQuery(function($){
    //   var windowWidth = $(window).width();
    //   var windowHeight = $(window).height();

    //   $(window).resize(function() {
    //     if(windowWidth != $(window).width() || windowHeight != $(window).height()) {
    //       location.reload();
    //       return;
    //     }
    //   });
    // });
  </script>  