<?php

add_action( 'after_setup_theme', 'deel_setup' );

include_once('admin-settings.php');

function deel_setup(){

    //去除头部冗余代码
    remove_action( 'wp_head',   'feed_links_extra', 3 );
    remove_action( 'wp_head',   'rsd_link' );
    remove_action( 'wp_head',   'wlwmanifest_link' );
    remove_action( 'wp_head',   'index_rel_link' );
    remove_action( 'wp_head',   'start_post_rel_link', 10, 0 );
    remove_action( 'wp_head',   'wp_generator' );
    //
    add_theme_support( 'custom-background' );
    //隐藏admin Bar
    add_filter('show_admin_bar','hide_admin_bar');

    //关键字
    add_action('wp_head','deel_keywords');

    //页面描述
    add_action('wp_head','deel_description');

    //阻止站内PingBack
    if( dopt('d_pingback_b') ){
        add_action('pre_ping','deel_noself_ping');
    }

    //评论回复邮件通知
    add_action('comment_post','comment_mail_notify');

    //自动勾选评论回复邮件通知，不勾选则注释掉
    // add_action('comment_form','deel_add_checkbox');

    //评论表情改造，如需更换表情，img/smilies/下替换
    add_filter('smilies_src','deel_smilies_src',1,10);

    //移除自动保存和修订版本
    if( dopt('d_autosave_b') ){
        add_action('wp_print_scripts','deel_disable_autosave' );
        remove_action('pre_post_update','wp_save_post_revision' );
    }

    //去除自带js
    wp_deregister_script( 'l10n' );

    //修改默认发信地址
    add_filter('wp_mail_from', 'deel_res_from_email');
    add_filter('wp_mail_from_name', 'deel_res_from_name');

    //缩略图设置
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(220, 150, true);

    add_editor_style('editor-style.css');

    //头像缓存
    if( dopt('d_avatar_b') ){
        add_filter('get_avatar','deel_avatar');
    }
	//定义菜单
	if (function_exists('register_nav_menus')){
        register_nav_menus( array(
            'nav' => __('网站导航'),
            'pagemenu' => __('页面导航')
        ));
    }

}

//阻止站内文章Pingback
function deel_noself_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}

//关键字
function deel_keywords() {
    global $s, $post;
    $keywords = '';
    if ( is_single() ) {
        if ( get_the_tags( $post->ID ) ) {
            foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
        }
        foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
        $keywords = substr_replace( $keywords , '' , -2);
    } elseif ( is_home () )    { $keywords = dopt('d_keywords');
    } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
    } elseif ( is_category() ) { $keywords = single_cat_title('', false);
    } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
    } else { $keywords = trim( wp_title('', false) );
    }
    if ( $keywords ) {
        echo "<meta name=\"keywords\" content=\"$keywords\">\n";
    }
}

//网站描述
function deel_description() {
    global $s, $post;
    $description = '';
    $blog_name = get_bloginfo('name');
    if ( is_singular() ) {
        if( !empty( $post->post_excerpt ) ) {
            $text = $post->post_excerpt;
        } else {
            $text = $post->post_content;
        }
        $description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
        if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
    } elseif ( is_home () )    { $description = dopt('d_description'); // 首頁要自己加
    } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
    } elseif ( is_category() ) { $description = trim(strip_tags(category_description()));
    } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
    } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
    } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
    }
    $description = mb_substr( $description, 0, 220, 'utf-8' );
    echo "<meta name=\"description\" content=\"$description\">\n";
}

function hide_admin_bar($flag) {
    return false;
}

/*---------------------*/
/*载入 Javascript, CSS
/*----------------------*/
add_action('wp_enqueue_scripts', 'uazoh_enqueue_style');
function uazoh_enqueue_style()
{
    //Javascript
    //CSS
    if(is_home()){
        wp_enqueue_style('tuya-carousel', get_stylesheet_directory_uri() . '/css/carousel.css');
    }
    // Load our main stylesheet.
    wp_enqueue_style('tuya-style', get_stylesheet_uri());
}

//添加相关文章图片文章
if (function_exists('add_theme_support')) add_theme_support('post-thumbnails');

//输出缩略图地址
function post_thumbnail_src()
{
    global $post;
    if ($values = get_post_custom_values("thumb")) { //输出自定义域图片地址
        $values = get_post_custom_values("thumb");
        $post_thumbnail_src = '1'; //$values [0];
    } /*elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
        $post_thumbnail_src = $thumbnail_src [0];
    }*/ else {
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $post_thumbnail_src = $matches [1] [0]; //获取该图片 src
        if (empty($post_thumbnail_src)) { //如果日志中没有图片，则显示随机图片
            $random = mt_rand(1, 5);
            echo get_bloginfo('template_url');
            $post_thumbnail_src = '/img/pic/' . $random . '.jpg';
            //如果日志中没有图片，则显示默认图片
            //echo '/img/thumbnail.png';
        }
    };
    echo $post_thumbnail_src;
}

if( function_exists('register_sidebar') ) {
    register_sidebar(array(
    'before_widget' => '<li>', // widget 的开始标签
    'after_widget' => '<li>', // widget 的结束标签
    'before_title' => '<li>', // 标题的开始标签
    'after_title' => '<li>' // 标题的结束标签
));
}

function ziluolan_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Widget Area', 'twentyfifteen' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}

add_action( 'widgets_init', 'ziluolan_widgets_init' );

if( !function_exists('ziluolan_register_main_menu') ) {
    function ziluolan_register_main_menu() {
        register_nav_menus(
            array(
                'top_menu' => __('主菜单', 'ziluolan'),
                'footer_menu' => __('页脚菜单', 'ziluolan'),
                'bottom_menu' => __('底部菜单', 'ziluolan'),
                '404_menu' => __('404页面菜单', 'ziluolan')
            )
        );}
    add_action( 'init', 'ziluolan_register_main_menu' );
}

function dmeng_paging_nav($cur_page) {
    global $wp_query;
    $pages = $wp_query->max_num_pages; //获取总页数
    if ( $pages >= 2 ): //判断当页数大于等于2时，也就是有分页时输出以下内容
        $big = 999999999; // 需要一个不可能有这么大的页数
        $paginate = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'end_size' => 3, //最多显示13个页码
            'type' => 'array' //数组类型
        ) );
        //我添加了HTML代码和样式，你可以修改或者删除
        echo '<ul class="pagination pagination-lg">';
        foreach ($paginate as $value) {
            if(strpos($value, "current")){
                echo '<li class="active">'.$value .  '</li>';
            }else
                echo '<li>'.$value .  '</li>';
        }
        echo '</ul>';
    endif;//结束判断
}

//菜单自定义链接使用target='_blank'
function add_custom_url_target_attr($sorted_menu_items)
{
    foreach ( $sorted_menu_items as $menu ) {
        if( $menu->type = 'custom' ){
            $menu->target = '_blank';
        }
    }
    return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects', 'add_custom_url_target_attr');

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';


function dopt($e){
    return stripslashes(get_option($e));
}
