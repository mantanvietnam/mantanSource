<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý khách hàng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php',
    'sub' => array('name' => 'Sửa khách hàng')
);
addBreadcrumbAdmin($breadcrumb);
?>  

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <div class="form-group">
        <label for="">Tên khách hàng : <span style="color: blue;" id="user" ><?php echo $data['Custom']['cus_name'] ?></span></label>
    </div>
    <form action="" method="post" name="">
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p style="color:red;">Sửa khách hàng thành công!</p>';
                        break;
                    case -1: echo '<p style="color:red;">Sửa khách hàng không thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="form-group">
                <label >Tên khách hàng (*)</label>
                <input type="text" name="cus_name" value="<?php echo $data['Custom']['cus_name'] ?>" class="form-control" id="cus_name"   required="">
            </div>
            <div class="form-group">
                <label >CMND/Passport (*)</label>
                <input type="number" name="cmnd" disabled value="<?php echo $data['Custom']['cmnd'] ?>" class="form-control" id="" required="" min="0">
            </div>
            <select class="form-control" id="sel1">
                <option value="male" <?php if($data['Custom']['cmnd']=='male') echo 'selected'; ?>>Nam</option>
                <option value="female" <?php if($data['Custom']['cmnd']=='female') echo 'selected'; ?>>Nữ</option>
                <option value="other" <?php if($data['Custom']['cmnd']=='other') echo 'selected'; ?>>Khác</option>
            </select>
            <div class="form-group">
                <label >Địa chỉ (*)</label>
                <input type="text" name="address" value="<?php echo $data['Custom']['address'] ?>" class="form-control" id="" required="" >
            </div>
            <div class="form-group">
                <label >Thông tin giao dịch(*)</label>
                <input type="text" name="nationality" value="<?php echo @$data['Custom']['info_deal'] ?>" class="form-control" id="" >
            </div>


        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >

            <div class="form-group">
                <label >Quốc tịch (*)</label>
                <select name="nationality" id="cus_country" class="form-control">
                    <option value="GB" <?php if($data['Custom']['nationality']=='GB'){echo 'selected';}?>>Anh (United Kingdom)</option>
                    <option value="AF" <?php if($data['Custom']['nationality']=='AF'){echo 'selected';}?>>Afghanistan</option>
                    <option value="AF" <?php if($data['Custom']['nationality']=='AF'){echo 'selected';}?>>Ai Cập (Egypt)</option>
                    <option value="IE" <?php if($data['Custom']['nationality']=='IE'){echo 'selected';}?>>Ailen (Ireland)</option>
                    <option value="IS" <?php if($data['Custom']['nationality']=='IS'){echo 'selected';}?>>Aixơlen (Iceland)</option>
                    <option value="AL" <?php if($data['Custom']['nationality']=='AL'){echo 'selected';}?>>Albani (Albania)</option>
                    <option value="DZ" <?php if($data['Custom']['nationality']=='DZ'){echo 'selected';}?>>Algeria</option>
                    <option value="AD" <?php if($data['Custom']['nationality']=='AD'){echo 'selected';}?>>Andorra</option>
                    <option value="AO" <?php if($data['Custom']['nationality']=='AO'){echo 'selected';}?>>Angola</option>
                    <option value="AI" <?php if($data['Custom']['nationality']=='AI'){echo 'selected';}?>>Anguilla</option>
                    <option value="AG" <?php if($data['Custom']['nationality']=='AG'){echo 'selected';}?>>Antigua và Barbuda</option>
                    <option value="AT" <?php if($data['Custom']['nationality']=='AT'){echo 'selected';}?>>Áo (Austria)</option>
                    <option value="SA" <?php if($data['Custom']['nationality']=='SA'){echo 'selected';}?>>Arập Xêút (Saudi Arabia)</option>
                    <option value="AR" <?php if($data['Custom']['nationality']=='AR'){echo 'selected';}?>>Argentina</option>
                    <option value="AM" <?php if($data['Custom']['nationality']=='AM'){echo 'selected';}?>>Armenia</option>
                    <option value="AW" <?php if($data['Custom']['nationality']=='AW'){echo 'selected';}?>>Aruba</option>
                    <option value="AZ" <?php if($data['Custom']['nationality']=='AZ'){echo 'selected';}?>>Azerbaijan</option>
                    <option value="IN" <?php if($data['Custom']['nationality']=='IN'){echo 'selected';}?>>Ấn Độ (India)</option>
                    <option value="BS" <?php if($data['Custom']['nationality']=='BS'){echo 'selected';}?>>Bahamas</option>
                    <option value="BH" <?php if($data['Custom']['nationality']=='BH'){echo 'selected';}?>>Bahrain</option>
                    <option value="PL" <?php if($data['Custom']['nationality']=='PL'){echo 'selected';}?>>Ba Lan (Poland)</option>
                    <option value="BD" <?php if($data['Custom']['nationality']=='BD'){echo 'selected';}?>>Bangladesh</option>
                    <option value="BB" <?php if($data['Custom']['nationality']=='BB'){echo 'selected';}?>>Barbados</option>
                    <option value="GL" <?php if($data['Custom']['nationality']=='GL'){echo 'selected';}?>>Băng Đảo (Greenland)</option>
                    <option value="BY" <?php if($data['Custom']['nationality']=='BY'){echo 'selected';}?>>Belarus</option>
                    <option value="BJ" <?php if($data['Custom']['nationality']=='BJ'){echo 'selected';}?>>Benin</option>
                    <option value="BM" <?php if($data['Custom']['nationality']=='BM'){echo 'selected';}?>>Bermuda</option>
                    <option value="BZ" <?php if($data['Custom']['nationality']=='BZ'){echo 'selected';}?>>Bêlixê (Belize)</option>
                    <option value="BT" <?php if($data['Custom']['nationality']=='BT'){echo 'selected';}?>>Bhutan</option>
                    <option value="BE" <?php if($data['Custom']['nationality']=='BE'){echo 'selected';}?>>Bỉ (Belgium)</option>
                    <option value="BO" <?php if($data['Custom']['nationality']=='BO'){echo 'selected';}?>>Bolivia</option>
                    <option value="BW" <?php if($data['Custom']['nationality']=='BW'){echo 'selected';}?>>Botswana</option>
                    <option value="PT" <?php if($data['Custom']['nationality']=='PT'){echo 'selected';}?>>Bồ Đào Nha (Portugal)</option>
                    <option value="BA" <?php if($data['Custom']['nationality']=='BA'){echo 'selected';}?>>Bosnia and Herzegovina</option>
                    <option value="CI" <?php if($data['Custom']['nationality']=='CI'){echo 'selected';}?>>Bờ Biển Ngà (Cote dIvoire)</option>
                    <option value="BR" <?php if($data['Custom']['nationality']=='BR'){echo 'selected';}?>>Braxin (Brazil)</option>
                    <option value="BN" <?php if($data['Custom']['nationality']=='BN'){echo 'selected';}?>>Brunei</option>
                    <option value="BG" <?php if($data['Custom']['nationality']=='BG'){echo 'selected';}?>>Bungari (Bulgaria)</option>
                    <option value="BF" <?php if($data['Custom']['nationality']=='BF'){echo 'selected';}?>>Burkina Faso</option>
                    <option value="BI" <?php if($data['Custom']['nationality']=='BI'){echo 'selected';}?>>Burundi</option>
                    <option value="AE" <?php if($data['Custom']['nationality']=='AE'){echo 'selected';}?>>Arập Thống nhất (United Arab)</option>
                    <option value="CM" <?php if($data['Custom']['nationality']=='CM'){echo 'selected';}?>>Camơrun (Cameroon)</option>
                    <option value="KH" <?php if($data['Custom']['nationality']=='KH'){echo 'selected';}?>>Campuchia (Cambodia)</option>
                    <option value="CA" <?php if($data['Custom']['nationality']=='CA'){echo 'selected';}?>>Canađa (Canada)</option>
                    <option value="CV" <?php if($data['Custom']['nationality']=='CV'){echo 'selected';}?>>Cape Verde</option>
                    <option value="BQ" <?php if($data['Custom']['nationality']=='BQ'){echo 'selected';}?>>Caribbean Netherlands</option>
                    <option value="EA" <?php if($data['Custom']['nationality']=='EA'){echo 'selected';}?>>Ceuta và Melilla</option>
                    <option value="TD" <?php if($data['Custom']['nationality']=='TD'){echo 'selected';}?>>Chad</option>
                    <option value="CL" <?php if($data['Custom']['nationality']=='CL'){echo 'selected';}?>>Chile</option>
                    <option value="CO" <?php if($data['Custom']['nationality']=='CO'){echo 'selected';}?>>Colombia</option>
                    <option value="KM" <?php if($data['Custom']['nationality']=='KM'){echo 'selected';}?>>Comoros (Comoros and Mayotte)</option>
                    <option value="CG" <?php if($data['Custom']['nationality']=='CG'){echo 'selected';}?>>Cônggô (Congo)</option>
                    <option value="CZ" <?php if($data['Custom']['nationality']=='CZ'){echo 'selected';}?>>Cộng hòa Séc (Czech Republic)</option>
                    <option value="CF" <?php if($data['Custom']['nationality']=='CF'){echo 'selected';}?>>Trung Phi (Central African)</option>
                    <option value="KW" <?php if($data['Custom']['nationality']=='KW'){echo 'selected';}?>>Côoét (Kuwait)</option>
                    <option value="CR" <?php if($data['Custom']['nationality']=='CR'){echo 'selected';}?>>Cốtxta Rica (Costa Rica)</option>
                    <option value="HR" <?php if($data['Custom']['nationality']=='HR'){echo 'selected';}?>>Croatia</option>
                    <option value="CU" <?php if($data['Custom']['nationality']=='CU'){echo 'selected';}?>>Cu Ba (Cuba)</option>
                    <option value="CW" <?php if($data['Custom']['nationality']=='CW'){echo 'selected';}?>>Curaçao</option>
                    <option value="DG" <?php if($data['Custom']['nationality']=='DG'){echo 'selected';}?>>Diego Garcia</option>
                    <option value="DJ" <?php if($data['Custom']['nationality']=='DJ'){echo 'selected';}?>>Djibouti</option>
                    <option value="DM" <?php if($data['Custom']['nationality']=='DM'){echo 'selected';}?>>Dominica</option>
                    <option value="TW" <?php if($data['Custom']['nationality']=='TW'){echo 'selected';}?>>Đài Loan (Taiwan)</option>
                    <option value="DK" <?php if($data['Custom']['nationality']=='DK'){echo 'selected';}?>>Đan Mạch (Denmark)</option>
                    <option value="AC" <?php if($data['Custom']['nationality']=='AC'){echo 'selected';}?>>Ascension Island</option>
                    <option value="CP" <?php if($data['Custom']['nationality']=='CP'){echo 'selected';}?>>Île Clipperton</option>
                    <option value="CX" <?php if($data['Custom']['nationality']=='CX'){echo 'selected';}?>>Christmas Island</option>
                    <option value="IM" <?php if($data['Custom']['nationality']=='IM'){echo 'selected';}?>>Đảo Man</option>
                    <option value="AS" <?php if($data['Custom']['nationality']=='AS'){echo 'selected';}?>>American Samoa</option>
                    <option value="TL" <?php if($data['Custom']['nationality']=='TL'){echo 'selected';}?>>Đông Timo (Timor-Leste)</option>
                    <option value="DE" <?php if($data['Custom']['nationality']=='DE'){echo 'selected';}?>>Đức (Germany)</option>
                    <option value="EC" <?php if($data['Custom']['nationality']=='EC'){echo 'selected';}?>>Ecuador</option>
                    <option value="SV" <?php if($data['Custom']['nationality']=='SV'){echo 'selected';}?>>El Salvador</option>
                    <option value="ER" <?php if($data['Custom']['nationality']=='ER'){echo 'selected';}?>>Eritrea</option>
                    <option value="EE" <?php if($data['Custom']['nationality']=='EE'){echo 'selected';}?>>Estonia</option>
                    <option value="ET" <?php if($data['Custom']['nationality']=='ET'){echo 'selected';}?>>Ethiopia</option>
                    <option value="FJ" <?php if($data['Custom']['nationality']=='FJ'){echo 'selected';}?>>Fiji</option>
                    <option value="GA" <?php if($data['Custom']['nationality']=='GA'){echo 'selected';}?>>Gabon</option>
                    <option value="GM" <?php if($data['Custom']['nationality']=='GM'){echo 'selected';}?>>Gambia</option>
                    <option value="GE" <?php if($data['Custom']['nationality']=='GE'){echo 'selected';}?>>Georgia</option>
                    <option value="GH" <?php if($data['Custom']['nationality']=='GH'){echo 'selected';}?>>Ghana</option>
                    <option value="GI" <?php if($data['Custom']['nationality']=='GI'){echo 'selected';}?>>Gibraltar</option>
                    <option value="GT" <?php if($data['Custom']['nationality']=='GT'){echo 'selected';}?>>Goatêmala (Guatemala)</option>
                    <option value="GD" <?php if($data['Custom']['nationality']=='GD'){echo 'selected';}?>>Grenada</option>
                    <option value="GP" <?php if($data['Custom']['nationality']=='GP'){echo 'selected';}?>>Guadeloupe</option>
                    <option value="GU" <?php if($data['Custom']['nationality']=='GU'){echo 'selected';}?>>Guam</option>
                    <option value="GG" <?php if($data['Custom']['nationality']=='GG'){echo 'selected';}?>>Guernsey</option>
                    <option value="GN" <?php if($data['Custom']['nationality']=='GN'){echo 'selected';}?>>Guinea</option>
                    <option value="GY" <?php if($data['Custom']['nationality']=='GY'){echo 'selected';}?>>Guyana</option>
                    <option value="HT" <?php if($data['Custom']['nationality']=='HT'){echo 'selected';}?>>Haiti</option>
                    <option value="NL" <?php if($data['Custom']['nationality']=='NL'){echo 'selected';}?>>Hà Lan (Netherlands)</option>
                    <option value="KR" <?php if($data['Custom']['nationality']=='KR'){echo 'selected';}?>>Hàn Quốc (Korea)</option>
                    <option value="US" <?php if($data['Custom']['nationality']=='US'){echo 'selected';}?>>Mỹ - Hoa Kỳ(United States,USA)</option>
                    <option value="HN" <?php if($data['Custom']['nationality']=='HN'){echo 'selected';}?>>Hônđurát (Honduras)</option>
                    <option value="HK" <?php if($data['Custom']['nationality']=='HK'){echo 'selected';}?>>Hồng Kông (Hong Kong)</option>
                    <option value="HU" <?php if($data['Custom']['nationality']=='HU'){echo 'selected';}?>>Hungari (Hungary)</option>
                    <option value="GR" <?php if($data['Custom']['nationality']=='GR'){echo 'selected';}?>>Hy Lạp (Greece)</option>
                    <option value="KP" <?php if($data['Custom']['nationality']=='KP'){echo 'selected';}?>>Triều Tiên (North Korea)</option>
                    <option value="IR" <?php if($data['Custom']['nationality']=='IR'){echo 'selected';}?>>Iran</option>
                    <option value="IQ" <?php if($data['Custom']['nationality']=='IQ'){echo 'selected';}?>>Irắc (Iraq)</option>
                    <option value="IL" <?php if($data['Custom']['nationality']=='IL'){echo 'selected';}?>>Israel</option>
                    <option value="JM" <?php if($data['Custom']['nationality']=='JM'){echo 'selected';}?>>Jamaica</option>
                    <option value="JE" <?php if($data['Custom']['nationality']=='JE'){echo 'selected';}?>>Jersey</option>
                    <option value="JO" <?php if($data['Custom']['nationality']=='JO'){echo 'selected';}?>>Jordan</option>
                    <option value="KZ" <?php if($data['Custom']['nationality']=='KZ'){echo 'selected';}?>>Kazakhstan</option>
                    <option value="KE" <?php if($data['Custom']['nationality']=='KE'){echo 'selected';}?>>Kenya</option>
                    <option value="KI" <?php if($data['Custom']['nationality']=='KI'){echo 'selected';}?>>Kiribati</option>
                    <option value="KG" <?php if($data['Custom']['nationality']=='KG'){echo 'selected';}?>>Kyrgyzstan</option>
                    <option value="PS" <?php if($data['Custom']['nationality']=='PS'){echo 'selected';}?>>Palestine</option>
                    <option value="LA" <?php if($data['Custom']['nationality']=='LA'){echo 'selected';}?>>Lào (Laos)</option>
                    <option value="LV" <?php if($data['Custom']['nationality']=='LV'){echo 'selected';}?>>Latvia</option>
                    <option value="LS" <?php if($data['Custom']['nationality']=='LS'){echo 'selected';}?>>Lesotho</option>
                    <option value="LB" <?php if($data['Custom']['nationality']=='LB'){echo 'selected';}?>>Libăng (Lebanon)</option>
                    <option value="LR" <?php if($data['Custom']['nationality']=='LR'){echo 'selected';}?>>LIberia</option>
                    <option value="LY" <?php if($data['Custom']['nationality']=='LY'){echo 'selected';}?>>Libi (Libya)</option>
                    <option value="LI" <?php if($data['Custom']['nationality']=='LI'){echo 'selected';}?>>Liechtenstein</option>
                    <option value="LT" <?php if($data['Custom']['nationality']=='LT'){echo 'selected';}?>>Lithuania</option>
                    <option value="LU" <?php if($data['Custom']['nationality']=='LU'){echo 'selected';}?>>Luxembourg</option>
                    <option value="MO" <?php if($data['Custom']['nationality']=='MO'){echo 'selected';}?>>Macao</option>
                    <option value="MK" <?php if($data['Custom']['nationality']=='MK'){echo 'selected';}?>>Macedonia</option>
                    <option value="MG" <?php if($data['Custom']['nationality']=='MG'){echo 'selected';}?>>Madagascar</option>
                    <option value="MW" <?php if($data['Custom']['nationality']=='MW'){echo 'selected';}?>>Malawi</option>
                    <option value="MY" <?php if($data['Custom']['nationality']=='MY'){echo 'selected';}?>>Malaysia</option>
                    <option value="MV" <?php if($data['Custom']['nationality']=='MV'){echo 'selected';}?>>Maldives</option>
                    <option value="ML" <?php if($data['Custom']['nationality']=='ML'){echo 'selected';}?>>Mali</option>
                    <option value="MT" <?php if($data['Custom']['nationality']=='MT'){echo 'selected';}?>>Malta</option>
                    <option value="MA" <?php if($data['Custom']['nationality']=='MA'){echo 'selected';}?>>Marốc (Morocco)</option>
                    <option value="MQ" <?php if($data['Custom']['nationality']=='MQ'){echo 'selected';}?>>Martinique</option>
                    <option value="MR" <?php if($data['Custom']['nationality']=='MR'){echo 'selected';}?>>Mauritania</option>
                    <option value="MU" <?php if($data['Custom']['nationality']=='MU'){echo 'selected';}?>>Mauritius</option>
                    <option value="YT" <?php if($data['Custom']['nationality']=='YT'){echo 'selected';}?>>Mayotte</option>
                    <option value="MX" <?php if($data['Custom']['nationality']=='MX'){echo 'selected';}?>>Mêhicô (Mexico)</option>
                    <option value="FM" <?php if($data['Custom']['nationality']=='FM'){echo 'selected';}?>>Micronesia</option>
                    <option value="MD" <?php if($data['Custom']['nationality']=='MD'){echo 'selected';}?>>Moldova</option>
                    <option value="MC" <?php if($data['Custom']['nationality']=='MC'){echo 'selected';}?>>Monaco</option>
                    <option value="ME" <?php if($data['Custom']['nationality']=='ME'){echo 'selected';}?>>Montenegro</option>
                    <option value="MS" <?php if($data['Custom']['nationality']=='MS'){echo 'selected';}?>>Montserrat</option>
                    <option value="MN" <?php if($data['Custom']['nationality']=='MN'){echo 'selected';}?>>Mông Cổ (Mongolia)</option>
                    <option value="MM" <?php if($data['Custom']['nationality']=='MM'){echo 'selected';}?>>Myanmar(Myanmar)</option>
                    <option value="AQ" <?php if($data['Custom']['nationality']=='AQ'){echo 'selected';}?>>Nam Cực</option>
                    <option value="NA" <?php if($data['Custom']['nationality']=='NA'){echo 'selected';}?>>Namibia</option>
                    <option value="ZA" <?php if($data['Custom']['nationality']=='ZA'){echo 'selected';}?>>Nam Phi (South Africa)</option>
                    <option value="SS" <?php if($data['Custom']['nationality']=='SS'){echo 'selected';}?>>Nam Sudan (South Sudan)</option>
                    <option value="NR" <?php if($data['Custom']['nationality']=='NR'){echo 'selected';}?>>Nauru</option>
                    <option value="NO" <?php if($data['Custom']['nationality']=='NO'){echo 'selected';}?>>Na Uy (Norway)</option>
                    <option value="NP" <?php if($data['Custom']['nationality']=='NP'){echo 'selected';}?>>Nepal</option>
                    <option value="NZ" <?php if($data['Custom']['nationality']=='NZ'){echo 'selected';}?>>New Zealand</option>
                    <option value="RU" <?php if($data['Custom']['nationality']=='RU'){echo 'selected';}?>>Nga (Russia)</option>
                    <option value="JP" <?php if($data['Custom']['nationality']=='JP'){echo 'selected';}?>>Nhật Bản (Japan)</option>
                    <option value="NI" <?php if($data['Custom']['nationality']=='NI'){echo 'selected';}?>>Nicaragua</option>
                    <option value="NE" <?php if($data['Custom']['nationality']=='NE'){echo 'selected';}?>>Niger</option>
                    <option value="NG" <?php if($data['Custom']['nationality']=='NG'){echo 'selected';}?>>Nigeria</option>
                    <option value="NU" <?php if($data['Custom']['nationality']=='NU'){echo 'selected';}?>>Niue</option>
                    <option value="OM" <?php if($data['Custom']['nationality']=='OM'){echo 'selected';}?>>Oman</option>
                    <option value="PK" <?php if($data['Custom']['nationality']=='PK'){echo 'selected';}?>>Pakistan</option>
                    <option value="PW" <?php if($data['Custom']['nationality']=='PW'){echo 'selected';}?>>Palau</option>
                    <option value="PA" <?php if($data['Custom']['nationality']=='PA'){echo 'selected';}?>>Panama</option>
                    <option value="PG" <?php if($data['Custom']['nationality']=='PG'){echo 'selected';}?>>Papua New Guinea</option>
                    <option value="PY" <?php if($data['Custom']['nationality']=='PY'){echo 'selected';}?>>Paraguay</option>
                    <option value="PE" <?php if($data['Custom']['nationality']=='PE'){echo 'selected';}?>>Peru</option>
                    <option value="FR" <?php if($data['Custom']['nationality']=='FR'){echo 'selected';}?>>Pháp (France)</option>
                    <option value="FI" <?php if($data['Custom']['nationality']=='FI'){echo 'selected';}?>>Phần Lan (Finland)</option>
                    <option value="PH" <?php if($data['Custom']['nationality']=='PH'){echo 'selected';}?>>Philippin (Philippines)</option>
                    <option value="PR" <?php if($data['Custom']['nationality']=='PR'){echo 'selected';}?>>Puerto Rico</option>
                    <option value="QA" <?php if($data['Custom']['nationality']=='QA'){echo 'selected';}?>>Qatar</option>
                    <option value="RE" <?php if($data['Custom']['nationality']=='RE'){echo 'selected';}?>>Réunion (Reunion)</option>
                    <option value="RO" <?php if($data['Custom']['nationality']=='RO'){echo 'selected';}?>>Romania</option>
                    <option value="RW" <?php if($data['Custom']['nationality']=='RW'){echo 'selected';}?>>Rwanda</option>
                    <option value="WS" <?php if($data['Custom']['nationality']=='WS'){echo 'selected';}?>>Samoa</option>
                    <option value="SN" <?php if($data['Custom']['nationality']=='SN'){echo 'selected';}?>>Senegal</option>
                    <option value="RS" <?php if($data['Custom']['nationality']=='RS'){echo 'selected';}?>>Serbia</option>
                    <option value="SC" <?php if($data['Custom']['nationality']=='SC'){echo 'selected';}?>>Seychelles</option>
                    <option value="SL" <?php if($data['Custom']['nationality']=='SL'){echo 'selected';}?>>Sierra Leone</option>
                    <option value="SG" <?php if($data['Custom']['nationality']=='SG'){echo 'selected';}?>>Singapore</option>
                    <option value="SX" <?php if($data['Custom']['nationality']=='SX'){echo 'selected';}?>>Sint Maarten</option>
                    <option value="CY" <?php if($data['Custom']['nationality']=='CY'){echo 'selected';}?>>Síp (Cyprus)</option>
                    <option value="SK" <?php if($data['Custom']['nationality']=='SK'){echo 'selected';}?>>Slovakia</option>
                    <option value="SI" <?php if($data['Custom']['nationality']=='SI'){echo 'selected';}?>>Slovenia</option>
                    <option value="SO" <?php if($data['Custom']['nationality']=='SO'){echo 'selected';}?>>Somali (Somalia)</option>
                    <option value="LK" <?php if($data['Custom']['nationality']=='LK'){echo 'selected';}?>>Sri Lanka</option>
                    <option value="SR" <?php if($data['Custom']['nationality']=='SR'){echo 'selected';}?>>Suriname</option>
                    <option value="SZ" <?php if($data['Custom']['nationality']=='SZ'){echo 'selected';}?>>Swaziland</option>
                    <option value="SY" <?php if($data['Custom']['nationality']=='SY'){echo 'selected';}?>>Syria</option>
                    <option value="TJ" <?php if($data['Custom']['nationality']=='TJ'){echo 'selected';}?>>Tajikistan</option>
                    <option value="TZ" <?php if($data['Custom']['nationality']=='TZ'){echo 'selected';}?>>Tanzania</option>
                    <option value="ES" <?php if($data['Custom']['nationality']=='ES'){echo 'selected';}?>>Tây Ban Nha (Spain)</option>
                    <option value="EH" <?php if($data['Custom']['nationality']=='EH'){echo 'selected';}?>>Tây Sahara</option>
                    <option value="TH" <?php if($data['Custom']['nationality']=='TH'){echo 'selected';}?>>Thái Lan (Thailand)</option>
                    <option value="TR" <?php if($data['Custom']['nationality']=='TR'){echo 'selected';}?>>Thổ Nhĩ Kỳ (Turkey)</option>
                    <option value="SE" <?php if($data['Custom']['nationality']=='SE'){echo 'selected';}?>>Thụy Điển (Sweden)</option>
                    <option value="CH" <?php if($data['Custom']['nationality']=='CH'){echo 'selected';}?>>Thụy Sĩ (Switzerland)</option>
                    <option value="TG" <?php if($data['Custom']['nationality']=='TG'){echo 'selected';}?>>Togo</option>
                    <option value="TK" <?php if($data['Custom']['nationality']=='TK'){echo 'selected';}?>>Tokelau</option>
                    <option value="TO" <?php if($data['Custom']['nationality']=='TO'){echo 'selected';}?>>Tonga</option>
                    <option value="TT" <?php if($data['Custom']['nationality']=='TT'){echo 'selected';}?>>Trinidad and Tobago</option>
                    <option value="TA" <?php if($data['Custom']['nationality']=='TA'){echo 'selected';}?>>Tristan da Cunha</option>
                    <option value="CN" <?php if($data['Custom']['nationality']=='CN'){echo 'selected';}?>>Trung Quốc (China)</option>
                    <option value="TM" <?php if($data['Custom']['nationality']=='TM'){echo 'selected';}?>>Turkmenistan</option>
                    <option value="TV" <?php if($data['Custom']['nationality']=='TV'){echo 'selected';}?>>Tuvalu</option>
                    <option value="TN" <?php if($data['Custom']['nationality']=='TN'){echo 'selected';}?>>Tuynidi (Tunisia)</option>
                    <option value="AU" <?php if($data['Custom']['nationality']=='AU'){echo 'selected';}?>>Úc (Australia)</option>
                    <option value="UG" <?php if($data['Custom']['nationality']=='UG'){echo 'selected';}?>>Uganda</option>
                    <option value="UA" <?php if($data['Custom']['nationality']=='UA'){echo 'selected';}?>>Ukraina (Ukraine)</option>
                    <option value="UY" <?php if($data['Custom']['nationality']=='UY'){echo 'selected';}?>>Uruguay</option>
                    <option value="UZ" <?php if($data['Custom']['nationality']=='UZ'){echo 'selected';}?>>Uzbekistan</option>
                    <option value="VU" <?php if($data['Custom']['nationality']=='VU'){echo 'selected';}?>>Vanuatu</option>
                    <option value="VA" <?php if($data['Custom']['nationality']=='VA'){echo 'selected';}?>>Vaticăng (Vatican City)</option>
                    <option value="VE" <?php if($data['Custom']['nationality']=='VE'){echo 'selected';}?>>Venezuela</option>
                    <option value="VN" <?php if($data['Custom']['nationality']=='VN'){echo 'selected';}?>>Việt Nam (Vietnam)</option>
                    <option value="WF" <?php if($data['Custom']['nationality']=='WF'){echo 'selected';}?>>Wallis and Futuna</option>
                    <option value="SD" <?php if($data['Custom']['nationality']=='SD'){echo 'selected';}?>>Xuđăng (Sudan)</option>
                    <option value="IT" <?php if($data['Custom']['nationality']=='IT'){echo 'selected';}?>>Ý (Italy)</option>
                    <option value="YE" <?php if($data['Custom']['nationality']=='YE'){echo 'selected';}?>>Yemen</option>
                    <option value="ZM" <?php if($data['Custom']['nationality']=='ZM'){echo 'selected';}?>>Zambia</option>
                    <option value="ZW" <?php if($data['Custom']['nationality']=='ZW'){echo 'selected';}?>>Zimbabwe</option>
                </select>
            </div>
            <div class="form-group">
                <label >Ngày sinh (*)</label>
                <input type="date" name="birthday" value="<?php echo @$data['Custom']['birthday'] ?>" class="form-control" id="birthday" >
            </div>
            <div class="form-group">
                <label >Điện thoại(*)</label>
                <input type="text" name="phone" value="<?php echo $data['Custom']['phone'] ?>" class="form-control" id="" required>
            </div>
            <div class="form-group">
                <label >Ghi chú</label>
                <input type="text" name="note" value="<?php echo isset($data['Custom']['note'])?$data['Custom']['note']:''; ?>" class="form-control" id="">


            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Sửa</button></div>
    </form>
</div>

