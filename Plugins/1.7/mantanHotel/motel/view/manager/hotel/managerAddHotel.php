<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager/css/magiczoomplus.css'; ?>"/>
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager/js/magiczoomplus.js'; ?>"></script>
<script>
    var mzOptions = {
        zoomDistance: 100,
        zoomMode: "preview",
        zoomPosition: "left",
        textHoverZoomHint: ""
    };
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <?php
        if (isset($data['Hotel']['id']))
            echo '<h2>Sửa cơ sở lưu trú</h2>';
        else
            echo '<h2>Thêm mới cơ sở lưu trú</h2>';
        ?>

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
                <li><span>Manager</span></li>
                <?php
                if (isset($data['Hotel']['id']))
                    echo '<li><span>Sửa</span></li>';
                else
                    echo '<li><span>Thêm mới</span></li>';
                ?>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>
                        <?php
                        if (isset($data['Hotel']['id']))
                            echo '<h2 class="panel-title">Sửa cơ sở lưu trú</h2>';
                        else
                            echo '<h2 class="panel-title">Thêm mới cơ sở lưu trú</h2>';
                        ?>
                        <p class="panel-subtitle">
                            Vui lòng điền đầy đủ thông tin cơ sở lưu trú theo mẫu bên dưới!
                        </p>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-6">

                            <input type="hidden" id="id" name="id" value="<?php echo(isset($data['Hotel']['id'])) ? $data['Hotel']['id'] : ''; ?>" />
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tên cơ sở lưu trú <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control"  id="name" name="name" value="<?php echo(isset($data['Hotel']['name'])) ? $data['Hotel']['name'] : ''; ?>" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Điện thoại <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo(isset($data['Hotel']['phone'])) ? $data['Hotel']['phone'] : ''; ?>" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="name" name="email" value="<?php echo(isset($data['Hotel']['email'])) ? $data['Hotel']['email'] : ''; ?>" autocomplete="off"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Website <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="website" name="website" value="<?php echo(isset($data['Hotel']['website'])) ? $data['Hotel']['website'] : ''; ?>" />
                                </div>
                            </div>					
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tỉnh thành <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <select id="city" name="city" class="form-control" required onchange="getDistrict();">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        <?php
                                        foreach ($listCity as $city) {
                                            echo '<option ';
                                            if (isset($data['Hotel']['city']) && $data['Hotel']['city'] == $city['id'])
                                                echo 'selected ';
                                            echo 'value="' . $city['id'] . '">' . $city['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label class="error" for="city"></label>
                                </div>
                            </div>		

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Quận huyện<span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <select id="district" name="district" class="form-control" onchange="getLocaltion();" required>
                                        <option>Chọn quận/huyện</option>
                                        <?php
                                        if (isset($data['Hotel']['city'])) {

                                            foreach ($listCity[$data['Hotel']['city']]['district'] as $district) {
                                                echo '<option ';
                                                if (isset($data['Hotel']['district']) && $data['Hotel']['district'] == $district['id'])
                                                    echo 'selected ';
                                                echo 'value="' . $district['id'] . '">' . $district['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label class="error" for="district"></label>
                                </div>
                            </div>
                            <script>
                                var addressNote = '';
                                var allCity = [];
<?php
global $modelOption;
$listCity = $modelOption->getOption('cityMantanHotel');
if (!empty($listCity['Option']['value']['allData'])) {
    foreach ($listCity['Option']['value']['allData'] as $key => $value) {
        echo 'allCity["' . $value['id'] . '"]=[];';
        $dem = 0;
        if (isset($value['district']) && count($value['district']) > 0)
            foreach ($value['district'] as $key2 => $value2) {
                $dem++;
                echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]=[];';
                echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]["1"]=' . $value2['id'] . ';';
                echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]["2"]="' . $value2['name'] . '";';
            }
    }
}
?>

                                function getDistrict()
                                {
                                    var city = document.getElementById('city').value;
                                    var mangDistrict = allCity[city];
                                    var dem = 1;
                                    var chuoi = "<option>Chọn quận/huyện</option>";

                                    while (typeof (mangDistrict[dem]) != 'undefined')
                                    {
                                        chuoi += "<option value=\"" + mangDistrict[dem][1] + "\">" + mangDistrict[dem][2] + "</option>";
                                        dem++;
                                    }
                                    $('#district').html(chuoi);
                                    addressNote = $("#city :selected").text();
                                    getLocationFromAddress(addressNote);
                                    document.getElementById('address').value = addressNote;
                                }

                            </script>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Loại hình lưu trú</label>
                                <div class="col-sm-8">
                                    <select id="company" class="form-control" name="typeHotel" required>

                                        <option>Chọn loại hình lưu trú</option>
                                        <?php
                                        if (!empty($listHotelTypes)) {
                                            foreach ($listHotelTypes as $hotelType) {
                                                ?>
                                                <option <?php
                                                if (!empty($data['Hotel']['typeHotel']) && $data['Hotel']['typeHotel'] == $hotelType['id']) {
                                                    echo 'selected';
                                                }
                                                ?> value="<?php echo $hotelType['id']; ?>"><?php echo $hotelType['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>


                                    </select>
                                    <label class="error" for="hoteltype"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giá nghỉ theo ngày <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="price" class="form-control" value="<?php echo(isset($data['Hotel']['price'])) ? $data['Hotel']['price'] : ''; ?>" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giá nghỉ theo giờ <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="priceHour" class="form-control" value="<?php echo(isset($data['Hotel']['priceHour'])) ? $data['Hotel']['priceHour'] : ''; ?>" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giá nghỉ qua đêm <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="priceNight" class="form-control" value="<?php echo(isset($data['Hotel']['priceNight'])) ? $data['Hotel']['priceNight'] : ''; ?>" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Địa chỉ <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="Nhập địa chỉ chi tiết" required name="address" class="form-control" value="<?php echo(isset($data['Hotel']['address'])) ? $data['Hotel']['address'] : ''; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nick Yahoo </label>
                                <div class="col-sm-8">
                                    <input type="text" name="yahoo" class="form-control" value="<?php echo(isset($data['Hotel']['yahoo'])) ? $data['Hotel']['yahoo'] : ''; ?>" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nick Skype </label>
                                <div class="col-sm-8">
                                    <input type="text" name="skype" class="form-control" value="<?php echo(isset($data['Hotel']['skype'])) ? $data['Hotel']['skype'] : ''; ?>" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Link ảnh 360 </label>
                                <div class="col-sm-8">
                                    <input type="text" name="link360" class="form-control" value="<?php echo(isset($data['Hotel']['link360'])) ? $data['Hotel']['link360'] : ''; ?>" />

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Vị trí</label>
                                <div class="col-sm-9 convenient">
                                    <?php
                                    if (!empty($listLocal))
                                        foreach ($listLocal as $local) {
                                            echo '
                                                <div class="checkbox-custom chekbox-primary">
                                                    <input type="checkbox" ';
                                            if (isset($data['Hotel']['local']) && in_array($local['id'], $data['Hotel']['local']))
                                                echo 'checked ';
                                            echo 'value="' . $local['id'] . '" name="local[]"/>
                                                <label>' . $local['name'] . '</label>
                                            </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mặc định</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <?php showUploadFile('imageDefault', 'imageDefault', @$data['Hotel']['imageDefault'], 10); ?> 
                                        <div class="app-figure" id="zoom-fig1">
                                            <?php
                                            if (!empty($data['Hotel']['imageDefault'])) {
                                                echo '<a id="Zoom-2" class="MagicZoom" href="' . $data['Hotel']['imageDefault'] . '" target="_blank"><img src="' . $data['Hotel']['imageDefault'] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Bảng giá</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <?php showUploadFile('image0', 'image0', @$data['Hotel']['image'][0], 0); ?> 
                                        <div class="app-figure" id="zoom-fig2">
                                            <?php
                                            if (!empty($data['Hotel']['image'][0])) {
                                                echo '<a id="Zoom-2" class="MagicZoom" href="' . $data['Hotel']['image'][0] . '" target="_blank"><img src="' . $data['Hotel']['image'][0] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ảnh phòng</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <?php showUploadFile('image1', 'image1', @$data['Hotel']['image'][1], 1); ?> 
                                        <div class="app-figure" id="zoom-fig">
                                            <?php
                                            if (!empty($data['Hotel']['image'][1])) {
                                                echo '<a id="Zoom-1" class="MagicZoom" href="' . $data['Hotel']['image'][1] . '"><img srcset="' . $data['Hotel']['image'][1] . '" src="' . $data['Hotel']['image'][1] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ảnh cổng</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <?php showUploadFile('image2', 'image2', @$data['Hotel']['image'][2], 2); ?> 
                                        <div class="app-figure" id="zoom-fig4">
                                            <?php
                                            if (!empty($data['Hotel']['image'][2])) {
                                                echo '<a id="Zoom-4" class="MagicZoom" href="' . $data['Hotel']['image'][2] . '"><img srcset="' . $data['Hotel']['image'][2] . '" src="' . $data['Hotel']['image'][2] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ảnh khác</label>
                                <div class="col-sm-9">
                                    <div class="row" style="">
                                        <?php showUploadFile('image3', 'image3', @$data['Hotel']['image'][3], 3); ?> 
                                        <div class="app-figure" id="zoom-fig5">
                                            <?php
                                            if (!empty($data['Hotel']['image'][3])) {
                                                echo '<a id="Zoom-5" class="MagicZoom" href="' . $data['Hotel']['image'][3] . '" target="_blank"><img srcset="' . $data['Hotel']['image'][3] . '" src="' . $data['Hotel']['image'][3] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <?php showUploadFile('image4', 'image4', @$data['Hotel']['image'][4], 4); ?> 
                                        <div class="app-figure" id="zoom-fig6">
                                            <?php
                                            if (!empty($data['Hotel']['image'][4])) {
                                                echo '<a id="Zoom-6 class="MagicZoom" href="' . $data['Hotel']['image'][4] . '" target="_blank"><img src="' . $data['Hotel']['image'][4] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <?php showUploadFile('image5', 'image5', @$data['Hotel']['image'][5], 5); ?> 
                                        <div class="app-figure" id="zoom-fig7">
                                            <?php
                                            if (!empty($data['Hotel']['image'][5])) {
                                                echo '<a id="Zoom-7" class="MagicZoom" href="' . $data['Hotel']['image'][5] . '" target="_blank"><img src="' . $data['Hotel']['image'][5] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <?php showUploadFile('image6', 'image6', @$data['Hotel']['image'][6], 6); ?> 
                                        <div class="app-figure" id="zoom-fig8">
                                            <?php
                                            if (!empty($data['Hotel']['image'][6])) {
                                                echo '<a id="Zoom-8" class="MagicZoom" href="' . $data['Hotel']['image'][6] . '" target="_blank"><img src="' . $data['Hotel']['image'][6] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <?php showUploadFile('image7', 'image7', @$data['Hotel']['image'][7], 7); ?> 
                                        <div class="app-figure" id="zoom-fig9">
                                            <?php
                                            if (!empty($data['Hotel']['image'][7])) {
                                                echo '<a id="Zoom-9" class="MagicZoom" href="' . $data['Hotel']['image'][7] . '" target="_blank"><img src="' . $data['Hotel']['image'][7] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <?php showUploadFile('image8', 'image8', @$data['Hotel']['image'][8], 8); ?> 
                                        <div class="app-figure" id="zoom-fig10">
                                            <?php
                                            if (!empty($data['Hotel']['image'][8])) {
                                                echo '<a id="Zoom-10" class="MagicZoom" href="' . $data['Hotel']['image'][8] . '" target="_blank"><img src="' . $data['Hotel']['image'][8] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <?php showUploadFile('image9', 'image9', @$data['Hotel']['image'][9], 9); ?> 
                                        <div class="app-figure" id="zoom-fig11">
                                            <?php
                                            if (!empty($data['Hotel']['image'][9])) {
                                                echo '<a id="Zoom-11" class="MagicZoom" href="' . $data['Hotel']['image'][9] . '" target="_blank"><img src="' . $data['Hotel']['image'][9] . '" width="50" /></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Link xem camera</label>
                                <div class="col-sm-9">
                                    <div class="row" style="margin-top: 15px">
                                        <input type="text" name="linkCamera" class="form-control" value="<?php echo(isset($data['Hotel']['linkCamera'])) ? $data['Hotel']['linkCamera'] : ''; ?>" placeholder="Điền link trang web xem camera" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tiện nghi <span class="required">*</span></label>
                                <div class="col-sm-9 convenient">
                                    <?php
                                    if (!empty($listFurniture))
                                        foreach ($listFurniture as $furniture) {
                                            echo '
                                                <div class="checkbox-custom chekbox-primary">
                                                    <input type="checkbox" ';
                                            if (isset($data['Hotel']['furniture']) && in_array($furniture['id'], $data['Hotel']['furniture']))
                                                echo 'checked ';
                                            echo 'value="' . $furniture['id'] . '" name="furniture[]"/>
                                                <label>' . $furniture['name'] . '</label>
                                            </div>';
                                        }
                                    ?>

                                    <label class="error" for="for[]"></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Thông tin chung <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <?php showEditorInput('info', 'info', @$data['Hotel']['info']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bản đồ <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <a href="javascript:void( 0 );" class="btn btn-primary btn-sm" onclick="getByAdress();">Lấy bản đồ từ địa chỉ</a>
                                &nbsp; Tọa độ GPS 
                                <input type="text" name="coordinates" id="coordinates" class="text_area" value="<?php
                                if (isset($hotel['Hotel']['coordinates']))
                                    echo $hotel['Hotel']['coordinates'];
                                else
                                    echo ',';
                                ?>" />
                                <br />
                                <input type="text" id="address" class="form-control" value="" style="margin-top: 20px;" />
                                <br />
                                <a href="javascript:void( 0 );" class="btn btn-primary btn-sm" onclick="searchAdress();">Tìm</a>
                                <span> Di chuột và chọn địa điểm trên bản đồ</span>
                                <script type="text/javascript">
                                    function searchAdress()
                                    {
                                        addressNote = document.getElementById('address').value;
                                        getLocationFromAddress(addressNote);
                                    }
                                    function getByAdress()
                                    {
                                        //addressNote = $("#detailAddress").val() + ', ' + $("#district :selected").text() + ', ' + $("#city :selected").text();
                                        addressNote = $("#detailAddress").val();
                                        getLocationFromAddress(addressNote);
                                        document.getElementById('address').value = addressNote;
                                    }
                                </script>

                            </div>
                        </div>
                        <div id="map-canvas" style="width: 100%; height: 500px"></div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Lưu</button>

                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>

<script type="text/javascript">
    var map;
    var geocoder;
    var marker;

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var mapDiv = document.getElementById('map-canvas');
        // Create the map object
        map = new google.maps.Map(mapDiv, {
<?php
if (isset($data['Hotel']['coordinates'])) {
    echo 'center: new google.maps.LatLng(' . $data['Hotel']['coordinates'] . '),';
} else {
    echo 'center: new google.maps.LatLng(16.496281,107.219443),';
}
?>
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: false
        });
        // Create the default marker icon
        marker = new google.maps.Marker({
            map: map,
<?php
if (isset($data['Hotel']['coordinates'])) {
    echo 'position: new google.maps.LatLng(' . $data['Hotel']['coordinates'] . '),';
} else {
    echo 'position: new google.maps.LatLng(16.496281,107.219443),';
}
?>
            draggable: true
        });
        // Add event to the marker
        google.maps.event.addListener(marker, 'drag', function () {
            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        document.getElementById('address').value = results[0].formatted_address;
                        document.getElementById('coordinates').value = marker.getPosition().toUrlValue();
                    }
                }
            });
        });
    }
    function getLocationFromAddress(address) {
        //var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                document.getElementById('coordinates').value = results[0].geometry.location.lat().toFixed(7) + ',' + results[0].geometry.location.lng().toFixed(7);
            } else {
                alert('Không tìm thấy địa điểm trên bản đồ.');
            }
        });
    }
    // Initialize google map
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8Lo3pUlPzJUuT58ie2WP0WXq6YNMYHOg&callback=initialize">
</script>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>