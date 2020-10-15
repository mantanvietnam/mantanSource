<?php getHeader();?>

<!-- Breadcrumps -->
<div class="breadcrumbs">
    <div class="row">
        <div class="col-sm-6">
            <h1>Nạp tiền</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li>Bạn đang ở: </li>
                <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                <li class="active">Nạp tiền</li>
            </ol>
        </div>
    </div>
</div>
<!-- End of Breadcrumps -->

<!-- Login -->
<section class="login">

    <div class="row spacing-40">
        <div class="col-sm-12">
            <div class="login-form-panel">
                <h3 class="badge">NẠP TIỀN VÀO TÀI KHOẢN</h3>

                <div class="row">
                    <div class="col-sm-5 center-block">
                        <div class="login-form">
                            <div id="sendstatus"><center><?php echo $messReg;?></center></div>
                            <form name="myForm" action="" method="post" onsubmit="return validateForm()">
                                <p>
                                    Hình thức thanh toán

                                    <select name="type" onchange="selectPay(this.value);">
                                    <?php
                                        foreach($typePay as $key=>$type){
                                            echo '<option value="'.$key.'">'.$type.'</option>';
                                        }
                                    ?>
                                    </select>
                                </p>

                                <div id="cardmobi">
                                    <p>Với hình thức này bạn chỉ được cộng 75% giá trị thẻ nạp vào tài khoản</p>
                                    
                                    <table width="100%" border="0" cellpadding="3" cellspacing="3">
                                        <tr>
                                            <td>
                                                Loại thẻ : 
                                                <select name="lstTelco" onchange="change()">
                                                    <option value="1">Viettel</option>
                                                    <option value="2">Vinaphone</option>
                                                    <option value="3">Mobifone</option>
                                                    <option value="4">Gate</option>
                                                    <option value="5">Zing</option>
                                                    <option value="6">MegaCard</option>
                                                    <option value="7">Oncash</option>
                                                    <option value="8">VietnamMobile</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input required type="text" name="txtSeri" placeholder="Số Seri" value="<?php echo @$data['txtSeri'];?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input required type="text" name="txtCode" placeholder="Mã số thẻ cào" value="<?php echo @$data['txtCode'];?>" />
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>
                                                <input type="submit" value="Nạp thẻ" />
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>

                                <div id="bank" style="display: none;text-align: left;">
                                    <?php echo $infoBank;?>
                                </div>

                                <div id="cash" style="display: none;text-align: left;">
                                    <p>Thanh toán trực tiếp tại văn phòng công ty:</p>
                                    <ul style="margin-left: 10px;">
                                        <li>Địa chỉ: <?php echo $contactSite['Option']['value']['address'];?></li>
                                        <li>Điện thoại: <?php echo $contactSite['Option']['value']['fone'];?></li>
                                        <li>Email: <?php echo $contactSite['Option']['value']['email'];?></li>
                                    </ul>
                                </div>

                                <div id="coin" style="display: none;text-align: left;">
                                    <p>Số dư tài khoản: <?php echo number_format($_SESSION['infoUser']['User']['coin']);?>đ<p>
                                    <p>Số tiền này có được bằng cách bạn nạp trực tiếp vào tài khoản để trừ dần hoặc giới thiệu cho bạn bè của bạn về dịch vụ của Mantan Host và nhận hoa hồng</p>
                                    <p>Link giới thiệu: <a target="_blank" title="Link giới thiệu nhận hoa hồng" href="<?php echo $linkRefCode;?>"><?php echo $linkRefCode;?></a></p>
                                </div>

                                <div id="paypal" style="display: none;text-align: left;"></div>
                                <div id="card" style="display: none;text-align: left;"></div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
<!-- End of Login -->

<script type="text/javascript">
    function selectPay(type)
    {
        $("#bank").hide();
        $("#paypal").hide();
        $("#card").hide();
        $("#cash").hide();
        $("#coin").hide();
        $("#cardmobi").hide();

        $("#"+type).show();
    }
</script>

<script type="text/javascript">
    function validateForm()
    {
     
        var x=document.forms["myForm"]["txtCode"].value;
        var y=document.forms["myForm"]["txtSeri"].value;
        var provider = document.forms["myForm"]["lstTelco"].value;

        if(provider == 6)
        {
        
        if (x==null || x=='' || x=='Ma the')
          {  
          alert("Bạn cần nhập mã seri của thẻ");  
          
          return false;
          }
        }
        else if (x==null || x=='' || y==null || y=='')
        {  
          alert("Bạn cần nhập mã thẻ và mã seri");      
          return false;
        }
    }
      function change(){
        var provider = document.forms["myForm"]["lstTelco"].value;
        if(provider == '6' )
        {
            document.getElementById('seri').innerHTML="";
        }else{
            document.getElementById('seri').innerHTML="*";
        }
      }
      
      
     function setOptionText(ExSelect, theArray) {
         for (loop = 0; loop < ExSelect.options.length; loop++) {
              ExSelect.options[loop].text = theArray[loop];
         }
    }
</script>
<?php getFooter();?>