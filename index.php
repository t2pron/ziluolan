<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link http://91ziluolan.com/}
 *
 * @package tuya
 * @subpackage ziluolan
 * @since ziluolan 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class=""></li>
            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
            <li data-target="#myCarousel" data-slide-to="2" class="active"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>/05/789.html" target="_blank">
                <img class="first-slide"
                     src="<?php echo get_template_directory_uri(); ?>/img/789.jpg"

                     alt="First slide">
                </a>
            </div>
            <div class="item">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>/05/799.html" target="_blank">
                <img class="second-slide"
                     src="<?php echo get_template_directory_uri(); ?>/img/799.jpg"
                     alt="Second slide">
                </a>
            </div>
            <div class="item active">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>/05/805.html" target="_blank">
                <img class="third-slide"
                     src="<?php echo get_template_directory_uri(); ?>/img/805.jpg"
                     alt="Third slide">
                </a>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!--最新内容和公司简介-->
    <div class="container projects ">
        <div class="page-header title-header span7  text-center">
            <h2><?php bloginfo('name'); ?></h2>

            <p><?php bloginfo('description'); ?></p>
        </div>

        <div class="row">

            <main id="main" class="site-main" role="main">


                <?php if (have_posts()) : ?>

                    <?php
                    // Start the loop.
                    while (have_posts()) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part('content-index', get_post_format());

                        // End the loop.
                    endwhile; // Previous/next page navigation.

                    /*the_posts_pagination( array(
                     'prev_text'          => __( '上一页' ),
                     'next_text'          => __( '下一页' ),
                     'before_page_number' => '<span class="meta-nav screen-reader-text">' .   '第' . ' </span>',
                      'after_page_number' => '<span class="meta-nav screen-reader-text">' .   '页' . ' </span>',
                    ) );*/

                   /* echo "<div class='page_navi'>"; dmeng_paging_nav(5);
                    echo "</div>";*/


        //不要翻页只要更多
                // If no content, include the "No posts found" template.
                else :
                    get_template_part('content', 'none');

                endif;
                ?>

            </main>

        </div>
        <div class="text-center row">
            <?php dmeng_paging_nav($paged); ?>
        </div>
    </div>

    <div class="container projects ">
        <!--明星产品start product -->
        <h2 id="navbar-text">人气产品</h2>

        <div class="row">

            <main id="main" class="site-main" role="main">
                <?php
                $post_num = 4; // 设置调用条数
                $args = array(
                    'post_password' => '',
                    'post_status' => 'publish', // 只选公开的文章.
                    'post__not_in' => array($post->ID), //排除当前文章
                    'caller_get_posts' => 1, // 排除置顶文章.
                    'orderby' => 'comment_count', // 依评论数排序.
                    'posts_per_page' => $post_num
                );
                $query_posts = new WP_Query();
                $query_posts->query($args);
                while ($query_posts->have_posts()) {
                    $query_posts->the_post(); ?>
                    <?php get_template_part('content-index', get_post_format());
                }
                ?>

            </main>

        </div>
    </div>
</div><!-- .content-area -->

<?php get_footer(); ?>
