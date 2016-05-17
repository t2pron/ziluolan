<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<div class="col-sm-6 col-md-3">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="thumbnail">

        <img class="lazy"
             style="height: 138px; width: 100%;"
             src="<?php post_thumbnail_src(); ?>"
             width="300" height="200"
             data-src="<?php  post_thumbnail_src(); ?>"
             alt="<?php get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?>"
            >
        <div class="caption">
            <h3>
            <a href="<?php echo get_permalink() ?>" rel="bookmark"  target="_blank">
                <?php the_title() ?>
            </a>
            </h3>
            <p>
                <?php
                    foreach((get_the_category()) as $category)
                    {
                        echo  '<a target="_blank" href="'.get_category_link($category->term_id ).'">'; //链接
                        echo ' <span class="label label-success">' . $category->cat_name . '</span> ';
                        echo  '</a>';
                    }
                ?>
            </p>
        </div>

    </div>

</article>
</div>