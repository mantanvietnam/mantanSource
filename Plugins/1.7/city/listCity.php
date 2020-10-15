<link href="<?php echo $urlHomes . 'app/Plugin/city/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/city/script.js'; ?>"></script>
<?php
$breadcrumb = array('name' => 'Quản lý City',
    'url' => $urlPlugins . 'admin/city-listCity.php',
    'sub' => array('name' => 'Tất cả City')
);
addBreadcrumbAdmin($breadcrumb);
?> 
<div id="content2">
    <form action="" method="get" class="taovienLimit">
        <div class="col-sm-4">
            Tìm kiếm
            <select name="khu-vuc" class="form-control" style="width: auto;display: inline;margin-bottom: 15px;with:100px">
                <option value="">Lựa chọn</option>
                <?php
                if (!empty($listData)) {
                    foreach ($listData as $key => $tin) {
                        if ($tin['City']['khuvuc'] == 'TB') {
                            $name = 'Tây Bắc';
                        } elseif ($tin['City']['khuvuc'] == 'DB') {
                            $name = 'Đông Bắc';
                        } elseif ($tin['City']['khuvuc'] == 'BTB') {
                            $name = 'Bắc Trung Bộ';
                        } elseif ($tin['City']['khuvuc'] == 'DHNTB') {
                            $name = 'Nam Trung Bộ';
                        } elseif ($tin['City']['khuvuc'] == 'TN') {
                            $name = 'Tây Nguyên';
                        } elseif ($tin['City']['khuvuc'] == 'MN') {
                            $name = 'Đông Nam Bộ';
                        } elseif ($tin['City']['khuvuc'] == 'DBSCL') {
                            $name = 'ĐB Sông Cửu Long';
                        } elseif ($tin['City']['khuvuc'] == 'QDHS') {
                            $name = 'Quần Đảo Hoàng Sa';
                        } elseif ($tin['City']['khuvuc'] == 'QDTS') {
                            $name = 'Quần Đảo Trường Sa';
                        }
                        ?>
                        <option value="<?php if (!empty($tin['City']['khuvuc'])) echo $tin['City']['khuvuc']; ?>"><?php echo @$name; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-sm-5">
            <input class="form-control" type="text"  name="tinh-thanh" placeholder="Tỉnh thành">
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
            case 1: echo '<p style="color:red;">Thêm City thành công!</p>';
                break;
            case -1: echo '<p style="color:red;">Thêm City không thành công!</p>';
                break;
            case 3: echo '<p style="color:red;">Sửa City thành công!</p>';
                break;
            case -3: echo '<p style="color:red;">Sửa City không thành công!</p>';
                break;
            case 4: echo '<p style="color:red;">Xóa City thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="duan" class="taovienLimit">
        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/city-addCity.php'; ?>" class="input">
            <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
        </a>  
        <table class="table table-bordered" style="border: 1px solid #ddd!important; margin-top: 10px;">  
            <thead> 
                <tr> 

                    <th>STT</th> 
                    <th>Tên</th> 
                    <th>Khu vực</th> 
                    <th style="text-align: center;">Chọn</th>  
                </tr> 
            </thead>
            <tbody> 
                <?php
                if (!empty($listData)) {
                    foreach ($listData as $key => $tin) {
                        if ($tin['City']['khuvuc'] == 'TB') {
                            $name = 'Tây Bắc';
                        } elseif ($tin['City']['khuvuc'] == 'DB') {
                            $name = 'Đông Bắc';
                        } elseif ($tin['City']['khuvuc'] == 'BTB') {
                            $name = 'Bắc Trung Bộ';
                        } elseif ($tin['City']['khuvuc'] == 'DHNTB') {
                            $name = 'Nam Trung Bộ';
                        } elseif ($tin['City']['khuvuc'] == 'TN') {
                            $name = 'Tây Nguyên';
                        } elseif ($tin['City']['khuvuc'] == 'MN') {
                            $name = 'Đông Nam Bộ';
                        } elseif ($tin['City']['khuvuc'] == 'DBSCL') {
                            $name = 'ĐB Sông Cửu Long';
                        } elseif ($tin['City']['khuvuc'] == 'QDHS') {
                            $name = 'Quần Đảo Hoàng Sa';
                        } elseif ($tin['City']['khuvuc'] == 'QDTS') {
                            $name = 'Quần Đảo Trường Sa';
                        }
                        ?>
                        <tr> 
                            <td class=""><?php echo $key + 1; ?></td> 
                            <td class="break_word"><?php echo @$tin['City']['name']; ?></td> 
                            <td class="break_word"><?php echo @$name; ?></td> 

                            <td class="break_word" align="center">
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/city-editCity.php?id=' . $tin['City']['id']; ?>" class="input"  >Sửa</a>  
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/city-deleteCity.php?id=' . $tin['City']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
                            </td> 

                        </tr> 


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center" colspan="8">Chưa có City nào.</td>
                    </tr>
                <?php }
                ?>
            </tbody> 
        </table>
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