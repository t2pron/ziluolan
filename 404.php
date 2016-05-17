<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <div class="container projects ziluolan-header">
        <div class="projects-header page-header span7  text-center">
            <h2><?php bloginfo('name'); ?></h2>

            <p><?php bloginfo('description'); ?></p>
        </div>

        <div class="row">
            <main id="main" class="site-main" role="main">

                <section class="error-404 not-found  text-center">
                    <header class="page-header">
                        <h1 class="page-title"><?php _e('哦，天呐页面被外星人抓走了！', 'ziluolan'); ?></h1>
                    </header>
                    <!-- .page-header -->

                    <div class="page-content">
                        <p><?php _e('搜索试试：', 'ziluolan'); ?></p>

                        <?php get_search_form(); ?>
                    </div>
                    <!-- .page-content -->
                </section>
                <!-- .error-404 -->

            </main>
            <!-- .site-main -->
        </div>
    </div>

</div><!-- .content-area -->

<?php get_footer(); ?>
