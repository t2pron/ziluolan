<?php global $smof_data; ?>

<footer class="ziluolan-footer">
    <div class="container">
        <div class="row footer-top">
            <div class="col-lg-2 col-md-2">
                <div class="ziluolan-widget ziluolan-links-widget">
                    <h3>链接</h3>

                    <div class="ziluolan-widget-inner">

                        <?php wp_nav_menu( array(
                            'theme_location' => 'footer_menu',
                            'container'=> false,
                            'menu_id' => 'footer_top_nav',
                            'menu_class' => 'mobile-menu',
                            'sort_column' => 'menu_order',
                            'fallback_cb' => ''));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="ziluolan-widget ziluolan-links-widget ziluolan-about-widget">
                    <h3>超凡设计</h3>

                    <div class="ziluolan-widget-inner">
                        <ul>
                            <?php
                            global $post;
                            $postid = $post->ID;
                            $args = array('orderby' => 'rand', 'post__not_in' => array($post->ID), 'showposts' => 9);
                            $query_posts = new WP_Query();
                            $query_posts->query($args);
                            while ($query_posts->have_posts()) : $query_posts->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>" rel="bookmark"
                                       title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>

                                    <span class="border"></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3">
                <div class="ziluolan-widget ziluolan-tags-widget">
                    <h3>更多分类 </h3>

                    <div class="ziluolan-widget-inner">
                        <?php wp_tag_cloud('smallest=13&largest=13&number=30&orderby=count'); ?>
                        <?php if (isset($smof_data['tags_more_enabled'])) {
                            if ($smof_data['tags_more_enabled'] != 0) { ?>
                                <p><a href="<?php echo $smof_data['tags_more_url']; ?>"
                                      class="ziluolan-btn ziluolan-btn-primary ziluolan-btn-small btn btn-default">
                                    <i class="fa fa-plus"></i>
                                        更多分类
                                    </a>
                                </p>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3">
                <div class="ziluolan-widget ziluolan-about-widget">
                    <h3>关注 | 联系</h3>

                    <div
                        class="ziluolan-widget-inner">
                        <?php if (isset($smof_data['weixin_qrcode']['url']) && ($smof_data['weixin_qrcode']['url'] != '')) { ?>
                            <img src="<?php echo $smof_data['weixin_qrcode']['url']; ?>"
                                 alt="<?php bloginfo('name') ?> qr-code"><?php } else { ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/qrcode.jpg"
                                 alt="<?php bloginfo('name') ?> qr-code"><?php } ?>
                        <?php
                        echo '<p class="contacts" style="border-top-width: 1px; margin-top: 30px;"><i class="fa fa-weixin"></i>洁行诚品</p>';

                        if( dopt('d_facebook_b') )
                            echo '<p class="contacts"><i class="fa fa-phone"></i> ' . dopt('d_facebook') . '</p>';
                        if( dopt('d_twitter_b') )
                            echo '<p class="contacts"><i class="fa fa-map-marker"></i> ' . dopt('d_twitter') . '</p>';

                        if (isset($smof_data['header_social']) && ($smof_data['header_social'] != 0)) {
                            ?>
                            <?php
                           /*$social_links = array('weixin', 'phone', 'envelope', 'map-marker');
                           if ($social_links) {
                                foreach ($social_links as $social_link) {
                                    if (!empty($smof_data[$social_link])) {
                                        echo '<p class="contacts"><i class="fa fa-' . $social_link . '"></i> ' . $smof_data[$social_link] . '</p>';

                                    }
                                }
                            }*/
                        } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="ziluolan-widget ziluolan-copyright-widget text-center">
                    <div class="ziluolan-widget-inner">
                        <p><?php if (isset($smof_data['copyright_textarea']) && ($smof_data['copyright_textarea'] != '')) {
                                echo wp_kses_post($smof_data['copyright_textarea']);
                            } else {
                                echo ' Copyright 2015 by <a href="http://www.91ziluolan.com">洁行诚品</a>. All Rights Reserved.';
                            }?></p>

                        <p><?php $menu_list = strip_tags(wp_nav_menu(
                                array('theme_location' => 'bottom_menu',
                                    'container' => false, 'echo' => false,
                                    'items_wrap' => '%3$s', 'after' => ' / ',
                                    'fallback_cb' => '')), '<a>');
                            $menu_lists = substr($menu_list, 0, strlen($menu_list) - 3);
                            echo $menu_lists; ?></p>
                    </div>
                </div><?php if (isset($smof_data['footer_css_js']) && ($smof_data['footer_css_js'] != '')) {
                    echo $smof_data['footer_css_js'];
                } ?>
            </div>
        </div>
    </div>
    <div class="trackcode pull-right">
        <?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>
    </div>
</footer>
<?php wp_footer(); ?>
<?php if( dopt('d_footcode_b') ) echo dopt('d_footcode'); ?>
</body> </html>