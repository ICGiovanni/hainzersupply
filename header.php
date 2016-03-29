<?php
    include_once $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
?>

<meta charset="utf-8">

<link rel="stylesheet" href="<?php echo $raizProy;?>css/foundation.css" type="text/css" >
<style type="text/css">
    #masthead{ height:170px;}
    #masthead{background-color:#fff; background-image:url('<?php echo $raizProy;?>images/back_img_redc.jpg'); background-repeat:repeat-x ;}
    .wide-nav {background-color:#0a0a0a}
    #top-bar{background-color:#ba0101 }
    #wrapper{
        max-width: 75%;
        margin: 0 auto
    }
    .bodyClass{
        background-image: url('<?php echo $raizProy;?>images/HainzerSupplay_Background_2016.jpg');
        background-size: cover; background-attachment: fixed; background-repeat: no-repeat;
        background-position: 50% 50%;
        height: auto;
    }
</style>
<body class="bodyClass">

    <div id="wrapper">
        <div class="header-wrapper before-sticky">
            <div class="sticky-wrapper">
                <header id="masthead" class="site-header" role="banner">
                    <div class="row">
                        <div class="large-12 columns header-container">

                            <div id="logo" class="logo-left">
                                <a href="<?php echo $raizProy;?>" title="Hainzer Supply - " rel="home">
                                    <img src="<?php echo $raizProy;?>images/Logotipo_HainzerSupply_2016_c.png" class="header_logo " alt="Hainzer Supply">
                                </a>
                            </div><!-- .logo -->

                        </div><!-- .large-12 -->
                    </div><!-- .row -->
                </header>
            </div><!-- .header -->
        </div><!-- .header-wrapper -->
    </div><!-- #wrapper -->