	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Kiểm tra tên miền</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Tên miền</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <!--  Domain Search -->
    <section class="domains">
        <div class="row">
            <div class="col-sm-12">
                <h2>Chọn tên miền phù hợp với nhu cầu của bạn</h2>
                <hr class="small" />
                <p>Tên miền như một thương hiệu trên internet, đừng để người khác lấy mất thương hiệu của bạn</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10 com-md-8 center-block">

                <form class="form-inline domainsearch" method="get" action="">
                    <div class="row no-gutter">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="domain" placeholder="Enter your domain" value="<?php echo $domain;?>" />
                        </div>
                        <div class="col-sm-2">
                            <select name="type" class="form-control">
                                <option id="all" value="all">Tất cả</option>
								<option id="vn" value="vn">.vn</option>
								<option id="com.vn" value="com.vn">.com.vn</option>
								<option id="net.vn" value="net.vn">.net.vn</option>
								<option id="org.vn" value="org.vn">.org.vn</option>
								<option id="info.vn" value="info.vn">.info.vn</option>
								<option id="gov.vn" value="gov.vn">.gov.vn</option>
								<option id="biz.vn" value="biz.vn">.biz.vn</option>
								<option id="int.vn" value="int.vn">.int.vn</option>
								<option id="pro.vn" value="pro.vn">.pro.vn</option>
								<option id="health.vn" value="health.vn">.health.vn</option>
								<option id="name.vn" value="name.vn">.name.vn</option>
								<option id="edu.vn" value="edu.vn">.edu.vn</option>
								<option id="com" value="com">.com</option>
								<option id="net" value="net">.net</option>
								<option id="org" value="org">.org</option>
								<option id="biz" value="biz">.biz</option>
								<option id="info" value="info">.info</option>
								<option id="cc" value="cc">.cc</option>
								<option id="name" value="name">.name</option>
								<option id="asia" value="asia">.asia</option>
								<option id="me" value="me">.me</option>
								<option id="mobi" value="mobi">.mobi</option>
								<option id="us" value="us">.us</option>
								<option id="tel" value="tel">.tel</option>
								<option id="eu" value="eu">.eu</option>
								<option id="in" value="in">.in</option>
								<option id="tv" value="tv">.tv</option>
								<option id="co" value="co">.co</option>
								<option id="tw" value="tw">.tw</option>
								<option id="ws" value="ws">.ws</option>
								<option id="cn" value="cn">.cn</option>
								<option id="xxx" value="xxx">.xxx</option>
								<option id="ac.vn" value="ac.vn">.ac.vn</option>
								<option id="top" value="top">.top</option>
								<option id="photo" value="photo">.photo</option>  
								<option id="xyz" value="xyz">.xyz</option> 
                                <option id="club" value="club">.club</option> 
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary" style="width:100%">SEARCH</button>
                        </div>

                    </div>
                </form>


                <div id="domainextensions">
                    <div class="item">
                        <div class="extension">.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.com.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.net.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.org.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.info.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.gov.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.biz.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.int.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.pro.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.health.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.name.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.edu.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.com</div>
                    </div>

                    <div class="item">
                        <div class="extension">.net</div>
                    </div>

                    <div class="item">
                        <div class="extension">.org</div>
                    </div>

                    <div class="item">
                        <div class="extension">.biz</div>
                    </div>

                    <div class="item">
                        <div class="extension">.info</div>
                    </div>

                    <div class="item">
                        <div class="extension">.cc</div>
                    </div>

                    <div class="item">
                        <div class="extension">.name</div>
                    </div>

                    <div class="item">
                        <div class="extension">.asia</div>
                    </div>

                    <div class="item">
                        <div class="extension">.me</div>
                    </div>

                    <div class="item">
                        <div class="extension">.mobi</div>
                    </div>

                    <div class="item">
                        <div class="extension">.us</div>
                    </div>

                    <div class="item">
                        <div class="extension">.tel</div>
                    </div>

                    <div class="item">
                        <div class="extension">.eu</div>
                    </div>

                    <div class="item">
                        <div class="extension">.in</div>
                    </div>

                    <div class="item">
                        <div class="extension">.tv</div>
                    </div>

                    <div class="item">
                        <div class="extension">.co</div>
                    </div>

                    <div class="item">
                        <div class="extension">.tw</div>
                    </div>

                    <div class="item">
                        <div class="extension">.ws</div>
                    </div>

                    <div class="item">
                        <div class="extension">.cn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.xxx</div>
                    </div>

                    <div class="item">
                        <div class="extension">.ac.vn</div>
                    </div>

                    <div class="item">
                        <div class="extension">.top</div>
                    </div>

                    <div class="item">
                        <div class="extension">.photo</div>
                    </div>
					
					<div class="item">
                        <div class="extension">.xyz</div>
                    </div>

                    <div class="item">
                        <div class="extension">.club</div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End of Domain Search -->

	<?php if($domain!=''){ ?>
    <section class="domainfeatures white">

        <div class="row">
            <div class="col-sm-12">
                <h2>Danh sách tên miền</h2>
                <p>Bạn chỉ có thể đặt mua những tên miền chưa có người sử dụng. Nhanh tay đăng ký trước khi có một ai đó lấy mất</p>
            </div>
        </div>

        <div class="domains-table">
            <div class="row">
                <div class="col-sm-12">
                    <table data-wow-delay="0.3s" id="tld-table" class="tablesorter responsive wow fadeInUp tablesaw tablesaw-stack tableCheckDomain" data-mode="stack">
                        <thead>
                            <tr>
                                <th>TÊN MIỀN</th>
                                <th>TÌNH TRẠNG</th>
                                <th>PHÍ KHỞI TẠO</th>
                                <th>PHÍ DUY TRÌ</th>
                                <th>PHÍ TRANSFER</th>
                                <th>PAGE RANK</th>
                                <th>ĐĂNG KÝ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="trList.vn">
                                <td><?php echo $domain;?>.vn</td>
                                <td id="status.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>350.000đ</td>
                                <td>480.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.com.vn">
                                <td><?php echo $domain;?>.com.vn</td>
                                <td id="status.com.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>350.000đ</td>
                                <td>350.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.com.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.com.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.net.vn">
                                <td><?php echo $domain;?>.net.vn</td>
                                <td id="status.net.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>350.000đ</td>
                                <td>350.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.net.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.net.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.org.vn">
                                <td><?php echo $domain;?>.org.vn</td>
                                <td id="status.org.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.org.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.org.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.info.vn">
                                <td><?php echo $domain;?>.info.vn</td>
                                <td id="status.info.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.info.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.info.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.gov.vn">
                                <td><?php echo $domain;?>.gov.vn</td>
                                <td id="status.gov.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.gov.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.gov.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.biz.vn">
                                <td><?php echo $domain;?>.biz.vn</td>
                                <td id="status.biz.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>350.000đ</td>
                                <td>350.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.biz.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.biz.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.int.vn">
                                <td><?php echo $domain;?>.int.vn</td>
                                <td id="status.int.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.int.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.int.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.pro.vn">
                                <td><?php echo $domain;?>.pro.vn</td>
                                <td id="status.pro.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.pro.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.pro.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.health.vn">
                                <td><?php echo $domain;?>.health.vn</td>
                                <td id="status.health.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.health.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.health.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.name.vn">
                                <td><?php echo $domain;?>.name.vn</td>
                                <td id="status.name.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>30.000đ</td>
                                <td>30.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.name.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.name.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.edu.vn">
                                <td><?php echo $domain;?>.edu.vn</td>
                                <td id="status.edu.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.edu.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.edu.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.ac.vn">
                                <td><?php echo $domain;?>.ac.vn</td>
                                <td id="status.ac.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>200.000đ</td>
                                <td>200.000đ</td>
                                <td>Miễn phí</td>
                                <td id="pagerank.ac.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.ac.vn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.com">
                                <td><?php echo $domain;?>.com</td>
                                <td id="status.com"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>250.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.com"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.com"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.net">
                                <td><?php echo $domain;?>.net</td>
                                <td id="status.net"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>250.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.net"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.net"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.org">
                                <td><?php echo $domain;?>.org</td>
                                <td id="status.org"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>260.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.org"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.org"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
                            <tr id="trList.biz">
                                <td><?php echo $domain;?>.biz</td>
                                <td id="status.biz"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>250.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.biz"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.biz"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.info">
                                <td><?php echo $domain;?>.info</td>
                                <td id="status.info"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>260.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.info"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.info"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.cc">
                                <td><?php echo $domain;?>.cc</td>
                                <td id="status.cc"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>700.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.cc"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.cc"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.name">
                                <td><?php echo $domain;?>.name</td>
                                <td id="status.name"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>260.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.name"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.name"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.asia">
                                <td><?php echo $domain;?>.asia</td>
                                <td id="status.asia"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>400.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.asia"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.asia"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.me">
                                <td><?php echo $domain;?>.me</td>
                                <td id="status.me"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>650.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.me"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.me"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.mobi">
                                <td><?php echo $domain;?>.mobi</td>
                                <td id="status.mobi"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>450.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.mobi"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.mobi"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.us">
                                <td><?php echo $domain;?>.us</td>
                                <td id="status.us"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>250.000đ</td>
                                <td>250.000đ</td>
                                <td id="pagerank.us"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.us"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.tel">
                                <td><?php echo $domain;?>.tel</td>
                                <td id="status.tel"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>400.000đ</td>
                                <td>390.000đ</td>
                                <td id="pagerank.tel"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.tel"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.eu">
                                <td><?php echo $domain;?>.eu</td>
                                <td id="status.eu"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>260.000đ</td>
                                <td>250.000đ</td>
                                <td id="pagerank.eu"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.eu"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.in">
                                <td><?php echo $domain;?>.in</td>
                                <td id="status.in"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>450.000đ</td>
                                <td>440.000đ</td>
                                <td id="pagerank.in"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.in"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.tv">
                                <td><?php echo $domain;?>.tv</td>
                                <td id="status.tv"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>650.000đ</td>
                                <td>640.000đ</td>
                                <td id="pagerank.tv"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.tv"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.co">
                                <td><?php echo $domain;?>.co</td>
                                <td id="status.co"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>700.000đ</td>
                                <td>690.000đ</td>
                                <td id="pagerank.co"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.co"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.tw">
                                <td><?php echo $domain;?>.tw</td>
                                <td id="status.tw"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>1.118.000đ</td>
                                <td>894.000đ</td>
                                <td id="pagerank.tw"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.tw"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.ws">
                                <td><?php echo $domain;?>.ws</td>
                                <td id="status.ws"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>650.000đ</td>
                                <td>640.000đ</td>
                                <td id="pagerank.ws"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.ws"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.cn">
                                <td><?php echo $domain;?>.cn</td>
                                <td id="status.cn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>968.000đ</td>
                                <td>774.000đ</td>
                                <td id="pagerank.cn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.cn"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.xxx">
                                <td><?php echo $domain;?>.xxx</td>
                                <td id="status.xxx"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>2.400.000đ</td>
                                <td>2.390.000đ</td>
                                <td id="pagerank.xxx"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.xxx"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.top">
                                <td><?php echo $domain;?>.top</td>
                                <td id="status.top"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>2.400.000đ</td>
                                <td>2.390.000đ</td>
                                <td id="pagerank.top"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.top"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.photo">
                                <td><?php echo $domain;?>.photo</td>
                                <td id="status.photo"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>460.000đ</td>
                                <td>450.000đ</td>
                                <td id="pagerank.photo"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.photo"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
							<tr id="trList.xyz">
                                <td><?php echo $domain;?>.xyz</td>
                                <td id="status.xyz"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>285.000đ</td>
                                <td>250.000đ</td>
                                <td id="pagerank.xyz"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.xyz"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
                            <tr id="trList.club">
                                <td><?php echo $domain;?>.club</td>
                                <td id="status.club"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td>Miễn phí</td>
                                <td>360.000đ</td>
                                <td>10.000đ sau 06 tháng</td>
                                <td id="pagerank.club"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                                <td id="button.club"><img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    <div id="dialog" title="Thông tin tên miền"></div>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
	<script>
		var listType = JSON.parse('<?php echo $listType;?>');
		var listIDDomain = JSON.parse('<?php echo $listIDDomain;?>');
		
		var domain = '<?php echo $domain;?>';
		var typeSelect = '<?php echo $typeSelect;?>';
		
		if(typeSelect!=''){
			document.getElementById(typeSelect).selected = true;
		}
		
		if(domain != ''){
			listType.forEach(function(typeDomain) {
				document.getElementById('trList.'+typeDomain).style.display = "table-row";
				document.getElementById('pagerank.'+typeDomain).innerHTML = '<img src="http://www.prapi.net/pr.php?url='+domain+'.'+typeDomain+'" />';
				checkDomain(domain,typeDomain);
			});
		}
		
		function checkDomain(domain,typeDomain)
		{
			var type= '.'+typeDomain;
			
			$.ajax({
				url: "<?php echo $urlHomes.'app/Plugin/managerHost/view/checkDomainExit.php';?>",
				type: "POST",
				data: {domain:domain+type}
			}).done(function(data) {
              
				if(parseInt(data)==0){
					document.getElementById('status'+type).innerHTML = 'Đã đăng ký';
					document.getElementById('button'+type).innerHTML = '<input class="btn btn-primary" onclick="viewInfoDomain('+"'"+domain+type+"'"+','+"'"+type+"'"+');" type="button" value="Xem thông tin" />';
				} else {
					document.getElementById('status'+type).innerHTML = 'Chưa đăng ký';
					document.getElementById('button'+type).innerHTML = '<a href="<?php echo $urlHomes;?>register-product/domain-'+typeDomain+'/'+listIDDomain[typeDomain]+'/'+domain+type+'"><input class="btn btn-danger" type="button" value="Đăng ký" /></a>';

				}
			});
		}
		
		
		function viewInfoDomain(domainSeach,type)
		{
			document.getElementById('button'+type).innerHTML = '<img src="<?php echo $urlThemeActive;?>images/ajax-loader.gif" />';
			$.ajax({
				url: "<?php echo $urlHomes.'app/Plugin/managerHost/view/getInfoDomain.php';?>",
				type: "POST",
				data: {domain:domainSeach}
			}).done(function(data) {
				$( "#dialog" ).html(data);
				$( "#dialog" ).dialog({
					width: 1000,
					height: 500,
					show: { effect: "blind", duration: 800 },
					hide: { effect: "explode", duration: 1000 },
					
				});
				document.getElementById('button'+type).innerHTML = '<input class="btn btn-primary" onclick="viewInfoDomain('+"'"+domainSeach+"'"+','+"'"+type+"'"+');" type="button" value="Xem thông tin" />';
			});
		}
		
	</script>
	<style>
		.ui-dialog
		{
			position: fixed;
		}
		.tableCheckDomain tbody tr{
			display: none;
		}
	</style>
	<?php }?>

    <?php getFooter();?>