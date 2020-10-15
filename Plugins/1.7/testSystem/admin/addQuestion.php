<?php
$breadcrumb = array
    (
    'name' => 'Quản lý bài thi',
    'url' => '/plugins/admin/testSystem-admin-listTest.php',
    'sub' => array('name' => 'Thêm câu hỏi')
);
addBreadcrumbAdmin($breadcrumb);
?> 
<div class="clear"></div>
<div id="content" style="margin-bottom:50px;">

    <div class="col-sm-12">
      
        <form action="" method="post" class="taovienLimit">
            <input  name="id" value="<?php if(!empty($dataQuestion['Questions']['id'])) echo $dataQuestion['Questions']['id'];?>" type="hidden"/>
            <div class="col-sm-12">
                <div class="form-group">
                    <p><b>Câu hỏi</b></p>
                    <?php showEditorInput('title', 'title', @$dataQuestion['Questions']['title'], 1); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div class="form-group">
                        <p><b>Đáp án A</b></p>
                        <?php showEditorInput('select1', 'select1',@$dataQuestion['Questions']['select'][0]['value'], 0); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <p><b>Đáp án B</b></p>
                        <?php showEditorInput('select2', 'select2',@$dataQuestion['Questions']['select'][1]['value'], 0); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <p><b>Đáp án C</b></p>
                        <?php showEditorInput('select3', 'select3',@$dataQuestion['Questions']['select'][2]['value'], 0); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <p><b>Đáp án D</b></p>
                        <?php showEditorInput('select4', 'select4',@$dataQuestion['Questions']['select'][3]['value'], 0); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <p><b>Kết quả</b></p>
                        <select name="result" class="form-control">
                            <option value="">Đáp án</option>
                            <option value="A" <?php if(!empty($dataQuestion['Questions']['result']) && $dataQuestion['Questions']['result'] == 'A') echo 'selected="selected"'?>>A</option>
                            <option value="B" <?php if(!empty($dataQuestion['Questions']['result']) && $dataQuestion['Questions']['result'] == 'B') echo 'selected="selected"'?>>B</option>
                            <option value="C"<?php if(!empty($dataQuestion['Questions']['result']) && $dataQuestion['Questions']['result'] == 'C') echo 'selected="selected"'?>>C</option>
                            <option value="D" <?php if(!empty($dataQuestion['Questions']['result']) && $dataQuestion['Questions']['result'] == 'D') echo 'selected="selected"'?>>D</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" >
                <input type="submit"  value="Lưu" class=" btn btn-primary"  style="margin-bottom:20px">
            </div>
        </form>    
    </div>
</div>