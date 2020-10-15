<?php
global $languageCity;
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(function () {
        $("#tabs").tabs();
    });
</script>
<script type="text/javascript">

    function saveData() {
        var tieude = document.getElementById("title").value;

        if (tieude == '') {
            alert('Bạn phải nhập thông tin bên dưới!');
        } else {

            document.dangtin.submit();

        }

    }


</script>
<link href="<?php echo $urlHomes . 'app/Plugin/city/style.css'; ?>" rel="stylesheet">

<?php
$categoryNotice = changeNoticeCategoryToList(getListNoticeCategory());

$breadcrumb = array('name' => 'List City',
    'url' => $urlPlugins . 'admin/city-listCity.php',
    'sub' => array('name' => 'Edit City')
);
addBreadcrumbAdmin($breadcrumb);
$images_default = $urlHomes . '/app/Plugin/city/images/no_image-100x100.jpg';
?>

<div class="thanhcongcu">
    <div class="congcu" onclick="saveData();">
        <input type="hidden" id="idChange" value=""/>
        <span id="save">
            <input type="image" src="<?php echo $webRoot; ?>images/save.png"/>
        </span>
        <br/>
        Save
    </div>

</div>

<div class="clear"></div>

<div id="content">
    <form action="" method="POST" name="dangtin" enctype="multipart/form-data">

        <input type="hidden" value="<?php echo (isset($data['City']['id'])) ? $data['City']['id'] : ''; ?>" name="id"/>


        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Mô tả</a></li>
                <li><a href="#tabs-4">Bài viết</a></li>
                <li><a href="#tabs-3">Hình ảnh</a></li>
                <li><a href="#tabs-2">Thông tin</a></li>
                <li><a href="#tabs-6">Trải nghiệm</a></li>

            </ul>
            <!-- City Description -->
            <div id="tabs-1">
                <table width="100%">
                    <tr>
                        <td valign="top">
                            <div style="margin-bottom: 10px;">
                                <p><b>Tên</b> (Bắt buộc)</p>
                                <input type="text" name="name" required="" id='title'
                                       value="<?php echo (isset($data['City']['name'])) ? $data['City']['name'] : ''; ?>"
                                       class="form-control"/>
                            </div>

                            <div class="form-group">
                                <p style="clear: both;"><b>Khu vực</b> (Bắt buộc)</p>

                                <div class="">
                                    <select name="khuvuc" class="form-control" required="">
                                        <option value="">Chọn khu vực</option>
                                        <option value="TB" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'TB') {
                                            echo 'selected';
                                        }
                                        ?>>Tây Bắc
                                        </option>
                                        <option value="DB" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'DB') {
                                            echo 'selected';
                                        }
                                        ?>>Đông Bắc
                                        </option>
                                        <option value="BTB" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'BTB') {
                                            echo 'selected';
                                        }
                                        ?>>Bắc Trung Bộ
                                        </option>
                                        <option value="DHNTB" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'DHNTB') {
                                            echo 'selected';
                                        }
                                        ?>>Nam Trung Bộ
                                        </option>
                                        <option value="TN"<?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'TN') {
                                            echo 'selected';
                                        }
                                        ?>>Tây Nguyên
                                        </option>
                                        <option value="MN" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'MN') {
                                            echo 'selected';
                                        }
                                        ?>>Đông Nam Bộ
                                        </option>
                                        <option value="DBSCL" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'DBSCL') {
                                            echo 'selected';
                                        }
                                        ?>>ĐB Sông Cửu Long
                                        </option>
                                        <option value="QDHS" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'QDHS') {
                                            echo 'selected';
                                        }
                                        ?>>Quần Đảo Hoàng Sa
                                        </option>
                                        <option value="QDTS" <?php
                                        if (isset($data['City']['khuvuc']) && $data['City']['khuvuc'] == 'QDTS') {
                                            echo 'selected';
                                        }
                                        ?>>Quần Đảo Trường Sa
                                        </option>

                                    </select>
                                </div>

                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <p style="clear: both;"><b>Mô tả ngắn (Bắt buộc)</b></p>
                            <textarea class="form-control" name="desc" required="" cols="59"
                                      rows="15"><?php echo (isset($data['City']['desc'])) ? $data['City']['desc'] : ''; ?></textarea>

                            <p style="clear: both;"><b>Giới thiệu</b></p>
                            <textarea class="form-control" name="giơithieu" required="" cols="59"
                                      rows="15"><?php echo (isset($data['City']['giơithieu'])) ? $data['City']['giơithieu'] : ''; ?></textarea>

                            <p style="clear: both;"><b>Văn hóa</b></p>
                            <textarea class="form-control" name="vanhoa" required="" cols="59"
                                      rows="15"><?php echo (isset($data['City']['vanhoa'])) ? $data['City']['vanhoa'] : ''; ?></textarea>

                            <p style="clear: both;"><b>Ẩm thực</b></p>
                            <textarea class="form-control" name="amthuc" required="" cols="59"
                                      rows="15"><?php echo (isset($data['City']['amthuc'])) ? $data['City']['amthuc'] : ''; ?></textarea>

                            <p style="clear: both;"><b>Quà tặng</b></p>
                            <textarea class="form-control" name="quatang" cols="59" rows="10"
                                      required=""><?php echo (isset($data['City']['quatang'])) ? $data['City']['quatang'] : ''; ?></textarea>

                            <p></p>

                            <div class="clear" style="margin-bottom:10px;"></div>
                        </td>

                    </tr>
                    <div class="clear" style="margin-bottom:10px;"></div>

                </table>
            </div>
            <div id="tabs-4">
                <table width="100%">
                    <tr>
                        <td valign="top">

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Chuyên
                                    mục những địa danh cần đến</label>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <select name="category_diadanh" class="form-control" required="">
                                        <option value="">Chọn chuyên mục những địa danh cần đến</option>
                                        <?php foreach ($categoryNotice as $categoryLink) { ?>
                                            <option <?php
                                            if (isset($data['City']['category_diadanh']) && $data['City']['category_diadanh'] == $categoryLink['id']) {
                                                echo 'selected';
                                            }
                                            ?> value="<?php echo $categoryLink['id']; ?>"><?php echo $categoryLink['name']; ?> </option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>

                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Chuyên
                                    mục Luxury</label>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <select name="category_luxury" class="form-control" required="">
                                        <option value="">Chọn chuyên mục Luxury</option>
                                        <?php foreach ($categoryNotice as $categoryLink) { ?>
                                            <option <?php
                                            if (isset($data['City']['category_luxury']) && $data['City']['category_luxury'] == $categoryLink['id']) {
                                                echo 'selected';
                                            }
                                            ?> value="<?php echo $categoryLink['id']; ?>"><?php echo $categoryLink['name']; ?> </option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>

                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Chuyên
                                    mục Sắc màu</label>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <select name="category_sacmau" class="form-control" required="">
                                        <option value="">Chọn chuyên mục Sắc màu</option>
                                        <?php foreach ($categoryNotice as $categoryLink) { ?>
                                            <option <?php
                                            if (isset($data['City']['category_sacmau']) && $data['City']['category_sacmau'] == $categoryLink['id']) {
                                                echo 'selected';
                                            }
                                            ?> value="<?php echo $categoryLink['id']; ?>"><?php echo $categoryLink['name']; ?> </option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>

                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>


                            <div class="clear" style="margin-bottom:10px;"></div>
                            <p style="clear: both;"><b>Mô tả Luxury 1</b></p>
                            <textarea class="form-control" name="luxury_desc1" cols="59"
                                      rows="15"><?php echo (isset($data['City']['luxury_desc1'])) ? $data['City']['luxury_desc1'] : ''; ?></textarea>

                            <p style="clear: both;"><b>Mô tả Luxury 2</b></p>
                            <textarea class="form-control" name="luxury_desc2" cols="59"
                                      rows="15"><?php echo (isset($data['City']['luxury_desc2'])) ? $data['City']['luxury_desc2'] : ''; ?></textarea>


                            <div class="clear" style="margin-bottom:10px;"></div>
                        </td>

                    </tr>
                    <?php
                    if (function_exists('getLinkWebCategory')) {
                        $linkWebCategory = getLinkWebCategory();

                        if (isset($linkWebCategory['Option']['value']['allData']) && count($linkWebCategory['Option']['value']['allData']) > 0) {
                            ?>
                            <tr>
                                <td>
                                    <p><b>Link web Tour khám phá</b></p>
                                    <select name="idLinkWebCategoryKhamPha">
                                        <option value="">Select link web Tour khám phá</option>
                                        <?php
                                        foreach ($linkWebCategory['Option']['value']['allData'] as $categoryLink) {
                                            if (isset($data['City']['idLinkWebCategoryKhamPha']) && $data['City']['idLinkWebCategoryKhamPha'] == $categoryLink['id']) {
                                                echo '<option selected value="' . $categoryLink['id'] . '">' . $categoryLink['name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $categoryLink['id'] . '">' . $categoryLink['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>

                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <div class="clear" style="margin-bottom:10px;"></div>

                </table>
            </div>

            <!-- City Information -->
            <div id="tabs-2">
                <h4>Bản đồ</h4>
                <?php showEditorInput('map', 'map', @$data['City']['map'], 1); ?>
                <h4>Thời tiết</h4>
                <input name="idCityWeather" class="form-control" value="<?php if(!empty($data['City']['idCityWeather'])) echo $data['City']['idCityWeather'];?>" placeholder="Nhập id tỉnh thành" style="width:50%;margin-bottom: 5px;">
                <input name="codeCityWeather" class="form-control" value="<?php if(!empty($data['City']['codeCityWeather'])) echo $data['City']['codeCityWeather'];?>" placeholder="Nhập mã vị trí tỉnh thành" style="width:50%;margin-bottom: 5px;">
               <input name="weather" class="form-control" value="<?php if(!empty($data['City']['weather'])) echo $data['City']['weather'];?>" placeholder="Nhập Link" style="width:50%;margin-bottom: 5px;">
                  <input name="dataUid" class="form-control" value="<?php if(!empty($data['City']['dataUid'])) echo $data['City']['dataUid'];?>" placeholder="data-uid" style="width:50%;margin-bottom: 5px;">
   <?php // showEditorInput('weather', 'weather', @$data['City']['weather'], 2); ?>
                <h4>Hotline</h4>
                <?php showUploadFile('hotline', 'hotline', @$data['City']['hotline'],0);?>
                <h4>Hotel</h4>
                <?php showEditorInput('hotel', 'hotel',@$data['City']['hotel'] ,1);?>
                <?php // showEditorInput('hotline', 'hotline', @$data['City']['hotline'], 3); ?>
                <h4>Taxi</h4>
                <?php showUploadFile('taxi', 'taxi', @$data['City']['taxi'],2);?>
                <?php // showEditorInput('taxi', 'taxi', @$data['City']['taxi'], 4); ?>
                <h4>ATM</h4>
                <?php showEditorInput('ict', 'ict', @$data['City']['ict'], 5); ?>
                <h4>Hospital</h4>
                <?php showEditorInput('hospital', 'hospital', @$data['City']['hospital'],1);?>
                <h4>Entertaiment</h4>
                <?php showEditorInput('entertaiment', 'entertaiment',@$data['City']['entertaiment'],1);?>
            </div>

            <!-- Image -->
            <div id="tabs-3">
                <?php
                $image = $urlHomes . '/app/Plugin/city/images/no_image-100x100.jpg';
                ?>
                <table width="100%">
                    <tr>
                        <td>
                            <img
                                src="<?php echo !empty($data['City']['image'][0]) ? $data['City']['image'][0] : $image; ?>"
                                width="100" style="float: left; margin-right: 5px;"/>

                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image0', 'image[]', @$data['City']['image'][0], 3); ?>
                            </div>
                        </td>
                        <td>
                            <img
                                src="<?php echo !empty($data['City']['image'][1]) ? $data['City']['image'][1] : $image; ?>"
                                width="100" style="float: left; margin-right: 5px;"/>

                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image1', 'image[]', @$data['City']['image'][1], 4); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img
                                src="<?php echo !empty($data['City']['image'][2]) ? $data['City']['image'][2] : $image; ?>"
                                width="100" style="float: left; margin-right: 5px;"/>

                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image2', 'image[]', @$data['City']['image'][2], 5); ?>
                            </div>
                        </td>
                        <td>
                            <img
                                src="<?php echo !empty($data['City']['image'][3]) ? $data['City']['image'][3] : $image; ?>"
                                width="100" style="float: left; margin-right: 5px;"/>

                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image3', 'image[]', @$data['City']['image'][3], 6); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img
                                src="<?php echo !empty($data['City']['image'][4]) ? $data['City']['image'][4] : $image; ?>"
                                width="100" style="float: left; margin-right: 5px;"/>

                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image4', 'image[]', @$data['City']['image'][4], 7); ?>
                            </div>
                        </td>
                        <td>
                            <img
                                src="<?php echo !empty($data['City']['image'][5]) ? $data['City']['image'][5] : $image; ?>"
                                width="100" style="float: left; margin-right: 5px;"/>

                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image5', 'image[]', @$data['City']['image'][5], 8); ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="margin-bottom: 10px;">
                    <p><b>Linh ảnh 360</b></p>
                    <input type="text" name="anh360" id='title' value="<?php echo @$data['City']['anh360']; ?>"
                           class="form-control"/>
                </div>
                <div style="margin-bottom: 10px;">
                    <p><b>ID video 360</b> (Chỉ up id của video trên Youtube, ví dụ: RhrIvCTO3N0)</p>
                    <input type="text" name="video360" id='title' value="<?php echo @$data['City']['video360']; ?>"
                           class="form-control" placeholder="Nhập ID của video trên Youtube"/>
                </div>
            </div>

            <!-- Other Information -->
            <div id="tabs-6">
                <div class="col-md-6">
                    Hình ảnh 1 (Kích thước 555x320)
                    <img
                        src="<?php echo isset($data['City']['image_trainghiem1']) ? $data['City']['image_trainghiem1'] : $image ?>"
                        width="100" style="float: left; margin-right: 5px;"/>

                    <div style="margin-top: 37px;">
                        <?php showUploadFile('image_trainghiem1', 'image_trainghiem1', @$data['City']['image_trainghiem1'], 9); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    Hình ảnh 2 (Kích thước 555x320)
                    <img
                        src="<?php echo isset($data['City']['image_trainghiem2']) ? $data['City']['image_trainghiem2'] : $image ?>"
                        width="100" style="float: left; margin-right: 5px;"/>

                    <div style="margin-top: 37px;">
                        <?php showUploadFile('image_trainghiem2', 'image_trainghiem2', @$data['City']['image_trainghiem2'], 10); ?>
                    </div>
                </div>
                <hr>
                <br>
                <hr>
                <br>
                <h4>Trải nghiệm 1</h4>
<!--                <textarea class="form-control" name="trainghiem1" cols="59"-->
<!--                          rows="15">--><?php //echo (isset($data['City']['trainghiem1'])) ? $data['City']['trainghiem1'] : ''; ?><!--</textarea>-->
                <?php
                showEditorInput('trainghiem1', 'trainghiem1', @$data['City']['trainghiem1'],1);
                ?>

                <h4>Trải nghiệm 2</h4>
<!--                <textarea class="form-control" name="trainghiem2" cols="59"-->
<!--                          rows="15">--><?php //echo (isset($data['City']['trainghiem2'])) ? $data['City']['trainghiem2'] : ''; ?><!--</textarea>-->
                <?php
                                showEditorInput('trainghiem2', 'trainghiem2', @$data['City']['trainghiem2'],1);
                ?>

                <h4>Trải nghiệm 3</h4>
<!--                <textarea class="form-control" name="trainghiem3" cols="59"-->
<!--                          rows="15">--><?php //echo (isset($data['City']['trainghiem3'])) ? $data['City']['trainghiem3'] : ''; ?><!--</textarea>-->
                <?php
                showEditorInput('trainghiem3', 'trainghiem3', @$data['City']['trainghiem3'],1);
                ?>  
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;">
            <button type="submit" class="btn btn-primary">Sửa</button>
        </div>
    </form>
</div>

