<?php
$breadcrumb = array('name' => 'Loại khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelCategory.php',
    'sub' => array('name' => 'Danh sách loại khách sạn')
);
addBreadcrumbAdmin($breadcrumb);
?>    
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>
<link href="<?php echo $urlHomes.'app/Plugin/mantanHotel/style.css';?>" rel="stylesheet">
<div class="thanhcongcu">
    <div class="congcu" onclick="addDataNew();">
        <span>
            <input type="image"  src="<?php echo $webRoot; ?>images/add.png" />
        </span>
        <br/>
        Thêm
    </div>

</div>
<div class="clear"></div>

<div class="taovien" >
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

            <tr>
                <td align="center" width="30">STT</td>
                <td align="center" width="150">Tỉnh thành</td>
                <td align="center" width="30">Chọn</td>
            </tr>
            <?php
			
            if(!empty($listData['Option']['value']['allData'])){
                foreach ($listData['Option']['value']['allData'] as $components) {
                    ?>
            <tr id="trList<?php if(isset($components['id']))echo $components['id']; ?>">
                        <td align="center" ><?php if(isset($components['id'])) echo $components['id']; ?> </td>
                        <td height="40" id="name<?php if(isset($components['id'])) echo $components['id']; ?>"><?php if(isset($components['id'])) echo $components['name']; ?></td>
                        <td align="center" width="165" >
                            <input class="input" type="button" onkeyup="checkSpaceInKeyUp('user');" value="Sửa" onclick="changeName(<?php if(isset($components['id'])) echo $components['id']; ?>, '<?php echo $components['name']; ?>');">
                            &nbsp;
                            <input class="input" type="button" value="Xóa" onclick="deleteData('<?php if(isset($components['id'])) echo $components['id']; ?>');">
                        </td>
                    </tr>
                    <?php
                }
            }else{
                echo '<tr><td colspan="4">Chưa có dữ liệu </td></tr>';
            }
            ?>

        </table>
    </form>
</div>

<div id="themData">
    <form method="post" action="">
        <input type="hidden" value="" name="id" id="idData" onkeyup="checkSpaceInKeyUp('user');" required />
        Loại khách sạn<br /><br /><input type='text' id='nameData' name="name" value='' />&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
    </form>
</div>

<script type="text/javascript">
    var urlDeleteData = "<?php echo $urlPlugins . 'admin/mantanHotel-admin-city-deletetHotelCategory.php'; ?>";
    var urlNow = "<?php echo $urlNow; ?>";

    function changeName(id, name)
    {
        document.getElementById("idData").value = id;
        document.getElementById("nameData").value = name;

        $('#themData').lightbox_me({
            centered: true,
            onLoad: function () {
                $('#themData').find('input:first').focus()
            }
        });
    }

    function addDataNew()
    {
        document.getElementById("idData").value = '';
        document.getElementById("nameData").value = '';

        $('#themData').lightbox_me({
            centered: true,
            onLoad: function () {
                $('#themData').find('input:first').focus()
            }
        });
    }

    function deleteData(id)
    {
        var r = confirm("Bạn có chắc chắn muốn xóa không ?");
        if (r == true)
        {
            $.ajax({
                type: "POST",
                url: urlDeleteData,
                data: {id: id}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }

    }
</script>
