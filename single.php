<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="container projects ziluolan-header">
            <?php
            // Start the loop.
            while (have_posts()) : the_post();

                /*
                 * Include the post format-specific template for the content. If you want to
                 * use this in a child theme, then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                get_template_part('content-single', get_post_format());

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

                // Previous/next post navigation.
               /* the_post_navigation(array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next', 'twentyfifteen') . '</span> ' .
                    '<span class="screen-reader-text">' . __('Next post:', 'twentyfifteen') . '</span> ' .
                    '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous', 'twentyfifteen') . '</span> ' .
                    '<span class="screen-reader-text">' . __('Previous post:', 'twentyfifteen') . '</span> ' .
                    '<span class="post-title">%title</span>',
                ));*/

                // End the loop.
            endwhile;
            ?>
        </div>
    </main>
    <!-- .site-main -->

    <div class="container projects ">
        <!--明星产品start product -->
        <h2 id="navbar-text">其他产品</h2>

        <div class="row">

            <main id="main" class="site-main" role="main">
                <?php
                $post_num = 4; // 设置调用条数
                $args = array(
                    'post_password' => '',
                    'post_status' => 'publish', // 只选公开的文章.
                    'post__not_in' => array($post->ID), //排除当前文章
                    'caller_get_posts' => 1, // 排除置顶文章.
                    'orderby' => 'rand', // 依评论数排序.
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
