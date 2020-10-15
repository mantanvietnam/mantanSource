	<?php getHeader();?>
    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-12">
                <h1>Đăng ký nhận tin</h1>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <!-- Blog -->
    <div class="blog single">
    	<div class="row">
            <div class="col-sm-8">
                <!-- Blog Post-->
                <article>
                	<div class="post-content content-view">
                        <form method="post" action="<?php echo $urlHomes.'add-subscribe';?>">
        					<h2><?php echo $tmpVariable['mess'];?></h2>
        					Email <input type="email" required="" placeholder="Nhập email nhận mã khuyến mại" name="email" value=""> 
                            <input type="submit" value="SUBSCRIBE" />
                        </form>
    				</div>
                </article>
                <!-- End of Blog Post-->
            </div>

        </div>
	</div>

    <!-- End of Blog -->
    <?php getFooter();?>