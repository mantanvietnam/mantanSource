<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý khách hàng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-book-listCustomAdmin.php',
    'sub' => array('name' => 'Khách hàng')
);
addBreadcrumbAdmin($breadcrumb);
?>  

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <form action="" method="post" name="">
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm Khách hàng thành công!</p>';
                        break;
                    case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm Khách hàng không thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="form-group">
                <label >Tên khách hàng (*)</label>
                <input type="text" name="cus_name" class="form-control" id="cus_name"   required>
            </div>
            <div class="form-group">
                <label >CMND/Passport (*)</label>
                <input type="number" name="cmnd" class="form-control" id="" required="" min="0">
            </div>
            <div class="form-group">
                <label >Giới tính (*)</label>
                <select class="form-control" id="sel1" required="">
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>
            <div class="form-group">
                <label >Địa chỉ (*)</label>
                <input type="text" name="address" class="form-control" id="" required="">
            </div>
            <div class="form-group">
                <label >Thông tin giao dịch(*)</label>
                <input type="text" name="info_deal" class="form-control" id="" required="">
            </div>


        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >

            <div class="form-group">
                <label >Quốc tịch (*)</label>
                <select name="nationality" id="cus_country" class="form-control" required="">
                    <option value="GB">Anh (United Kingdom)</option>
                    <option value="AF">Afghanistan</option>
                    <option value="EG">Ai Cập (Egypt)</option>
                    <option value="IE">Ailen (Ireland)</option>
                    <option value="IS">Aixơlen (Iceland)</option>
                    <option value="AL">Albani (Albania)</option>
                    <option value="DZ">Algeria</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AG">Antigua và Barbuda</option>
                    <option value="AT">Áo (Austria)</option>
                    <option value="SA">Arập Xêút (Saudi Arabia)</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="IN">Ấn Độ (India)</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="PL">Ba Lan (Poland)</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="GL">Băng Đảo (Greenland)</option>
                    <option value="BY">Belarus</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BZ">Bêlixê (Belize)</option>
                    <option value="BT">Bhutan</option>
                    <option value="BE">Bỉ (Belgium)</option>
                    <option value="BO">Bolivia</option>
                    <option value="BW">Botswana</option>
                    <option value="PT">Bồ Đào Nha (Portugal)</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="CI">Bờ Biển Ngà (Cote dIvoire)</option>
                    <option value="BR">Braxin (Brazil)</option>
                    <option value="BN">Brunei</option>
                    <option value="BG">Bungari (Bulgaria)</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="AE">Arập Thống nhất (United Arab)</option>
                    <option value="CM">Camơrun (Cameroon)</option>
                    <option value="KH">Campuchia (Cambodia)</option>
                    <option value="CA">Canađa (Canada)</option>
                    <option value="CV">Cape Verde</option>
                    <option value="BQ">Caribbean Netherlands</option>
                    <option value="EA">Ceuta và Melilla</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros (Comoros and Mayotte)</option>
                    <option value="CG">Cônggô (Congo)</option>
                    <option value="CZ">Cộng hòa Séc (Czech Republic)</option>
                    <option value="CF">Trung Phi (Central African)</option>
                    <option value="KW">Côoét (Kuwait)</option>
                    <option value="CR">Cốtxta Rica (Costa Rica)</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cu Ba (Cuba)</option>
                    <option value="CW">Curaçao</option>
                    <option value="DG">Diego Garcia</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="TW">Đài Loan (Taiwan)</option>
                    <option value="DK">Đan Mạch (Denmark)</option>
                    <option value="AC">Ascension Island</option>
                    <option value="CP">Île Clipperton</option>
                    <option value="CX">Christmas Island</option>
                    <option value="IM">Đảo Man</option>
                    <option value="AS">American Samoa</option>
                    <option value="TL">Đông Timo (Timor-Leste)</option>
                    <option value="DE">Đức (Germany)</option>
                    <option value="EC">Ecuador</option>
                    <option value="SV">El Salvador</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FJ">Fiji</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GT">Goatêmala (Guatemala)</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="NL">Hà Lan (Netherlands)</option>
                    <option value="KR">Hàn Quốc (Korea)</option>
                    <option value="US">Mỹ - Hoa Kỳ(United States,USA)</option>
                    <option value="HN">Hônđurát (Honduras)</option>
                    <option value="HK">Hồng Kông (Hong Kong)</option>
                    <option value="HU">Hungari (Hungary)</option>
                    <option value="GR">Hy Lạp (Greece)</option>
                    <option value="KP">Triều Tiên (North Korea)</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran</option>
                    <option value="IQ">Irắc (Iraq)</option>
                    <option value="IL">Israel</option>
                    <option value="JM">Jamaica</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="PS">Palestine</option>
                    <option value="LA">Lào (Laos)</option>
                    <option value="LV">Latvia</option>
                    <option value="LS">Lesotho</option>
                    <option value="LB">Libăng (Lebanon)</option>
                    <option value="LR">LIberia</option>
                    <option value="LY">Libi (Libya)</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MK">Macedonia</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MA">Marốc (Morocco)</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mêhicô (Mexico)</option>
                    <option value="FM">Micronesia</option>
                    <option value="MD">Moldova</option>
                    <option value="MC">Monaco</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MN">Mông Cổ (Mongolia)</option>
                    <option value="MM">Myanmar(Myanmar)</option>
                    <option value="AQ">Nam Cực</option>
                    <option value="NA">Namibia</option>
                    <option value="ZA">Nam Phi (South Africa)</option>
                    <option value="SS">Nam Sudan (South Sudan)</option>
                    <option value="NR">Nauru</option>
                    <option value="NO">Na Uy (Norway)</option>
                    <option value="NP">Nepal</option>
                    <option value="NZ">New Zealand</option>
                    <option value="RU">Nga (Russia)</option>
                    <option value="JP">Nhật Bản (Japan)</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="FR">Pháp (France)</option>
                    <option value="FI">Phần Lan (Finland)</option>
                    <option value="PH">Philippin (Philippines)</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RE">Réunion (Reunion)</option>
                    <option value="RO">Romania</option>
                    <option value="RW">Rwanda</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SX">Sint Maarten</option>
                    <option value="CY">Síp (Cyprus)</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SO">Somali (Somalia)</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SR">Suriname</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SY">Syria</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania</option>
                    <option value="ES">Tây Ban Nha (Spain)</option>
                    <option value="EH">Tây Sahara</option>
                    <option value="TH">Thái Lan (Thailand)</option>
                    <option value="TR">Thổ Nhĩ Kỳ (Turkey)</option>
                    <option value="SE">Thụy Điển (Sweden)</option>
                    <option value="CH">Thụy Sĩ (Switzerland)</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TA">Tristan da Cunha</option>
                    <option value="CN">Trung Quốc (China)</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TV">Tuvalu</option>
                    <option value="TN">Tuynidi (Tunisia)</option>
                    <option value="AU">Úc (Australia)</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraina (Ukraine)</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VA">Vaticăng (Vatican City)</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN" selected="selected">Việt Nam (Vietnam)</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="SD">Xuđăng (Sudan)</option>
                    <option value="IT">Ý (Italy)</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                </select>
            </div>
            <div class="form-group">
                <label >Ngày sinh (*)</label>
                <input type="date" name="birthday" class="form-control" id="" required="">
            </div>
            <div class="form-group">
                <label >Điện thoại(*)</label>
                <input type="text" name="phone" class="form-control" id="" required="" >
            </div>
            <div class="form-group">
                <label >Ghi chú</label>
                <input type="text" name="note" class="form-control" id="">
            </div>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Thêm</button></div>
    </form>
</div>

