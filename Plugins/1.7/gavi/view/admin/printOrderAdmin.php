<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>In biên lai</title>

  <link href="/app/Plugin/gavi/view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- <link href="/app/Plugin/gavi/view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->

  <!-- <link href="/app/Plugin/gavi/view/vendors/animate.css/animate.min.css" rel="stylesheet"> -->

  <!-- <link href="/app/Plugin/gavi/view/build/css/custom.min.css" rel="stylesheet"> -->
</head>
<style type="text/css" media="screen">
body{
  font-size: 13px;
  margin: 20px 0;
}
.container{
  max-width: 435px;
  margin: 0 auto;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
  padding-left: 0;
}
.header{
  display: flex;
  text-align: center;
  /* justify-content: center; */
  align-items: center;
}
.logo{
  width: 23%;

}
.name{
  width: 76%;
}
.title{
  text-align: center;
  font-size: 20px;
  margin: 30px 0;
}
.name{
  margin-left: 6px;
  /* color: #f9561b; */
}
.name h4{
  margin-bottom: 5px;
  border-bottom: 1.5px solid;
  display: inline-block;
}
.product{
  margin: 20px 0;
}
.table1 th, .table1 td{
  padding: 2px 0;
}
.footer{
  border-top: 2px solid #f9561b;
  padding-top: 10px;
}
</style>
<body class="">
  <div class="container">
    <div class="header">
      <div class="logo">
        <img src="/app/Plugin/gavi/view/admin/images/logo.jpg" class="img-responsive" title="" alt="">
      </div>
      <div class="name">
        <h4>MOOCOS VIET NAM CO.,LTD</h4> <!-- <div>more focus on Gac Fruit</div> -->
      </div>
    </div>
    <div class="title">PHIẾU THANH TOÁN</div>
    <div class="content">
      <table class="table1" style="width:100%;" >
        <tbody>
          <tr>
            <th style="width:30%;">Đại lý:</th>
            <td style="width:70%;"><?php echo 'C'.$agency['Agency']['level'].'.'.$agency['Agency']['fullName'].' - '.$agency['Agency']['phone'].' ('.$agency['Agency']['code'].')';?></td>
          </tr>
          <tr>
            <th>Mã đơn:</th>
            <td><?php echo $order['Order']['code'];?></td>
          </tr>
          <tr>
            <th>Ngày tạo đơn:</th>
            <td><?php echo $order['Order']['dateCreate']['text'];?></td>
          </tr>
        </tbody>
      </table>
      <div class="product">
        <table class="table" style="width:100%;">
          <thead>
            <tr>
              <th style="width: 55%;">Sản phẩm</th>
              <th style="width: 20%;">Số lượng</th>
              <th style="width: 25%;text-align: right;">Giá (vnđ)</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if(!empty($order['Order']['product'])){
                foreach($order['Order']['product'] as $product){
                  echo '<tr>
                          <td>'.$product['name'].'</td>
                          <td>'.number_format($product['quantily']).'</td>
                          <td style="text-align: right;">'.number_format($product['price']).'đ</td>
                        </tr>';
                }
              }
            ?>
            <tr>
              <th colspan="2" style="text-align: right; padding-right: 30px;">Tổng tiền:</th>
              <td style="text-align: right;"><?php echo number_format($order['Order']['price']); ?>đ</td>
            </tr>
            <tr>
              <td colspan="3"><strong><em>Bằng chữ: </em></strong><?php echo convert_number_to_words($order['Order']['price']);?> đồng.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="footer">
      <ul class="list-unstyled">
        <li><strong>Công ty TNHH Moocos Việt Nam</strong></li>
        <li> Đ/C: P.1809, tầng 18, Cát Bi Plaza, đường Lê Hồng Phong, Ngô Quyền, Hải Phòng, Việt nam.</li>
        <li>ĐT: +84 313262988/ FAX: +84 313950721</li>
        <li>Email: gac.sales@moocos.com</li>
        <li>Web: www.moocos.com</li>
      </ul>

    </div>
  </div>

  <script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
  <script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>


</body>
</html>
