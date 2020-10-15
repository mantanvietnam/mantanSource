<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic|Roboto+Slab:400,700|Inconsolata:400,700&subset=latin,cyrillic'
      rel='stylesheet' type='text/css'>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager/'; ?>css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager/'; ?>js/jquery.contextMenu.min.js" type="text/javascript"></script>
<script src="http://swisnl.github.io/jQuery-contextMenu/js/main.js" type="text/javascript"></script>

<script type="text/javascript">
    var urlPaid = "<?php echo $urlHomes; ?>managerCheckoutBar";
    var urlEdit = "<?php echo $urlHomes; ?>managerAddBarTable";
    var urlClear = "<?php echo $urlHomes; ?>managerClearBarTable";
    var urlDelete = "<?php echo $urlHomes; ?>managerDeleteBarTable";
    var urlBookroom = "check-in.php";
    var urlEditcost = "http://";
    var urlChangeroom = "<?php echo $urlHomes; ?>managerChangBarTable";
    var urlAddservice = "<?php echo $urlHomes; ?>managerAddServiceBarTable";
    var urlCreatebill = "";
    var urlReceived = "<?php echo $urlHomes; ?>managerCheckinBar";
    var urlCancel = "<?php echo $urlHomes; ?>managerCancelCheckinBar";
    var url;
    var urlAddroom = "<?php echo $urlHomes; ?>managerAddBarTable";
    var urlEditFloor = "<?php echo $urlHomes; ?>managerAddBarFloor";
    var urlNow = "<?php echo $urlNow; ?>";
    var urlListwaiting = "<?php echo $urlHomes; ?>managerListWaiting";
    var urlViewroomdetail = "<?php echo $urlHomes; ?>managerViewBarTableDetail";

    $(function () {
        // lựa chọn đã có người chuột phải
        $.contextMenu({
            selector: '.context-menu-one',
            callback: function (key, options) {
                switch (key) {
                    case 'paid':
                        url = urlPaid + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'cancel':
                        cancelData(options.$trigger.attr("idTable"));
                        break;
                    case 'changeroom':
                        changRoom(options.$trigger.attr("idTable"));
                        break;
                    case 'addservice':
                        url = urlAddservice + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'view':
                        url = urlViewroomdetail + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                }
            },
            items: {
                "paid": {name: "Trả bàn", icon: "checkout", accesskey: "c o"},
                "cancel": {name: "Hủy checkin", icon: "delete"},
                "changeroom": {name: "Chuyển bàn", icon: "change", accesskey: "c r"},
                "addservice": {name: "Thêm Hàng hóa - Dịch vụ", icon: "add", accesskey: "a s"},
                "view": {name: "Xem thông tin bàn", icon: "view", accesskey: "u s"},
                "sep1": "---------",
                "edit": {name: "Sửa cài đặt bàn", icon: "edit", accesskey: "e"},
            }
        });

        // lựa chọn chưa có người chuột phải
        $.contextMenu({
            selector: '.context-menu-two',
            callback: function (key, options) {
                switch (key) {
                    case 'received':
                        url = urlReceived + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'clear':
                        clearData(options.$trigger.attr("idTable"));
                        break;
                    case 'delete':
                        deleteData(options.$trigger.attr("idTable"));
                        break;

                }
            },
            items: {
                "received": {name: "Nhận bàn", icon: "received", accesskey: "r"},
                "clear": {name: "Đã dọn bàn", icon: "edit", accesskey: "c"},
                "sep1": "---------",
                "edit": {name: "Sửa cài đặt bàn", icon: "edit", accesskey: "e"},
                "delete": {name: "Xóa bàn", icon: "delete", accesskey: "d"},
            }
        });

        // lựa chọn đã có người chuột trái
        $.contextMenu({
            selector: '.context-menu-one',
            trigger: 'left',
            callback: function (key, options) {
                switch (key) {
                    case 'paid':
                        url = urlPaid + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'cancel':
                        cancelData(options.$trigger.attr("idTable"));
                        break;
                    case 'changeroom':
                        changRoom(options.$trigger.attr("idTable"));
                        break;
                    case 'addservice':
                        url = urlAddservice + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'view':
                        url = urlViewroomdetail + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                }
            },
            items: {
                "paid": {name: "Trả bàn", icon: "checkout", accesskey: "c o"},
                "cancel": {name: "Hủy checkin", icon: "delete"},
                "changeroom": {name: "Chuyển bàn", icon: "change", accesskey: "c r"},
                "addservice": {name: "Thêm Hàng hóa - Dịch vụ", icon: "add", accesskey: "a s"},
                "view": {name: "Xem thông tin bàn", icon: "view", accesskey: "u s"},
                "sep1": "---------",
                "edit": {name: "Sửa cài đặt bàn", icon: "edit", accesskey: "e"},
            }
        });

        // lựa chọn chưa có người chuột trái
        $.contextMenu({
            selector: '.context-menu-two',
            trigger: 'left',
            callback: function (key, options) {
                switch (key) {
                    case 'received':
                        url = urlReceived + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'listwaiting':
                        url = urlListwaiting + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'edit':
                        url = urlEdit + '?idTable=' + options.$trigger.attr("idTable");
                        window.location = url;
                        break;
                    case 'delete':
                        deleteData(options.$trigger.attr("idTable"));
                        break;

                }
            },
            items: {
                "received": {name: "Nhận bàn", icon: "received", accesskey: "r"},
                "clear": {name: "Đã dọn bàn", icon: "edit", accesskey: "c"},
                "sep1": "---------",
                "edit": {name: "Sửa cài đặt bàn", icon: "edit", accesskey: "e"},
                "delete": {name: "Xóa bàn", icon: "delete", accesskey: "d"},
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
                "addroom": {name: "Thêm bàn", icon: "add", accesskey: "a"},
                "editFloor": {name: "Sửa tên tầng", icon: "edit", accesskey: "e"},
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
                "addroom": {name: "Thêm bàn", icon: "add", accesskey: "a"},
                "editFloor": {name: "Sửa tên tầng", icon: "edit", accesskey: "e"},
            }
        });
    });
    var fromRoom = "";
    var toRoom = "";
    function changRoom(idTable)
    {
        fromRoom = idTable;
        $("#my_popup_wrapper").show();
        $("#dialog").show();

    }
    function closePopup()
    {
        $("#my_popup_wrapper").hide();
        $("#dialog").hide();
    }
    function changRoomTo()
    {
        toRoom = document.getElementById('selecTo').value;
        if (fromRoom == "")
        {
            alert("Bạn cần chọn 1 bàn chuyển đi!");
        } else
        {
            if (toRoom == 0 || toRoom == "")
            {
                alert("Bạn cần chọn 1 bàn chuyển đến!");
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
                data: {idTable: idDelete}
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
                data: {idTable: idClear}
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
                data: {idTable: idData, note: note}
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
    Chọn bàn bar chuyển đến
    <select id="selecTo">
        <?php
        foreach ($listFloor as $floor) {
            echo '<option value="0" style="">' . $floor['BarFloor']['name'] . '</option>';
            foreach ($listTable[$floor['BarFloor']['id']] as $infoTable) {
                if (empty($infoTable['BarTable']['checkin'])) {
                    echo '<option value="' . $infoTable['BarTable']['id'] . '">|--' . $infoTable['BarTable']['name'] . '</option>';
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
        <h2>Sơ đồ bar</h2>

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
                <li><span>Sơ đồ bar</span></li>
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

            <h2 class="panel-title">Sơ đồ bar</h2>
        </header>
        <div class="panel-body">   
            <div class="row">
                <div class="col-sm-12">
                    <span class="statistic"><label class="number" style="background-color: seagreen;"><?php echo $totalEmpty; ?></label> còn trống</span>
                    <span class="statistic"><label class="number" style="background-color: red;"><?php echo $totalUse; ?> </label> đang dùng</span> 
                    <span class="statistic"><label class="number" style="background-color: orange;"><?php echo $totalUnClear; ?> </label> Chưa dọn</span> 
                </div>
            </div>
            <div class="row">
            </div>
            <?php
            foreach ($listFloor as $floor) {
                echo ' 
					<div class="row diagram">
						<div style="background-color: ' . $floor['BarFloor']['color'] . ';" class="col-md-1 col-sm-2 floors context-menu-three" idFloor="' . $floor['BarFloor']['id'] . '">' . $floor['BarFloor']['name'] . '</div>
                        <div class="col-md-11 col-sm-10">
                            <div class="row">
                        ';
                foreach ($listTable[$floor['BarFloor']['id']] as $infoTable) {
                    if (empty($infoTable['BarTable']['checkin'])) {
                        

                        if ($infoTable['BarTable']['waiting']) {
                            $classColor = 'waiting-room';
                        } elseif (isset($infoTable['BarTable']['clear']) && $infoTable['BarTable']['clear'] == FALSE) {
                            $classColor = 'un-clear';
                        } else {
                            $classColor = 'clear-room';
                        }

                        echo '
								<div class="col-sm-4 col-md-2 ' . $classColor . ' context-menu-two" idTable="' . $infoTable['BarTable']['id'] . '" nameroom="' . $infoTable['BarTable']['name'] . '">
									<div class="name-room"></div>
									<div class="customer-name"><span class="room-number">' . $infoTable['BarTable']['name'] . '</span></div>
								</div>
							';
                    } else {
                        if (!isset($infoTable['BarTable']['checkin']['cus_name']) || $infoTable['BarTable']['checkin']['cus_name']=="")
                        {
                            $infoTable['BarTable']['checkin']['cus_name']="Khách lẻ";
                        }
                        if (isset($infoTable['BarTable']['checkin']['khachDoan']) && $infoTable['BarTable']['checkin']['khachDoan'] == 'co') {
                            $classColor = 'khachDoan';
                            
                        }else{
                            $classColor = 'booked';
                        }
                        $dateCheckin = date("d/m", $infoTable['BarTable']['checkin']['dateCheckin']);
                        $today = time();
                        $tru = $today - $infoTable['BarTable']['checkin']['dateCheckin'];
                        $showTime = round($tru / 3600) . ' giờ';
                        echo '
                                <div class="col-sm-4 col-md-2 ' . $classColor . ' context-menu-one" idTable="' . $infoTable['BarTable']['id'] . '" nameroom="' . $infoTable['BarTable']['name'] . '">
                                    <div class="name-room"></div>
                                    <div class="time">';
                     
                        echo '<span> ' . $showTime . ' <br/>' . $dateCheckin . '</span>
                                    </div>                   
                                    <div class="customer-name"><span class="room-number">' . $infoTable['BarTable']['name'] . '</span>  <br/><span>(' . $infoTable['BarTable']['checkin']['number_people'] . ') ' . @$infoTable['BarTable']['checkin']['cus_name'] . '</span></div>
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