<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
<div class="container projects ziluolan-header">

    <div class="row">
        <section id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php if (have_posts()) : ?>

                    <header class="page-header">
                        <h2 class="page-title">
                            <?php printf(__('全部结果: %s', 'ziluolan'), get_search_query()); ?>
                        </h2>
                    </header><!-- .page-header -->

                    <?php
                    // Start the loop.
                    while (have_posts()) : the_post(); ?>

                        <?php
                        /*
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        get_template_part('content-index', 'search');

                        // End the loop.
                    endwhile;

                    // Previous/next page navigation.
                    the_posts_pagination(array(
                        'prev_text' => __('Previous page', 'twentyfifteen'),
                        'next_text' => __('Next page', 'twentyfifteen'),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyfifteen') . ' </span>',
                    )); // If no content, include the "No posts found" template.
                else :
                    get_template_part('content', 'none');

                endif;
                ?>

            </main>
            <!-- .site-main -->
        </section>
        <!-- .content-area -->
    </div>

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
</div>
<?php get_footer(); ?>
