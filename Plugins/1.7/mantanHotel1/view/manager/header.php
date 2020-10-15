<!DOCTYPE html>
<html class="fixed">
    <head>

        <!-- Basic -->
        <meta charset="UTF-8">
        
        <title>Hotel365 | Quản lý khách sạn</title>
        
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" type="image/png" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/favicon.png">
        <!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/datepicker3.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/select2.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/datatables.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap-colorpicker.css"/>

        <!-- Upload file -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap-fileupload.min.css" />

        <!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/jquery-ui-1.10.4.custom.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap-multiselect.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/morris.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/default.css" />

        <!-- Head Libs -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/modernizr.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.js"></script>
        

<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
        
        <link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
        <script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>

    </head>
    <body>
        <section class="body">

            <!-- start: header -->
            <header class="header fa-height">
                <div class="logo-container">
                    <a href="<?php echo $urlHomes;?>" target="_blank" class="logo">
                        <img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/logo.png" height="35" alt="Hotel admin" />
                        Ngày hết hạn: 
                        <?php
                            $deadline= 'Vĩnh viễn';
                            if(!empty($_SESSION['infoManager']['Manager']['deadline'])){
                                $deadline= getdate($_SESSION['infoManager']['Manager']['deadline']);
                                $deadline= $deadline['mday'].'-'.$deadline['mon'].'-'.$deadline['year'];
                            }
                            echo $deadline;
                        ?> 
                        | Số phòng tối đa: 
                        <?php echo (!empty($_SESSION['infoManager']['Manager']['numberRoomMax']))?$_SESSION['infoManager']['Manager']['numberRoomMax']:'Không giới hạn';?>
                    </a>
                    <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>

                <!-- start: search & user box -->
                <div class="header-right">
                    <form class="selecthotel nav-form" action="<?php echo $urlHomes; ?>managerSelectHotel" method="post">
                        <div class="form-group">
                            <select id="selecthotel" class="form-control" required onchange="this.form.submit()" name="idHotel">
								<?php
									$listHotel=$tmpVariable['listHotel'];
									if (!empty($listHotel))
									foreach ($listHotel as $hotel)
									{
										echo '<option ';
										if (isset($_SESSION['idHotel']) && $hotel['Hotel']['id']==$_SESSION['idHotel']){
											echo 'selected';
                                        }
										echo ' value="'.$hotel['Hotel']['id'].'">'.$hotel['Hotel']['name'].'</option>';
									}
								?>
                            </select>
                        </div>
                    </form>
					
                    <span class="separetor-end"></span>

                    <div id="userbox" class="userbox">
                        <a href="#" data-toggle="dropdown">
                            <figure class="profile-picture">
                                <img src="<?php echo $_SESSION['infoManager']['Manager']['avatar']; ?>" alt="Quản lý" class="img-circle" data-lock-picture="<?php echo $_SESSION['infoManager']['Manager']['avatar']; ?>" />
                            </figure>
							<?php
								//debug ($_SESSION['infoManager']);
							?>
                            <div class="profile-info" data-lock-name="<?php echo $_SESSION['infoManager']['Manager']['user']; ?>" data-lock-email="<?php echo $_SESSION['infoManager']['Manager']['email']; ?>">
                                <span class="name"><?php echo $_SESSION['infoManager']['Manager']['fullname']; ?></span>
                                <span class="role"><?php if($_SESSION['infoManager']['Manager']['id']==$_SESSION['infoManager']['Manager']['idStaff']){echo 'Quản lý';}else{echo 'Nhân viên';} ?></span>
                            </div>

                            <i class="fa custom-caret"></i>
                        </a>

                        <div class="dropdown-menu">
                            <ul class="list-unstyled">
                                <li class="divider"></li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="/managerUserProfile"><i class="fa fa-user"></i>Tài khoản</a>
                                </li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Khóa màn hình</a>
                                </li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="<?php echo $urlHomes;?>managerLogout"><i class="fa fa-power-off"></i> Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end: search & user box -->
            </header>
            <!-- end: header -->