<!doctype html>
<html class="fixed">
    <head>
        <title>Lựa chọn khách sạn</title>
        <!-- Basic -->
        <meta charset="UTF-8">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/datepicker3.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/mOrdernizr.js"></script>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign body-locked">
            <div class="center-sign">
                <div class="panel panel-sign">
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="current-user text-center">
                                <img src="<?php echo $_SESSION['infoManager']['Manager']['avatar']; ?>" alt="Ảnh đại diện" class="img-circle user-image" />
                                <h2 class="user-name text-dark m-none"><?php echo $_SESSION['infoManager']['Manager']['fullname']; ?></h2>
                                <p class="user-email m-none"><?php echo $_SESSION['infoManager']['Manager']['email']; ?></p>
                            </div>

                            <div class="form-group mb-lg">
                                <div class="input-group input-group-icon">
                                    <select style="width: 100%" name="idHotel">
                                        <?php
                                        foreach ($listData as $data) {
                                            if(!empty($data)){
                                            echo '<option ';
                                            if (isset($_SESSION['idHotel']) && $data['Hotel']['id'] == $_SESSION['idHotel'])
                                                echo 'selected';
                                            echo ' value="' . $data['Hotel']['id'] . '">' . $data['Hotel']['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6 text-right">
                                    <button type="submit" class="btn btn-primary">Chọn</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.browser.mobile.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/bootstrap.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/nanoscroller.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/magnific-popup.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.placeholder.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/theme.js"></script>

        <!-- Theme Custom -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/theme.init.js"></script>

    </body>
</html>