<link href="<?php echo $urlHomes . 'app/Plugin/project/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/project/script.js'; ?>"></script>
<?php
$breadcrumb = array('name' => 'Quản lý Project',
    'url' => $urlPlugins . 'admin/project-listProject.php',
    'sub' => array('name' => 'Tất cả Project')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div id="content2">
    <form action="" method="get" class="taovienLimit">
        <div class="col-sm-3">
            Tìm kiếm
            <select name="thanh-pho" class="form-control" style="width: auto;display: inline;margin-bottom: 15px;with:100px">
                <option value="">Lựa chọn</option>
                <?php
                $modelCity = new City();
                $city = $modelCity->find('all');
                if (!empty($city)) {
                    foreach ($city as $key => $tin) {
                        ?>
                        <option value="<?php if (!empty($tin['City']['id'])) echo $tin['City']['id']; ?>"><?php echo @$tin['City']['name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-sm-6">
            <input class="form-control" type="text"  name="dia-danh" placeholder="Địa danh">
        </div>
        <div class="col-sm-3">
            <input class="btn btn-default" type="submit" value="Tìm kiếm">
        </div>
    </form>
</div><br>
<div class="clear"></div>
<div id="content">
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 1: echo '<p style="color:red;">Thêm Project thành công!</p>';
                break;
            case -1: echo '<p style="color:red;">Thêm Project không thành công!</p>';
                break;
            case 3: echo '<p style="color:red;">Sửa Project thành công!</p>';
                break;
            case -3: echo '<p style="color:red;">Sửa Project không thành công!</p>';
                break;
            case 4: echo '<p style="color:red;">Xóa Project thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="duan" class="taovienLimit">
        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/project-addProject.php'; ?>" class="input">
            <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
        </a>  
        <table class="table table-bordered" style="border: 1px solid #ddd!important; margin-top: 10px;">  
            <thead> 
                <tr> 

                    <th>STT</th> 
                    <th>Tên</th> 
                    <th>Top</th> 
                    <th>City</th> 
                    <th>Chuyên mục</th> 
                    <!--<th>Mô tả</th>--> 

                    <th style="text-align: center;">Chọn</th>  
                </tr> 
            </thead>
            <tbody> 
                <?php
                $modelCity = new City();
                if (!empty($listData)) {
                    foreach ($listData as $key => $tin) {
                        if (!empty($tin['Project']['chuyenmuc'])) {
                            if ($tin['Project']['chuyenmuc'] == 'vanhoa_connguoi') {
                                $name = 'VĂN HÓA & CON NGƯỜI';
                            } elseif ($tin['Project']['chuyenmuc'] == 'kientruc_dothi') {
                                $name = 'KIẾN TRÚC & ĐÔ THỊ';
                            } elseif ($tin['Project']['chuyenmuc'] == 'thiennhien_sinhthai') {
                                $name = 'THIÊN NHIÊN & SINH THÁI';
                            } elseif ($tin['Project']['chuyenmuc'] == 'doisong_xahoi') {
                                $name = 'ĐỜI SỐNG & XÃ HỘI';
                            } elseif ($tin['Project']['chuyenmuc'] == 'thuonghieu') {
                                $name = 'THƯƠNG HIỆU VIỆT NAM';
                            }
                        } else {
                            $name = '';
                        }
                        if(!empty($tin['Project']['city'])){
                            $city = $modelCity->getCity($tin['Project']['city']);
                        }
                        ?>

                        <tr> 


                            <td class=""><?php echo $key + 1; ?></td> 
                            <td class="break_word"><?php echo @$tin['Project']['name']; ?></td> 
                            <td class="break_word"><?php
                                if (!empty($tin['Project']['top']) && $tin['Project']['top'] == 1) {
                                    echo 'Top 1';
                                } else if (!empty($tin['Project']['top']) && $tin['Project']['top'] == 2) {
                                    echo 'Top 2';
                                } else if (!empty($tin['Project']['top']) && $tin['Project']['top'] == 3) {
                                     echo 'Top 3';
                                } else {
                                    echo '';
                                }
                                ?></td> 
                            <td class="break_word"><?php echo @$city['City']['name'] ?></td> 
                            <td class="break_word"><?php echo @$name; ?></td> 
                            <!--<td style="max-width:15em;"><?php echo @$tin['Project']['desc_1']; ?></td>--> 

                            <td class="break_word" align="center">
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/project-editProject.php?id=' . $tin['Project']['id']; ?>" class="input"  >Sửa</a>  
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/project-deleteProject.php?id=' . $tin['Project']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
                            </td> 

                        </tr> 


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center" colspan="8">Chưa có Project nào.</td>
                    </tr>
                <?php }
                ?>
            </tbody> 
        </table>
        <p>
            <?php
            if ($page > 5) {
                $startPage = $page - 5;
            } else {
                $startPage = 1;
            }

            if ($totalPage > $page + 5) {
                $endPage = $page + 5;
            } else {
                $endPage = $totalPage;
            }

            echo '<a href="' . $urlPage . $back . '">' . 'Trang trước' . '</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlPage . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlPage . $next . '">' . 'Trang sau' . '</a> ';

            echo 'Tổng số trang' . ': ' . $totalPage;
            ?>
        </p>
    </form>
</div>