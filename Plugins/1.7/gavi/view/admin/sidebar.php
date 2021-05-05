<?php
  $modelEmail= new Email();
  $conditionsAgency=array();
  $conditionsAgency['type']='agency';
  $conditionsAgency['listView']= array('$nin'=>array($_SESSION['infoStaff']['Staff']['id']));
  $numberAgency= $modelEmail->find('count',array('conditions' => $conditionsAgency));

  $conditionsSystem=array();
  $conditionsSystem['type']= 'system';
  $conditionsSystem['idAgency']= '';
  $conditionsSystem['listView']= array('$nin'=>array($_SESSION['infoStaff']['Staff']['id']));
  $numberSystem= $modelEmail->find('count',array('conditions' => $conditionsSystem));
?>
<div class="left_col scroll-view">
  <div class="navbar nav_title" style="border: 0;">
    <a href="" class="site_title"><i class="fa fa-paw"></i><span class="company-name"> GAVI</span></a>
  </div>
  <div class="clearfix"></div>
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <ul class="nav side-menu" style="">
        <li>
          <a href="/listMail?type=system"><i class="fa fa-home"></i>Trang chủ</a>                    
        </li>
        <li class="">
          <a href="javascript:void(0)"><i class="fa fa-shopping-cart"></i>Sản phẩm<span class="fa fa-chevron-down"></span></a>                        
          <ul class="nav child_menu">
            <li class="current-page"><a href="/listProduct"><i class="fa fa-shopping-basket"></i>Danh sách sản phẩm</a></li>
            <li><a href="/listCategory"><i class="fa fa-sliders"></i>Danh mục sản phẩm</a></li>
          </ul>
        </li>

        
        <li class="">
          <a href="javascript:void(0)"><i class="fa fa-user-secret"></i>Đại lý<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="/listAgency"><i class="fa fa-users"></i>Danh sách đại lý</a></li>
            <li><a href="/addAgency"><i class="fa fa-user-plus" aria-hidden="true"></i>Thêm mới đại lý</a></li>
            <li><a href="/requestUpdateLevel"><i class="fa fa-upload" aria-hidden="true"></i>Yêu cầu nâng cấp</a></li>
          </ul>
        </li>
        <li class="">
          <a href="javascript:void(0)"><i class="fa fa-th-large"></i>Giao dịch<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            
            <li><a href="/historyExchange"><i class="fa fa-bookmark-o" aria-hidden="true"></i>Lịch sử giao dịch</a></li>
            <li><a href="/drawMoney"><i class="fa fa-google-wallet" aria-hidden="true"></i>Rút tiền</a></li>
            <li><a href="/notificationPay"><i class="fa fa-bell" aria-hidden="true"></i>Thông báo nạp tiền</a></li>
          </ul>
        </li>
        <li><a href="/listWarehouse"><i class="fa fa-map" aria-hidden="true"></i>Kho hàng</a></li>
        <li>
          <a href="/listOrderAdmin"><i class="fa fa-file-text"></i>Đơn hàng</a>
        </li>
        <li>
          <a href="/listShipAdmin"><i class="fa fa-truck"></i>Đơn vận chuyển</a>
        </li>

        <li class="">
          <a href="javascript:void(0)"><i class="fa fa-envelope-o"></i>Hộp thư<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="/listMail"><i class="fa fa-envelope-o"></i>Hộp thư đi</a></li>
            <li><a href="/listMail?type=agency"><i class="fa fa-envelope-o"></i>Thư từ đại lý (<?php echo number_format($numberAgency); ?>)</a></li>
            <li><a href="/listMail?type=system"><i class="fa fa-envelope-o"></i>Thư từ hệ thống (<?php echo number_format($numberSystem); ?>)</a></li>
          </ul>
        </li>

        <li>
          <a href="/listStaffAgency"><i class="fa fa-user"></i>Nhân viên</a>
        </li>
      </ul>
    </div>
  </div>
</div>