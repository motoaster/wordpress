<?php 
/**
 * 投稿用のアーカイブ(一覧)ファイル。
 * [fuctions.php]やプラグインなどでカスタム投稿タイプを増やした場合は、
 * [achive-{カスタム投稿タイプ名}.php]として管理を行う。
 */
?>
<?php get_header(); ?>
<?php if (have_posts()):
   while (have_posts()) :
      the_post();
      the_content();
   endwhile;
endif; ?>
<?php previous_post_link(); ?>
<?php next_post_link(); ?>
<?php get_footer(); ?>