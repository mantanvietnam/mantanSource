<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic|Roboto+Slab:400,700|Inconsolata:400,700&subset=latin,cyrillic'
      rel='stylesheet' type='text/css'>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager/'; ?>css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager/'; ?>js/jquery.contextMenu.min.js" type="text/javascript"></script>
<script src="http://swisnl.github.io/jQuery-contextMenu/js/main.js" type="text/javascript"></script>

<script type="text/javascript">
    var urlPaid = "<?php echo $urlHomes; ?>managerCheckout";
    var urlEdit = "<?php echo $urlHomes; ?>managerAddRoom";
    var urlClear = "<?php echo $urlHomes; ?>managerClearRoom";
    var urlDelete = "<?php echo $urlHomes; ?>managerDeleteRoom";
    var urlReport = "<?php echo $urlHomes; ?>managerAddReportRoom";
    var urlEditcost = "http://";
    var urlChangeroom = "<?php echo $urlHomes; ?>managerChangRoom";
    var urlAddservice = "<?php echo $urlHomes; ?>managerAddServiceRoom";
    var urlCreatebill = "";
    var urlReceived = "<?php echo $urlHomes; ?>managerCheckin";
    var urlCancel = "<?php echo $urlHomes; ?>managerCancelCheckin";
    var url;
    var urlAddroom = "<?php echo $urlHomes; ?>managerAddRoom";
    var urlEditFloor = "<?php echo $urlHomes; ?>managerAddFloor";
    var urlNow = "<?php echo $urlNow; ?>";
    var urlListwaiting = "<?php echo $urlHomes; ?>managerListWaiting";
    var urlViewroomdetail = "<?php echo $urlHomes; ?>managerViewRoomDetail";
    var urlPay = "<?php echo $urlHomes; ?>managerPrepay";

    $(function () {
        // lựa chọn đã có người chuột phải
        $.contextMenu({
            selector: '.context-menu-one',
            callback: function (key, options) {
                switch (key) {
                    case 'paid':
                        url = urlPaid + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'cancel':
                        cancelData(options.$trigger.attr("idroom"));
                        break;
                    case 'changeroom':
                        changRoom(options.$trigger.attr("idroom"));
                        break;
                    case 'addservice':
                        url = urlAddservice + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'view':
                        url = urlViewroomdetail + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'report':
                        url = urlReport + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'pay':
                        url = urlPay + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                        
                }
            },
            items: {
                "paid": {name: "Trả phòng", icon: "checkout"},
                "cancel": {name: "Hủy checkin", icon: "delete"},
                "changeroom": {name: "Chuyển phòng", icon: "change"},
                "addservice": {name: "Thêm Hàng hóa - Dịch vụ", icon: "add"},
                "view": {name: "Xem thông tin phòng", icon: "view"},
                "report": {name: "Báo hỏng", icon: "edit"},
                "pay": {name: "Thanh toán tiền thuê", icon: "change"},
                "sep1": "---------",
                "listwaiting": {name: "Danh sách khách chờ", icon: "list"},
                "edit": {name: "Sửa cài đặt phòng", icon: "edit"},
            }
        });

        // lựa chọn chưa có người chuột phải
        $.contextMenu({
            selector: '.context-menu-two',
            callback: function (key, options) {
                switch (key) {
                    case 'received':
                        url = urlReceived + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'clear':
                        clearData(options.$trigger.attr("idroom"));
                        break;
                    case 'delete':
                        deleteData(options.$trigger.attr("idroom"));
                        break;
                    case 'report':
                        url = urlReport + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                }
            },
            items: {
                "received": {name: "Nhận phòng", icon: "received"},
                "sep1": "---------",
                "listwaiting": {name: "Danh sách khách chờ", icon: "list"},
                "edit": {name: "Sửa cài đặt phòng", icon: "edit"},
                "clear": {name: "Đã dọn phòng", icon: "edit"},
                "report": {name: "Báo hỏng", icon: "edit"},
                "delete": {name: "Xóa phòng", icon: "delete"},
            }
        });

        // lựa chọn đã có người chuột trái
        $.contextMenu({
            selector: '.context-menu-one',
            trigger: 'left',
            callback: function (key, options) {
                switch (key) {
                    case 'paid':
                        url = urlPaid + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'cancel':
                        cancelData(options.$trigger.attr("idroom"));
                        break;
                    case 'changeroom':
                        changRoom(options.$trigger.attr("idroom"));
                        break;
                    case 'addservice':
                        url = urlAddservice + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'view':
                        url = urlViewroomdetail + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'report':
                        url = urlReport + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'pay':
                        url = urlPay + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                }
            },
            items: {
                "paid": {name: "Trả phòng", icon: "checkout"},
                "cancel": {name: "Hủy checkin", icon: "delete"},
                "changeroom": {name: "Chuyển phòng", icon: "change"},
                "addservice": {name: "Thêm Hàng hóa - Dịch vụ", icon: "add"},
                "view": {name: "Xem thông tin phòng", icon: "view"},
                "report": {name: "Báo hỏng", icon: "edit"},
                "pay": {name: "Thanh toán tiền thuê", icon: "change"},
                "sep1": "---------",
                "listwaiting": {name: "Danh sách khách chờ", icon: "list"},
                "edit": {name: "Sửa cài đặt phòng", icon: "edit"},
            }
        });

        // lựa chọn chưa có người chuột trái
        $.contextMenu({
            selector: '.context-menu-two',
            trigger: 'left',
            callback: function (key, options) {
                switch (key) {
                    case 'received':
                        url = urlReceived + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                    case 'delete':
                        deleteData(options.$trigger.attr("idroom"));
                        break;
                    case 'report':
                        url = urlReport + '?idroom=' + options.$trigger.attr("idroom");
                        window.location = url;
                        break;
                }
            },
            items: {
                "received": {name: "Nhận phòng", icon: "received"},
                "sep1": "---------",
                "listwaiting": {name: "Danh sách khách chờ", icon: "list"},
                "edit": {name: "Sửa cài đặt phòng", icon: "edit"},
                "report": {name: "Báo hỏng", icon: "edit"},
                "delete": {name: "Xóa phòng", icon: "delete"},
            }
        });
        $.contextMenu({
            selector: '.context-menu-three',
            callback: function (key, options) {

                switch (key) {
                    case 'addroom':
                        url = urlAddroom + '?idFloor=' + options.$trigger.attr("idFloor");
                        window.location = url;
                        break;
                    case 'editFloor':
                        url = urlEditFloor + '?idFloor=' + options.$trigger.attr("idFloor");
                        window.location = url;
                        break;
                }
            },
            items: {
                "addroom": {name: "Thêm phòng", icon: "add"},
                "editFloor": {name: "Sửa tên tầng", icon: "edit"},
            }
        });

        $.contextMenu({
            selector: '.context-menu-three',
            trigger: 'left',
            callback: function (key, options) {

                switch (key) {
                    case 'addroom':
                        url = urlAddroom + '?idFloor=' + options.$trigger.attr("idFloor");
                        window.location = url;
                        break;
                    case 'editFloor':
                        url = urlEditFloor + '?idFloor=' + options.$trigger.attr("idFloor");
                        window.location = url;
                        break;
                }
            },
            items: {
                "addroom": {name: "Thêm phòng", icon: "add"},
                "editFloor": {name: "Sửa tên tầng", icon: "edit"},
            }
        });
    });
    var fromRoom = "";
    var toRoom = "";
    function changRoom(idRoom)
    {
        fromRoom = idRoom;
        $("#my_popup_wrapper").show();
        $("#dialog").show();

    }
    function closePopup()
    {
        $("#my_popup_wrapper").hide();
        $("#dialog").hide();
    }
    function changRoomTo(idRoom)
    {
        toRoom = document.getElementById('selecTo').value;
        if (fromRoom == "")
        {
            alert("Bạn cần chọn 1 phòng chuyển đi!");
        } else
        {
            if (toRoom == 0 || toRoom == "")
            {
                alert("Bạn cần chọn 1 phòng chuyển đến!");
            }
        }
        if (fromRoom != "" && toRoom != 0 & toRoom != "")
        {
            $.ajax({
                type: "POST",
                url: urlChangeroom,
                data: {fromRoom: fromRoom, toRoom: toRoom}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }
    }

    function deleteData(idDelete)
    {
        var check = confirm('Bạn có chắc chắn muốn xóa!');
        if (check)
        {
            $.ajax({
                type: "POST",
                url: urlDelete,
                data: {idroom: idDelete}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }
    }
    function clearData(idClear)
    {
        var check = confirm('Bạn có chắc chắn đã dọn!');
        if (check)
        {
            $.ajax({
                type: "POST",
                url: urlClear,
                data: {idroom: idClear}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }
    }
    function cancelData(idData)
    {
        var note = prompt("Lý do hủy:", '');
        if (note != null) {
            $.ajax({
                type: "POST",
                url: urlCancel,
                data: {idroom: idData, note: note}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                    });
        }

    }
</script>

<div id="my_popup_wrapper"></div>
<div id="dialog">
    Chọn phòng chuyển đến
    <select id="selecTo">
        <?php
        foreach ($listFloor as $floor) {
            echo '<option value="0" disabled style="">' . $floor['Floor']['name'] . '</option>';
            foreach ($listRooms[$floor['Floor']['id']] as $infoRoom) {
                if (empty($infoRoom['Room']['checkin'])) {
                    echo '<option value="' . $infoRoom['Room']['id'] . '">|--' . $infoRoom['Room']['name'] . '</option>';
                }
            }
        }
        ?>
    </select>

    <p>
        <button onclick="closePopup()" >Đóng</button>
        <button onclick="changRoomTo()" >Chuyển</button>
    </p>
</div>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sơ đồ khách sạn</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php
                    global $urlHomeManager;
                    echo $urlHomeManager;
                    ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cài đặt chung</span></li>
                <li><span>Sơ đồ khách sạn</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Sơ đồ khách sạn</h2>
            <div class="showMess"><?php echo $mess;?></div>
        </header>
        <div class="panel-body">   
            <div class="row">
                <div class="col-sm-12">
                    <span class="statistic"><label class="number" style="background-color: seagreen;"><?php echo $totalEmpty; ?></label> còn trống</span>
                    <span class="statistic"><label class="number" style="background-color: red;"><?php echo $totalUse; ?> </label> đang ở</span> 
                    <span class="statistic"><label class="number" style="background-color: orange;"><?php echo $totalUnClear; ?> </label> Chưa dọn</span> 
                    <span class="statistic"><label class="number" style="background-color: #428bca;"><?php echo $totalKhachDoan; ?> </label> Khách đoàn</span> 
                    <span class="statistic"><label class="number" style="background-color: goldenrod;"><?php echo $totalWaiting; ?> </label> đang chờ</span>
                    <?php
                    $classColor ='';
                    foreach ($listTypeRoom as $typeRoom) {
                        echo '<span class="statistic"><label class="number">' . $typeRoom['count'] . '</label>' . $typeRoom['name'] . '</span>';
                    }
                    ?>                    
                </div>
            </div>
            <div class="row">
            </div>
            <?php
            foreach ($listFloor as $floor) {
                echo ' 
					<div class="row diagram">
						<div style="background-color: ' . $floor['Floor']['color'] . ';" class="col-md-1 col-sm-2 floors context-menu-three" idFloor="' . $floor['Floor']['id'] . '">' . $floor['Floor']['name'] . '</div>
                        <div class="col-md-11 col-sm-10">
                            <div class="row">
                        ';
                foreach ($listRooms[$floor['Floor']['id']] as $infoRoom) {
                    if (empty($infoRoom['Room']['checkin'])) {
                        if (!isset($listTypeRoom[$infoRoom['Room']['typeRoom']])) {
                            $listTypeRoom[$infoRoom['Room']['typeRoom']] = '';
                        }
                        

                        if ($infoRoom['Room']['waiting']) {
                            $classColor = 'waiting-room';
                        } elseif (isset($infoRoom['Room']['clear']) && $infoRoom['Room']['clear'] == FALSE) {
                            $classColor = 'un-clear';
                        } else {
                            $classColor = 'clear-room';
                        }

                        echo '
								<div class="col-sm-4 col-md-2 ' . $classColor . ' context-menu-two" idroom="' . $infoRoom['Room']['id'] . '" nameroom="' . @$infoRoom['Room']['name'] . '">
									<div class="name-room">' . @$listTypeRoom[$infoRoom['Room']['typeRoom']]['name'] . '</div>
									<div class="customer-name"><span class="room-number">' . @$infoRoom['Room']['name'] . '</span></div>
								</div>
							';
                    } else {
                        if (isset($infoRoom['Room']['checkin']['khachDoan']) && $infoRoom['Room']['checkin']['khachDoan'] == 'co') {
                            $classColor = 'khachDoan';
                            
                        }else{
                            $classColor = 'booked';
                        }


                        if(isset($infoRoom['Room']['checkin']['Custom']['color'])){
                            $styleRoom= 'style="background-color: '.$infoRoom['Room']['checkin']['Custom']['color'].' !important;"'; 
                        }else{
                            $styleRoom= '';
                        }

                        if (!isset($listTypeRoom[$infoRoom['Room']['typeRoom']]))
                            $listTypeRoom[$infoRoom['Room']['typeRoom']] = '';
                        $dateCheckin = date("d/m/y", $infoRoom['Room']['checkin']['dateCheckin']);
                        $today = time();
                        $tru = $today - $infoRoom['Room']['checkin']['dateCheckin'];
                        if ($infoRoom['Room']['checkin']['type_register'] == 'gia_theo_ngay')
                            $showTime = round($tru / 86400) . ' ngày';
                        else
                            $showTime = round($tru / 3600) . ' giờ';
                        //debug ($tru);
                        echo '
                                <div '.$styleRoom.' class="col-sm-4 col-md-2 ' . $classColor . ' context-menu-one" idroom="' . $infoRoom['Room']['id'] . '" nameroom="' . $infoRoom['Room']['name'] . '">
                                    <div class="name-room">' . $listTypeRoom[$infoRoom['Room']['typeRoom']]['name'] . '</div>
                                    <div class="time">';
                        if ($infoRoom['Room']['checkin']['dateCheckoutForesee'] > 0){
                        	$phanTram= round((($today-$infoRoom['Room']['checkin']['dateCheckin'])/($infoRoom['Room']['checkin']['dateCheckoutForesee']-$infoRoom['Room']['checkin']['dateCheckin']))*100);
                            echo '
                                        <div class="progress progress-xs light" style="margin-bottom: 0; margin-top: 3px;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: '.$phanTram.'%;"></div>
                                        </div>';
                        }
                        echo '<span> ' . $showTime . ' <br/>' . $dateCheckin . '</span>
                                    </div>                   
                                    <div class="customer-name"><span class="room-number">' . $infoRoom['Room']['name'] . '</span>  <br/><span>(' . $infoRoom['Room']['checkin']['number_people'] . ') ' . @$infoRoom['Room']['checkin']['Custom']['cus_name'] . '</span></div>
                                </div>
                            ';
                    }
                }
                echo '</div>
                        </div>
					</div>
					';
            }
            ?> 
        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<style>
    #dialog{
        background-color: #fff;
        padding: 10px;
        z-index: 9999999999;
        position: fixed;
        top: 50%;
        left: 50%;
        display: none;
        /* bring your own prefixes */
        transform: translate(-50%, -50%);
    }
    #my_popup_wrapper{
        opacity: 0.8; 
        visibility: visible; 
        position: fixed; 
        overflow: auto; 
        z-index: 100001; 
        width: 100%; 
        height: 100%; 
        top: 0px; 
        left: 0px; 
        text-align: center; 
        display: none;
        background-color: #000;
    }
</style>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>