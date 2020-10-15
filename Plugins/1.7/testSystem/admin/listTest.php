<link href="<?php echo $urlHomes . 'app/Plugin/testSystem/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array
    (
    'name' => 'Quản lý bài thi',
    'url' => '/plugins/admin/testSystem-admin-listTest.php',
    'sub' => array('name' => 'Danh sách đề thi')
);
addBreadcrumbAdmin($breadcrumb);

function listCat($cat, $sau, $parent, $categorySelect='') {
    debug($categorySelect.' - '.$cat['id']);
    if ($cat['id'] > 0) {
        if ($cat['id'] != $categorySelect) {
            echo '<option id="' . $parent . '" value="' . $cat['id'] . '">';
        } else {
            echo '<option selected="" id="' . $parent . '" value="' . $cat['id'] . '">';
        }

        for ($i = 1; $i <= $sau; $i++) {
            echo '&nbsp&nbsp&nbsp&nbsp';
        }
        echo $cat['name'] . '</option>';
    }
    if(!empty($cat['sub'])){
    foreach ($cat['sub'] as $sub) {
        listCat($sub, $sau + 1, $cat['id'],$categorySelect);
    }}
}
?> 
<div class="clear"></div>
<div id="content">
    <div class="col-sm-12" style="margin:5px 5px;">
        <?php
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: echo '<p style="color:red;">Thêm đề thi thành công!</p>';
                    break;
                case 2: echo '<p style="color:red;">Sửa đề thi thành công!</p>';
                    break;
                case -2: echo '<p style="color:red;">Sửa đề thi không thành công!</p>';
                    break;
                case 3: echo '<p style="color:red;">Xóa đề thi thành công!</p>';
                    break;
            }
        }
        ?>
    </div>
    <form action="" method="post" class="taovienLimit">

        <div class="col-sm-6">
            <input type="hidden"  name="id" value="<?php if (isset($dataTest['Tests']['id'])) echo $dataTest['Tests']['id']; ?>">
            <div class="col-sm-12">
                <label ><b>Thời gian thi: </b></label>
                <input type="number" name="time" value="<?php if (isset($dataTest['Tests']['time'])) echo $dataTest['Tests']['time']; ?>" class="form-control" placeholder="Nhập thời gian thi (tính bằng phút)" required=""><br/>
            </div>
            <div class="col-sm-12">
                <label ><b>Tên đề thi : </b></label>
                <input type="text" name="name" value="<?php if (isset($dataTest['Tests']['name'])) echo $dataTest['Tests']['name']; ?>" class="form-control" placeholder="Nhập tên đề thi" required=""><br/>
            </div>

            <div class="col-sm-12">
                <label ><b>số câu lượng câu hỏi: </b></label>
                <input type="number" name="numberQuestion" value="<?php if (isset($dataTest['Tests']['numberQuestion'])) echo $dataTest['Tests']['numberQuestion']; ?>" class="form-control" placeholder="Nhập sô lượng câu hỏi bài thi" required=""><br/>
            </div>
            <div class="col-sm-12">
                <p><b>Hình minh họa: </b></p>
                <?php showUploadFile('images', 'images', @$dataTest['Tests']['images'], 0); ?>
                <br/>
            </div>
            <div class="col-sm-12" style="margin-top:15px;">
                <span><b>Hiển thị : </b></span>
                <input type="radio" name="lock" value="1" <?php if (isset($dataTest['Tests']['lock']) && $dataTest['Tests']['lock'] == 1) echo 'checked'; ?>> Kích hoạt 
                <input type="radio" name="lock" value="0"<?php if (isset($dataTest['Tests']['lock']) && $dataTest['Tests']['lock'] == 0) echo 'checked'; ?>> Khóa
            </div>

            <div class="col-sm-4" style="margin-top:25px;">
                <input type="submit"  value="Lưu" class=" btn btn-primary"  style="margin-bottom:20px">
            </div>

        </div>
        <div class="col-sm-6">


            <div class="col-sm-12">
                <p ><b>Loại đề thi : </b></p>
                <select style="float:left;margin-right: 5px;" name="typeTest" class="form-control">
                    <option value="">Lựa chọn loại đề thi</option>
                    <?php
                    foreach ($listTypeTest['Option']['value']['category'] as $cat) {
                        listCat($cat, 1, 0,@$dataTest['Tests']['typeTest']);
                    }
                    ?>
                </select> <br>
            </div>
            <div class="col-sm-12">
                <p><b>Mô tả đề thi</b></p>
                <textarea class="form-control" rows="5" name="description"><?php if (isset($dataTest['Tests']['description'])) echo $dataTest['Tests']['description']; ?></textarea>
            </div>
            <div class="col-sm-12" style="margin-top:15px;">
                <span><b>Nổi bật : </b></span>
                <input type="radio" name="hot" value="1" <?php if (isset($dataTest['Tests']['hot']) && $dataTest['Tests']['hot'] == 1) echo 'checked'; ?>> Đúng 
                <input type="radio" name="hot" value="0"<?php if (isset($dataTest['Tests']['hot']) && $dataTest['Tests']['hot'] == 0) echo 'checked'; ?>> Sai
            </div>
        </div>
    </form>


    <table id="listTin" cellspacing="0" class="table table-striped">
        <tr>
            <td align="center">#</td>
            <td align="center">Tên đề thi</td>
            <td align="center">Loại đề thi</td>
            <td align="center">Thêm câu hỏi vào đề thi</td>
            <td align="center">Xuất đề thi</td>
            <td align="center">Thời gian</td>
            <td align="center" width="160">Lựa chọn</td>
        </tr>
        <?php
        global $urlPlugins;
        if (isset($listTest)) {
            $dem = 0;
            foreach ($listTest as $value) {

                $dem ++;
                ?>
                <tr>
                    <td align="center"><?php echo $dem; ?></td>
                    <td align="center"><a href="<?php echo $urlPlugins . 'admin/testSystem-admin-listQuestions.php?idTest=' . $value['Tests']['id'] ?>"><?php if (!empty($value['Tests']['name'])) echo $value['Tests']['name']; ?></a></td>

                    <td align="center"><?php if (!empty($typeTest['Option']['value']['allData'][$value['Tests']['typeTest']])) echo $typeTest['Option']['value']['allData'][$value['Tests']['typeTest']]['name']; ?></td>


                    <td align="center"><a href="<?php echo $urlPlugins . 'admin/testSystem-admin-addQuestion.php?idTest=' . $value['Tests']['id']; ?>">Thêm câu hỏi</a></td>
                    <td align="center"><a href="<?php echo $urlHomes . 'exportExam?idTest=' . $value['Tests']['id']; ?>">Xuất đề thi</a></td>
                    <td align="center"><?php if (!empty($value['Tests']['time'])) echo $value['Tests']['time']; ?></td>
                    <td align="center" width="160">
                        <a href="<?php echo $urlPlugins . 'admin/testSystem-admin-listTest.php?idEditTest=' . $value['Tests']['id']; ?>" class="btn btn-danger"><i class="fa fa-pencil"></i></a>
                        <a href="<?php echo $urlPlugins . 'admin/testSystem-admin-deleteTest.php?idDeleteTest=' . $value['Tests']['id']; ?>" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
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