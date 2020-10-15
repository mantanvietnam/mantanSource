<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>
<link href="<?php echo $urlHomes.'app/Plugin/mantanHotel/style.css';?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Loại khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelTypes.php',
    'sub' => array('name' => 'Danh sách loại khách sạn')
);
addBreadcrumbAdmin($breadcrumb);
?>    
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
                <td align="center" width="40">STT</td>
                <td align="center" width="120">Mã loại</td>
                <td align="center" width="250">Loại khách sạn</td>
                <td align="center" width="">Mô tả</td>
                <td align="center" width="">Chọn</td>
            </tr>
            <?php
			
            if(!empty($listData['Option']['value']['allData'])){
                foreach ($listData['Option']['value']['allData'] as $components) {
                    
                    ?>
            <tr id="trList<?php if(isset($components['id']))echo $components['id']; ?>">
                        <td align="center" ><?php if(isset($components['id'])) echo $components['id']; ?> </td>
                        <td height="" id="code<?php if(isset($components['id'])) echo $components['id']; ?>"><?php if(isset($components['code'])) echo $components['code']; ?></td>
                        <td height="" id="name<?php if(isset($components['id'])) echo $components['id']; ?>"><?php if(isset($components['name'])) echo $components['name']; ?></td>
                        <td height="" id="describe<?php if(isset($components['id'])) echo $components['id']; ?>"><?php if(isset($components['describe'])) echo $components['describe']; ?></td>
                        <td align="center" width="165" >
                            <input class="input" type="button"  value="Sửa" onclick="changeName(<?php if(isset($components['id'])) echo $components['id']; ?>, '<?php echo $components['code']; ?>','<?php echo $components['name']; ?>','<?php echo $components['describe']; ?>');">
                            &nbsp;
                            <input class="input" type="button" value="Xóa" onclick="deleteData('<?php if(isset($components['id'])) echo $components['id']; ?>');">
                        </td>
                    </tr>
                    <?php
                }
            }else{
                echo '<tr><td colspan="5">Chưa có dữ liệu </td></tr>';
            }
            ?>

        </table>
    </form>
</div>

<div id="themData" >
    <form method="post" action="">
        <input type="hidden" value="" name="id" id="idData"  />
        <span >Mã loại</span><span style='margin-left: 53px;'><input type='text' id='codeData' name="code" value=''  onkeyup="checkSpaceInKeyUp('nameData');"required="" /></span></br></br>
        <span>Loại khách sạn</span><span style='margin-left: 4px;'><input type='text' id='nameData' name="name" value=''  required="" /></span></br></br>
        <span>Mô tả</span><span style='margin-left: 64px;'><textarea rows='3' cols="25" id='describeData' name="describe" ></textarea></span></br></br>
        <input type='submit' value='Lưu' class='input' />
    </form>
</div>

<script type="text/javascript">
    var urlDeleteData = "<?php echo $urlPlugins . 'admin/mantanHotel-admin-hotel-deleteHotelTypes.php'; ?>";
    var urlNow = "<?php echo $urlNow; ?>";

    function changeName(id,code,name,describe)
    {
        document.getElementById("idData").value = id;
        document.getElementById("codeData").value = code;
        document.getElementById("nameData").value = name;
        document.getElementById("describeData").value = describe;
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
        document.getElementById("codeData").value = '';
        document.getElementById("nameData").value = '';
        document.getElementById("describeData").value = '';

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
