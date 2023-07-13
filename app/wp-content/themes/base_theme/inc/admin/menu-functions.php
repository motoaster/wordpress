<?php
/**
 * 管理画面 サポート及びメール表記設定
 *
 * @return void
 */
function register_base_menu()
{
	// 投稿とコメントのRSSフィード設定
	add_theme_support('automatic-feed-links');

	// タイトルタグ自動書き込み
	add_theme_support('title-tag');

	// 管理画面で設定するメニューのキー名を設定
	// 複数のナビゲーションメニューを登録する関数(追加したい分だけ都度付与)
	register_nav_menus(array( 
		//'「メニューの位置」の識別子' => 'メニューの説明の文字列',
		'main-menu' => 'Main Menu',
		'footer-menu'  => 'Footer Menu',
	));

	/**
	 * 投稿フォーマットの制御
	 */
	add_theme_support(
		'post-formats',
		array(
			'link',
			'aside',
			'gallery',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		)
	);

	// パラメータに指定した箇所がHTML5に準拠した形で出力
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	// 埋め込みコンテンツのレスポンシブ化.
	add_theme_support('responsive-embeds');

	// カスタムの行の高さ制御
	add_theme_support('custom-line-height');

	// リンクの色盛業
	add_theme_support('experimental-link-color');

	// スペースの制御
	add_theme_support('custom-spacing');

	// カスタムユニットを設定(px, em, rem, vh, vw etc....)
	add_theme_support('custom-units');

	// 投稿サムネイルの設定追加
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );

	// Remove feed icon link from legacy RSS widget.
	add_filter('rss_widget_feed_link', '__return_empty_string');

}
add_action('after_setup_theme', 'register_base_menu');
