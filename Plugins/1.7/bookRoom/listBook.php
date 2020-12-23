<?php
$breadcrumb = array('name' => 'Booking',
    'url' => $urlPlugins . 'admin/bookRoom-listBook.php',
    'sub' => array('name' => 'List Booking')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
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
    <form action="" method="post" name="duan" class="taovienLimit">

        <table id="listTin" cellspacing="0" class="tableList">

            <tr>
                <td align="center">Full Name</td>
                <td align="center">Email</td>
                <td align="center">Date</td>
                <td align="center" width="250">Content</td>
                <td align="center" width="160">Choice</td>

            </tr>

            <?php
            $confirm = 'Are you sure you want to remove ?';
            if(isset($listData)){
            foreach ($listData as $tin) {
                echo '<tr>
						 
						  <td>' . $tin['Book']['fullName'] . '</td>
                                                   <td>' . $tin['Book']['email'] . '</td>   
						  <td>' . $tin['Book']['checkin'] . '</td>
						  <td>' . $tin['Book']['content'] . '</td>
						  
						  <td align="center"> 
								<a style="padding: 4px 8px;" href="' . $urlPlugins . 'admin/bookRoom-deleteBook.php/' . $tin['Book']['id'] . '" class="input" onclick="return confirm(' . "'" . $confirm . "'" . ');"  >Delete</a>
						  </td>

					</tr>';
            }}
            ?>


        </table>
        <?php if(isset($listData)){?>
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

            echo '<a href="' . $urlNow . $back . '">Previous Page</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlNow . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlNow . $next . '">Next Page</a> ';
            ?>
        </p>
        <?}?>
    </form>





</div>