<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>
<?php
$breadcrumb = array('name' => 'Tỉnh thành',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-city-listCityAdmin.php',
    'sub' => array('name' => $listData['Option']['value']['allData'][$_GET['idCity']]['name'],
					'sub' => array('name'=>'Quận huyện')
					)
);
addBreadcrumbAdmin($breadcrumb);
?>  


<div class="thanhcongcu">
    <div class="congcu" onclick="addDataNew();">
        <span>
            <input type="image"  src="<?php echo $webRoot; ?>images/add.png" / required>
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
                <td align="center" width="150">Quận huyện</td>
                <td align="center" width="30">Chọn</td>
            </tr>
            <?php
			if(!empty($_GET['idCity'])){
				$idCity = $_GET['idCity'];
			}
		
            if(!empty($listData['Option']['value']['allData'][$idCity]['district'])){
                foreach ($listData['Option']['value']['allData'][$idCity]['district'] as $components) {
                    ?>
                    <tr>
                        <td align="center" ><?php echo $components['id']; ?></td>
                        <td><?php echo $components['name']; ?></td>
                        <td align="center" width="165" >
                            <input class="input" type="button" value="Sửa" onclick="changeName(<?php if (isset($components['id'])) echo $components['id']; ?>, '<?php echo $components['name']; ?>');">
                            &nbsp;
                            <input class="input" type="button" value="Xóa" onclick="deleteData(<?php if (isset($components['id'])) echo $components['id']; ?>);">
                        </td>
                    </tr>
                   <?php
				}
			}
            else{
                echo '<tr><td colspan="4">Chưa có dữ liệu Quận Huyện</td></tr>';
            }
            ?>
        </table>
    </form>
</div>
<div id="themData">
    <form method="post" action="">
        <input type="hidden" value="" name="id" id="idData" />
        Tên Quận Huyện:<br /><br /><input type='text' id='nameData' name="name" value='' />&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
    </form>
</div>
<script type="text/javascript">
    var urlDeleteData = "<?php echo $urlPlugins . 'admin/mantanHotel-admin-city-deleteDistrictAdmin.php'; ?>";
	var idCity= <?php echo $_GET['idCity'];?>;

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
                data: {id: id,idCity:idCity}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }

    }
</script>