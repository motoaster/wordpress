<?php get_header(); ?>
・TOPページのコンテンツを静的にしたい場合はhtmlのbody以下としてここに記述してください。
・TOPページに載せるコンテンツの一部は下層ページから引用したい場合は、
have_posts()やget_posts()
を使用し該当投稿の情報が引用できるよう記述しましょう。
<?php get_footer(); ?>