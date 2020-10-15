<style>
    .tableList{
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
        border-spacing: 0;
        border-top: 1px solid #bcbcbc;
        border-left: 1px solid #bcbcbc;
    }
    .tableList td{
        padding: 5px;
        border-bottom: 1px solid #bcbcbc;
        border-right: 1px solid #bcbcbc;
    }
</style>

<?php
$breadcrumb = array('name' => 'Notification Setting',
    'url' => $urlPlugins . 'admin/mobileAppApi-notification-listNotification.php',
    'sub' => array('name' => 'List Notification')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="thanhcongcu">
    <div class="congcu" onclick="addDataNew();">
        <span>
            <input type="image"  src="<?php echo $webRoot; ?>images/add.png" />
        </span>
        <br/>
        Add
    </div>

</div>
<div class="clear"></div>
<br />

<div class="taovien" >
    <form action="" method="post" name="listForm">
        <p style="color: red;"><?php echo @$mess; ?></p>
        <script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
        <table id="listTable" cellspacing="0" class="tableList">

            <tr>
                <td align="center" width="10">View</td>
                <td align="center" width="100" >Notification</td>
                <td align="center" width="100">Link</td>
                <td align="center" width="30">Action</td>
            </tr>
            <?php
            if (!empty($listData)) {
                foreach ($listData as $components) {
                    ?>
                    <tr>
                        <td align="center" ><?php echo $components['Notification']['view']; ?></td>
                        <td height="40"><?php echo $components['Notification']['notification']; ?></td>
                        <td><?php echo $components['Notification']['link']; ?></td>
                        <td align="center" >
                            <input class="input" type="button" value="Edit" onclick="changeName('<?php echo $components['Notification']['id']; ?>', '<?php echo $components['Notification']['notification']; ?>', '<?php echo $components['Notification']['link']; ?>');">
                            &nbsp;
                            <input class="input" type="button" value="Delete" onclick="deleteData('<?php echo $components['Notification']['id']; ?>');">
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

        </table>
    </form>
    
    <p>
        <?php
            if($page>5){
                    $startPage= $page-5;
            }else{
                    $startPage= 1;
            }

            if($totalPage>$page+5){
                    $endPage= $page+5;
            }else{
                    $endPage= $totalPage;
            }

            echo '<a href="'.$urlPage.$back.'">Previous Page</a> ';
            for($i=$startPage;$i<=$endPage;$i++){
                    echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
            }
            echo ' <a href="'.$urlPage.$next.'">Next Page</a> ';

            echo 'Total Page: '.$totalPage;
        ?>
    </p>
</div>
<div id="themData">
    <form method="post" action="" name="listForm">
        <input type="hidden" value="" name="id" id="idData" />
        <p>Notification</p>
        <input type='text' id='notification' name="notification" value='' placeholder="notification" style="width: 200px;" />
        <p>Link</p>
        <input type='text' id='link' name="link" value='' placeholder="link" style="width: 200px;" />
        <br/><br/>
        <center><input type='submit' value='Lưu' class='input' /></center>
    </form>
</div>

<script type="text/javascript">
    var urlDelete = "<?php echo $urlPlugins.'admin/mobileAppApi-notification-deleteNotification.php'; ?>";
    var urlNow = "<?php echo $urlNow;?>";

    function changeName(id, notification, link)
    {
      
        document.getElementById("idData").value = id;
        document.getElementById("notification").value = notification;
        document.getElementById("link").value = link;

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
        document.getElementById("notification").value = '';
        document.getElementById("link").value = '';

        $('#themData').lightbox_me({
            centered: true,
            onLoad: function () {
                $('#themData').find('input:first').focus()
            }
        });
    }

    function deleteData(id)
    {
        var r = confirm("Are You Sure You Want To Remove ?");
        if (r == true)
        {
            $.ajax({
                type: "POST",
                url: urlDelete,
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
</div>