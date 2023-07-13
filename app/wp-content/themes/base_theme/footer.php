        <footer>
 	       <ul class="footer-navigation-wrapper">
				<?php
				// フッター用のメニュー設定
				// 複数ブロック分けを行う場合は[functions.php]に設定を追加して増やしたり階層構造にするなど調整する必要あり
				if (has_nav_menu('footer-menu')) :
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
				endif;
				?>
		</footer>
		<!-- Wordpress 設定およびプラグイン等読み込み実施。「wp_head」とセット -->
        <?php wp_footer(); ?>
    </body>
</html>