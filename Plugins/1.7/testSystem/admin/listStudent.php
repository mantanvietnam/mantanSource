<?php
$breadcrumb = array
    (
    'name' => 'Danh sách học sinh',
    'url' => '/plugins/admin/Studentystem-admin-listStudent.php',
    'sub' => array('name' => 'Danh sách học sinh')
);
addBreadcrumbAdmin($breadcrumb);
?> 
<div class="clear"></div>
<div id="content">
    <form action="" method="post" class="taovienLimit">
    </form>
    <div class="col-sm-12">
        <?php
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 2: echo '<p style="color:red;">Sửa tài khoản thành công!</p>';
                    break;
                case -2: echo '<p style="color:red;">Sửa tài khoản không thành công!</p>';
                    break;
                case 3: echo '<p style="color:red;">Xóa tài khoản thành công!</p>';
                    break;
            }
        }
        ?>
    </div>
    <table id="listTin" cellspacing="0" class="table table-striped">
        <tr>
            <td align="center">STT</td>
            <td align="center">Họ và tên </td>
             <td align="center">Tên tài khoản </td>
            <td align="center">Giới tính</td>
            <td align="center" width="160">Lựa chọn</td>
        </tr>
        <?php
        global $urlPlugins;

        if (isset($listStudent)) {
            $dem = 0;
            foreach ($listStudent as $value) {

                $dem ++;
                ?>
                <tr>
                    <td align="center"><?php echo $dem; ?></td>
                    <td align="center"><?php if (!empty($value['Student']['fullname'])) echo $value['Student']['fullname']; ?></td>
                     <td align="center"><?php if (!empty($value['Student']['username'])) echo $value['Student']['username']; ?></td>
                    <td align="center">
                    <?php
                    	if ($value['Student']['sex']==0) {
                    		echo "nữ";
                    	}else{
                    		echo "nam";
                    	}
                    	 ?></td>
                    <td align="center" width="160">
                        <a href="<?php echo $urlPlugins . 'admin/testSystem-admin-editStudent.php?idEditStudent=' . $value['Student']['id']; ?>" class="btn btn-danger"><i class="fa fa-pencil"></i></a>
                        <a href="<?php echo $urlPlugins . 'admin/testSystem-admin-deleteStudent.php?idDeleteStudent=' . $value['Student']['id']; ?>" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                    </td>

                </tr>
                <?php
            }
        }
        ?>
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

    echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
    for ($i = $startPage; $i <= $endPage; $i++) {
        echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
    }
    echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';

    echo 'Tổng số trang: ' . $totalPage;
    ?> 
</div>