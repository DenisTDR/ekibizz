<?php
include "inc/php/funcs.php";
require "inc/php/mysqli.php";
@session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <title><?php echo TR("site_title"); ?> </title>

		<!-- Site LESS -->
		<link rel="stylesheet/less" href="inc/less/site.less">

        <link rel="stylesheet" type="text/css" media="screen" href="inc/css/css.css">
        <link rel="stylesheet" type="text/css" media="screen" href="inc/css/controls.css">
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <link href="inc/css/table.default.css" rel="stylesheet">
        <link href="inc/css/alertify.core.css" rel="stylesheet">
        <link href="inc/css/alertify.bootstrap.css" rel="stylesheet">

        <script src="inc/js/jquery-2.1.0.min.js"></script>
        <script src="inc/js/colResizable-1.3.min.js"></script>
        <script src="inc/js/jquery.tablesorter.min.js"></script>
        <script src="inc/js/alertify.min.js"></script>
        <script src="inc/tinymce/tinymce.min.js"></script>
        <script src="inc/js/js.js"></script>
        <script src="inc/js/funcs.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuHC2609sfja6AlHevosmQwllFUYpIWGo"></script>
		<!-- LESS -->
		<script>
			less = {
				env: "production",
				async: false,
				fileAsync: false,
				poll: 1000,
				functions: {},
				dumpLineNumbers: "comments",
				relativeUrls: false
			};
		</script>
		<script src="inc/js/less.js"></script>

		<!-- Modernizr -->
		<script src="inc/js/modernizr.min.js"></script>
		
		<!-- Favicon -->
		<!--link rel="shortcut icon" href="assets/img/favicon.ico"-->

	</head>
	<body>

    <?php
    if(isset($_SESSION['logged']))
        include "pages/u/userMenu.php";
    ?>
		<div id="top" data-img="images/ebt_main.jpg">
			<div>
				<img src="images/logo.png" alt="">
				<a href="#inasagi" class="btn btn-default" id="inasagi">GET INTO THE BUSINESS ENVIRONMENT</a>
			</div>
		</div>
		<div class="rBody" style="">
            <nav class="navbar navbar-default" role="navigation" >
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ac-kapa">
                            <span class="sr-only">Menu</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="?pn=homep">EBO</a>
                    </div>
                    <div class="collapse navbar-collapse navbar-ac-kapa">
                        <ul class="nav navbar-nav navbar-right" id="menuUl">
                            <li> <a onclick="gotoPage('homep'); return false;" href="?pn=homep"><?php echo TR("home"); ?></a></li>
                            <li> <a onclick="gotoPage('abouttrainings'); return false;" href="?pn=abouttrainings" ><?php echo TR("about_trainings"); ?> </a> </li>
                            <li> <a onclick="gotoPage('howitworks'); return false;" href="?pn=howitworks"><?php echo TR("how_it_works"); ?></a></li>
                            <li> <a onclick="gotoPage('yourbusiness'); return false;" href="?pn=yourbusiness"><?php echo TR("your_bizz"); ?></a></li>
                            <li> <a onclick="gotoPage('traininglocation'); return false;" href="?pn=traininglocation"><?php echo TR("training_location"); ?></a></li>
                            <li>
                                <?php if(!isset($_SESSION['logged'])){ ?>
                                    <a onclick="gotoPage('ulogin'); return false;" href="?pn=ulogin"><?php eTR("login"); ?></a>
                                <?php }else{ ?>
                                    <a onclick="gotoPage('umyaccount'); return false;" href="?pn=umyaccount"><?php eTR("my_account"); ?></a>
                                <?php } ?>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Language <b class="caret"></b></a>
                                <ul class="dropdown-menu langUl">
                                    <li><a data-lang="en">English</a></li>
                                    <li><a data-lang="tr">Turkish</a></li>
                                    <li><a data-lang="ro">Română</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div>
                <div id="contentDiv" style='display:none'>
                    <?php
                    if(isset($_REQUEST['pn']))
                        Page($_REQUEST['pn']);
                    else
                        include "pages/homep.php";
                    ?>
                </div>
            </div>
            <div id="notificationArea">
            </div>
            <div id="buraya"></div>


            <!--footer>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            Copyright &copy; <a href="http://www.simturk.com">SimTurk Internet Hizmetleri</a> | All right reserved!
                        </div>
                    </div>
                </div>
            </footer-->

            <a href="#buraya" id="yuhari"><span class="fa fa-chevron-up fa-4x">abc</span></a>
        </div>
		<!-- jQuery UI -->
		<script>window.jQueryUI || document.write('<script src="inc/js/jquery-ui.min.js"><\/script>')</script>

		<!-- Eklentiler -->
		<script src="inc/js/bootstrap.min.js"></script>
		<script src="inc/js/jquery.themepunch.plugins.min.js"></script>
		<script src="inc/js/jquery.themepunch.revolution.min.js"></script>
		
		<!-- Runner JS -->
		<script src="inc/js/script.js"></script>
        <script>
            colorLink();
            var loading_page='<?php eTR('loading_page'); ?>';
            var please_wait='<?php eTR('please_wait'); ?>';
            var page_loaded='<?php eTR('page_loaded'); ?>';
            var updating_pw='<?php eTR('updating_pw'); ?>';
            var loading_flag=false;
            <?php if(isset($_REQUEST['pn'])) { ?>
                $('#top').slideUp(1);
                $("#contentDiv").slideDown(1);
            <?php } ?>
        </script>
	</body>
</html>
