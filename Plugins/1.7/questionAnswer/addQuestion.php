<script type="text/javascript">
    function saveData()
    {

        document.dangtin.submit();

    }
</script>

<link href="<?php echo $urlHomes.'app/Plugin/questionAnswer/style.css';?>" rel="stylesheet">
<?php
  $breadcrumb= array( 'name'=>'Question Answer',
            'url'=>$urlPlugins.'admin/questionAnswer-listQuestion.php',
            'sub'=>array('name'=>'Add Question')
            );
  addBreadcrumbAdmin($breadcrumb);
?>

<div class="clear"></div>

<div class="thanhcongcu">

    

    <div class="congcu" onclick="saveData();">

        <span id="save">

          <input type="image"  src="<?php echo $webRoot;?>images/save.png" />

        </span>

        <br/>

        Lưu

    </div>

    

</div>

<div class="clear"></div>

<div id="content">


<?php
    echo $mess;
?>
<div class="c_form">
    <form action="" method="post" name="dangtin">
        <div class="row">
            <div class="col-sm-6">
                <div class="row c_item">
                    <div class="col-sm-4">
                        Chuyên mục:
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control" name="category">
                            <option value="">Tổng hợp</option>
                            <?php
                                if(!empty($questionAnswerCategory)){
                                    foreach($questionAnswerCategory['Option']['value']['allData'] as $components){
                                        echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row c_item">
                    <div class="col-sm-4">
                        Họ và tên:
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" name="fullName">
                    </div>
                </div>
                <div class="row c_item">
                    <div class="col-sm-4">
                        Địa chỉ:
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" name="address">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row c_item">
                    <div class="col-sm-4">
                        Điện thoại:
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" name="fone">
                    </div>
                </div>
                <div class="row c_item">
                    <div class="col-sm-4">
                        Email:
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" type="email" value="" name="email">
                    </div>
                </div>
                <div class="row c_item">
                    <div class="col-sm-4">
                        Tiêu đề:
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" name="title">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            	<br/>
                <?php
				    showEditorInput('contentPost','content','',1);
				?>
            </div>
        </div>
    </form>
</div>



</div>