<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(function () {
        $("#tabs").tabs();
    });
</script>
<script type="text/javascript">

    function saveData()
    {
        var tieude = document.getElementById("title").value;

        if (tieude == '')
        {
            alert('Bạn phải nhập thông tin bên dưới!');
        } else
        {

            document.dangtin.submit();

        }

    }


</script>
<link href="<?php echo $urlHomes . 'app/Plugin/project/style.css'; ?>" rel="stylesheet">

<?php
$breadcrumb = array('name' => 'List Project',
    'url' => $urlPlugins . 'admin/project-listProject.php',
    'sub' => array('name' => 'Add Project')
);
addBreadcrumbAdmin($breadcrumb);
$image = $urlHomes . '/app/Plugin/project/images/no_image-100x100.jpg';
?> 

<div class="thanhcongcu">
    <div class="congcu" onclick="saveData();">
        <input type="hidden" id="idChange" value="" />
        <span id="save">
            <input type="image" src="<?php echo $webRoot; ?>images/save.png" />
        </span>
        <br/>
        Save
    </div>

</div>

<div class="clear"></div>

<div id="content">
    <form action="" method="POST" name="dangtin" enctype="multipart/form-data">

        <input type="hidden" value="" name="id" />


        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Thông tin</a></li>
                <li><a href="#tabs-3">Hình ảnh</a></li>
                <li><a href="#tabs-4">IDEAS</a></li>
                <li><a href="#tabs-2">Quảng cáo</a></li>

            </ul>
            <!-- Project Description -->
            <div id="tabs-1">
                <table width="100%">
                    <tr>
                        <td valign="top">
                            <div style="margin-bottom: 10px;">
                                <p><b>Tên</b> (Bắt buộc)</p>
                                <input type="text" name="name" id='title' value="" class="form-control" required="" />
                            </div>
                            <div style="margin-bottom: 10px;">
                                <p><b>Mô tả</b> (Bắt buộc)</p>
                                <input type="text" name="desc_1" id='title' value="" class="form-control" required="" />
                            </div>
                            <div style="margin-bottom: 10px;">
                                <p><b>Chọn top</b></p>
                                <select name="top" class="form-control col-sm-3">
                                    <option value="0">Lựa chọn</option>
                                    <option value="1">Top1</option>
                                    <option value="2">Top2</option>
                                    <option value="3">Top3</option>
                                </select>
                            </div>
                            <?php
                            $modelCity = new City();
                            $listCity = $modelCity->find('all', array(
                                'fields' => array('id', 'name', 'khuvuc')
                            ));
                            ?>
                            <div class="form-group">
                                <p><b>City</b></p>
                                <div class="c">
                                    <select name="city" class="form-control" required=""> 
                                        <option value="">Lựa chọn</option>
                                        <?php
                                        if (!empty($listCity)) {
                                            foreach ($listCity as $city) {
                                                ?>
                                                <option value="<?php echo $city['City']['id'] ?>"><?php echo $city['City']['name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div> 
                            <div class="form-group">
                                <p><b>Chuyên mục</b> (Bắt buộc)</p>
                                <div class="c">
                                    <select name="chuyenmuc" class="form-control" required=""> 
                                        <option value="">Chọn chuyên mục</option>
                                        <option value="vanhoa_connguoi">VĂN HÓA & CON NGƯỜI</option>
                                        <option value="kientruc_dothi">KIẾN TRÚC & ĐÔ THỊ</option>
                                        <option value="thiennhien_sinhthai">THIÊN NHIÊN & SINH THÁI</option>
                                        <option value="doisong_xahoi">ĐỜI SỐNG & XÃ HỘI</option>
                                        <option value="thuonghieu">THƯƠNG HIỆU VIỆT NAM</option>
                                    </select>
                                </div>

                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>     
                            <p style="clear: both;"><b>Mô tả ngắn</b> (Nên có)</p>
                            <textarea class="form-control"  name="desc" cols="59" rows="10" required=""></textarea>
                            <br>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link Ảnh 360</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                                    <?php showUploadFile('image_video', 'image_video', '', 0); ?>

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link video giới thiệu (Chỉ up id của video trên Youtube, ví dụ: RhrIvCTO3N0)</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <input type="text" name="video" value="" class="form-control"  id="profileLastName">   

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <?php
                            $categoryNotice = changeNoticeCategoryToList(getListNoticeCategory());
                            ?>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Chuyên mục IMPACT</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <select name="category_diadanh" class="form-control" required=""> 
                                        <option value="">Chọn chuyên mục IMPACT</option>
                                        <?php
                                        foreach ($categoryNotice as $categoryLink) {
                                            echo '<option value="' . $categoryLink['id'] . '">' . $categoryLink['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>    
                            <p style="clear: both;"><b>Mô tả INSIGN</b></p>
                            <textarea class="form-control"  name="desc" cols="59" rows="10" required=""></textarea>
                            <br>


                </table>
            </div>
            <div id="tabs-2">
                <table width="100%">
                    <tr>
                        <td valign="top">

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Ảnh quảng cáo 1</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                                    <?php showUploadFile('quangcao1', 'quangcao1', '', 2); ?>

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link quảng cáo 1</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <input type="text" name="link_quangcao1" value="" class="form-control"  id="profileLastName">   

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Ảnh quảng cáo 2</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                                    <?php showUploadFile('quangcao2', 'quangcao2', '', 3); ?>

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link quảng cáo 2</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <input type="text" name="link_quangcao2" value="" class="form-control"  id="profileLastName">   

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Ảnh quảng cáo 3</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                                    <?php showUploadFile('quangcao3', 'quangcao3', '', 4); ?>

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link quảng cáo 3</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <input type="text" name="link_quangcao3" value="" class="form-control"  id="profileLastName">   

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Ảnh quảng cáo 4</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                                    <?php showUploadFile('quangcao4', 'quangcao4', '', 5); ?>

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link quảng cáo 4</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <input type="text" name="link_quangcao4" value="" class="form-control"  id="profileLastName">   

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Ảnh quảng cáo 5</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                                    <?php showUploadFile('quangcao5', 'quangcao5', '', 6); ?>

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">Link quảng cáo 5</label>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <input type="text" name="link_quangcao5" value="" class="form-control"  id="profileLastName">   

                                </div>
                                <div class="clear" style="margin-bottom:10px;"></div>
                            </div>
                            <hr>
                </table>
            </div>
            <div id="tabs-4">
                <hr>
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">IDEAS 1</label>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <p>Kích thước ảnh 350x233</p>
                        <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                        <?php showUploadFile('ideas1', 'ideas[]', '', 7); ?>

                    </div>
                    <div class="clear" style="margin-bottom:10px;"></div>
                </div>

                <textarea class="form-control"  name="ideas_desc[]" cols="59" rows="10"></textarea>
                <div class="clear" style="margin-bottom:10px;"></div>

                <hr>
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">IDEAS 2</label>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <p>Kích thước ảnh 350x233</p>
                        <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                        <?php showUploadFile('ideas2', 'ideas[]', '', 8); ?>

                    </div>
                    <div class="clear" style="margin-bottom:10px;"></div>
                </div>

                <textarea class="form-control"  name="ideas_desc[]" cols="59" rows="10"></textarea>
                <div class="clear" style="margin-bottom:10px;"></div>
                <hr>
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">IDEAS 3</label>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <p>Kích thước ảnh 350x233</p>
                        <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                        <?php showUploadFile('ideas3', 'ideas[]', '', 9); ?>

                    </div>
                    <div class="clear" style="margin-bottom:10px;"></div>
                </div>

                <textarea class="form-control"  name="ideas_desc[]" cols="59" rows="10"></textarea>
                <div class="clear" style="margin-bottom:10px;"></div>
                <hr>
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">IDEAS 4</label>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <p>Kích thước ảnh 350x233</p>
                        <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                        <?php showUploadFile('ideas4', 'ideas[]', '', 10); ?>

                    </div>
                    <div class="clear" style="margin-bottom:10px;"></div>
                </div>

                <textarea class="form-control"  name="ideas_desc[]" cols="59" rows="10"></textarea>
                <div class="clear" style="margin-bottom:10px;"></div>
                <hr>
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 col-xs-12 control-label" for="profileLastName">IDEAS 5</label>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <p>Kích thước ảnh 350x233</p>
                        <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                        <?php showUploadFile('ideas5', 'ideas[]', '', 11); ?>

                    </div>
                    <div class="clear" style="margin-bottom:10px;"></div>
                </div>

                <textarea class="form-control"  name="ideas_desc[]" cols="59" rows="10"></textarea>
                <div class="clear" style="margin-bottom:10px;"></div>
            </div>

            <!-- Image -->
            <div id="tabs-3">
                <?php
                $image = $urlHomes . '/app/Plugin/project/images/no_image-100x100.jpg';
                ?>
                <table width="100%">
                    <tr>
                        <td>Kích thước hình ảnh 1140x657</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image0', 'image[]', @$news['Project']['image'][0], 12); ?>
                            </div>
                        </td>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image1', 'image[]', @$news['Project']['image'][1], 13); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image2', 'image[]', @$news['Project']['image'][2], 14); ?>
                            </div>
                        </td>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image3', 'image[]', @$news['Project']['image'][3], 15); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image4', 'image[]', @$news['Project']['image'][4], 16); ?>
                            </div>
                        </td>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image5', 'image[]', @$news['Project']['image'][5], 17); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image6', 'image[]', @$news['Project']['image'][6], 18); ?>
                            </div>
                        </td>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image7', 'image[]', @$news['Project']['image'][7], 19); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image8', 'image[]', @$news['Project']['image'][8], 20); ?>
                            </div>
                        </td>
                        <td>
                            <img src="<?php echo $image; ?>" width="100" style="float: left; margin-right: 5px;"/> 
                            <div style="margin-top: 37px;">
                                <?php showUploadFile('image9', 'image[]', @$news['Project']['image'][9], 21); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </form>
</div>
