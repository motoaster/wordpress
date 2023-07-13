<?php

/**
 * Template Name: BasePage
 * Template Post Type: page
 */
?>
<?php
/**
 * 固定ページ用のファイル。
 * 画面ごとに指定したい場合は[page-{スラッグ名}.php]とするか、
 * ファイル作成時に[Templage Name]を記載し管理画面上で設定する。
 * 特定のPostType(カスタム投稿)でのみ使用したい場合は[Template Post Type]を指定する。(複数ある場合はカンマ区切り)
 */
?>
<?php get_header(); ?>
<h2>メインループ</h2>
・固定ページ用のコンテンツを静的にしたい場合はhtmlのbody以下としてここに記述してください。
<!-- 管理画面で個別に指定している内容表示 -->
<?php if (have_posts()) :
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
endif;
wp_reset_postdata(); ?>


<!-- 投稿一覧表示(サブループ１) -->
<!-- カスタム投稿タイプ/カスタムタクソノミーを使用していない場合はこの書き方となる -->
<h2>一覧1</h2>
<?php
$args = array(
    'post_type' => 'post',
);
$my_query = new WP_Query($args);
?>
<?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
        <p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
<?php endwhile;
endif;
wp_reset_postdata(); ?>


<!-- 投稿一覧表示(サブループ2) -->
<!-- カスタム投稿タイプ/カスタムタクソノミーを追加した場合、パラメータを追加する -->
<!-- パラメータについては50を超えるため投稿に関連するもの10件程を記載 -->
<!-- ※カスタム投稿/カスタムタクソノミー/カスタムフィールドまでパラメータが設定できるため種類が多い。 -->
<!-- 参考(公式): https://developer.wordpress.org/reference/classes/wp_query/ -->
<!-- 参考(個別1): https://wemo.tech/160 -->
<!-- 参考(個別2): https://sole-color-blog.com/blog/265/ -->
<h2>一覧2</h2>
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$paginate_base = get_pagenum_link(1);
$cArgs = array(
    'post_type' => ['post', 'page'],    // 追加したカスタム投稿タイプを指定。複数ある場合は配列化して[,]区切り。
    'post_status' => 'publish',          // 投稿ステータスを指定。複数ある場合は配列化して[,]区切り。
    'posts_per_page' => 1,              // １ページ当たりに表記する表示件数。
    'nopaging' => false,                // ページ送りを使用するか指定。デフォルトは[false]。
    'paged' => $paged,                  // 投稿の表示指定。[ get_query_var('paged')]を指定している場合現在のページ
    // 'offset' => 0,                      // 投稿を呼び飛ばす場合、飛ばす投稿数を指定 ※こちら指定の場合うまくページネーションが動かない。
    'orderby' => 'date',                // 投稿の並び順の方法を指定。
    'order' => 'DESC',                  // 表示順指定。
    'has_password' => false,            // パスワード付きの投稿のみを表示するか確認。
    'post__not_in' => [12],             // 外したい投稿がある場合、IDで指定。
);
$cQuery = new WP_Query($cArgs);
?>
<?php if ($cQuery->have_posts()) : while ($cQuery->have_posts()) : $cQuery->the_post(); ?>
        <p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
<?php endwhile;
endif;
wp_reset_postdata(); ?>


<h4>ページネーション例(一覧2紐づけ)</h4>
<!-- 基本機能では複数不可。ページネーションが複数必要な場合は[fucntioncs.php]でのカスタマイズ科プラグインの導入が必要 -->
<div class="pnavi">
    <?php //ページリスト表示処理
    global $wp_rewrite;
    $paginate_base = get_pagenum_link(1);
    if (strpos($paginate_base, '?') || !$wp_rewrite->using_permalinks()) {
        $paginate_format = '';
        $paginate_base = add_query_arg('paged', '%#%');
    } else {
        $paginate_format = (substr($paginate_base, -1, 1) == '/' ? '' : '/') .
            user_trailingslashit('page/%#%/', 'paged');
        $paginate_base .= '%_%';
    }
    echo paginate_links(array(
        'base' => $paginate_base,
        'format' => $paginate_format,
        'total' => $cQuery->max_num_pages,
        'mid_size' => 1,
        'current' => ($paged ? $paged : 1),
        'prev_text' => '< 前へ',
        'next_text' => '次へ >',
    )); ?>
</div>


<h3>カテゴリー 一覧表記例1</h3>
<?php
// 固定ページに特定のカテゴリーを表示
// 基本的には投稿などの一覧表示と同じ。
$args = array(
    'post_type' => 'post',
    'category_name' => 'test',          //こちらを指定することにより特定のカテゴリの物のみ取得。複数の場合文字列のままカンマ区切り。
    'posts_per_page' => 5
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) :
?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
    <?php endwhile; ?>
<?php endif;
wp_reset_postdata(); ?>

<h3>カテゴリー 一覧表記例2</h3>
<?php
// 固定ページに特定のカテゴリーを表示
// 基本的には投稿などの一覧表示と同じ。
$targs = array(
    'post_type' => 'post',
    'posts_per_page' => 5,
    'tax_query' => array(                           // タクソノミーパラメーターを指定
        'relation' => 'OR',                         // タクソノミーの検索条件に 'AND' か 'OR' が使用可能
        array(
            'taxonomy' => 'category',               // タクソノミーを指定
            'field' => 'slug',                      // term_id(デフォルト),name,slug のいずれかのタームの種類を選択
            'terms'    =>  'test1',                 // ターム(文字列かIDを指定) ※category_nameに該当
        ),
    ),
);
$tQuery = new WP_Query($targs);
if ($tQuery->have_posts()) :
?>
    <?php while ($tQuery->have_posts()) : $tQuery->the_post(); ?>
        <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
    <?php endwhile; ?>
<?php endif;
wp_reset_postdata(); ?>

<div style="padding-bottom:16px"></div>
<?php get_footer(); ?>