<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">

    <meta name="author" content="K | 91ziluolan.com">

    <link rel="shortcut icon" href="<?php echo esc_url( home_url( '/' ) ); ?>/favicon.ico" type="image/x-icon">
    <title>
        <?php if ( is_home() ) { ?>
        <?php bloginfo('name'); ?>_<?php bloginfo('description'); ?><?php } ?>
        <?php if ( is_search() ) { ?>搜索结果 for <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e(''); echo $key; _e(' &mdash; ');
        echo $count . ' ';
        _e('篇文章'); wp_reset_query(); ?>
        <?php } ?>
        <?php if ( is_404() ) { ?><?php bloginfo('name'); ?>_ 404 Nothing Found<?php } ?>
        <?php if ( is_author() ) { ?><?php bloginfo('name'); ?>_Author Archives<?php } ?>
        <?php if ( is_single() ) { ?><?php wp_title(''); ?>_<?php $category = get_the_category();echo $category[0]->cat_name;?>_<?php bloginfo('name'); ?><?php } ?>
        <?php if ( is_page() ) { ?><?php bloginfo('name'); ?>_<?php $category = get_the_category();echo $category[0]->cat_name; ?>_<?php wp_title(''); ?><?php } ?>
        <?php if ( is_category() ) { ?><?php single_cat_title(); ?>_<?php $category = get_the_category(); echo $category[0]->category_description; ?>_<?php bloginfo('name'); ?><?php } ?>
        <?php if ( is_month() ) { ?><?php bloginfo('name'); ?>_Archive_<?php the_time('F, Y'); ?><?php } ?>
        <?php if ( is_day() ) { ?><?php bloginfo('name'); ?>_Archive_<?php the_time('F j, Y'); ?><?php } ?>
        <?php if (function_exists('is_tag')) {
            if ( is_tag() ) {
                ?><?php
                single_tag_title("", true);
            } } ?>_<?php bloginfo('name');?>

    </title>
    <?php if(!empty($smof_data['custom_favicon']['url'])) { ?><link rel="icon" type="image/png" href="<?php echo esc_url($smof_data['custom_favicon']['url']); ?>" /><?php }else{echo '<link rel="icon" type="image/png" href="'.get_template_directory_uri().'/img/favicon/apple-touch-icon-144-precomposed.png" />';} ?>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
    <?php  if( dopt('d_headcode_b') ) echo dopt('d_headcode'); ?>
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <!--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<div id="sidebar" class="sidebar">
		<header id="masthead" class="site-header" role="banner">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand hidden-sm" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                    </div>
                    <div class="navbar-collapse collapse" role="navigation">
                        <nav id="site-navigation" class="main-navigation " role="navigation">

                            <?php

                            wp_nav_menu(
                                array(
                                    'theme_location' => 'top_menu',
                                    'depth' => 2,
                                    'container' => false,
                                    'sort_column'      => 'menu_order',
                                    'container_class'  => 'nav-collapse collapse',
                                    'menu_class'       => 'nav navbar-nav',
                                    'walker'           => new wp_bootstrap_navwalker(),
                                )
                            );

                            ?>


                        </nav><!-- .main-navigation -->
                        <form  action="<?php bloginfo('home');?>" method="get" class="navbar-form navbar-right" role="search">
                            <div class="form-group">
                                <input name="s"  type="text" class="form-control" placeholder="输入关键词">
                            </div>
                            <button type="submit" class="btn btn-default inverse">搜索</button>
                        </form>

                        <ul class="nav navbar-nav navbar-right hidden-sm">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/about/" onclick="_hmt.push(['_trackEvent', 'navbar', 'click', 'about'])">关于</a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- .site-branding -->

		</header><!-- .site-header -->

		<?php
        if(!is_home())
            get_sidebar();
        ?>
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
