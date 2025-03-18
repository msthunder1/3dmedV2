
		</div>

	<?php wp_footer(); ?>

	<div class="footer">

		<div class="footer__top">

			<div class="container--mid footer__boxes">

				<div class="footer__widget widget">
					<?php
					if(is_active_sidebar('footer_widget_1')){
						dynamic_sidebar('footer_widget_1');
					}
					?>
				</div>

				<div class="footer__widget widget">
					<?php
					if(is_active_sidebar('footer_widget_2')){
						dynamic_sidebar('footer_widget_2');
					}
					?>
				</div>

				<div class="footer__widget widget">
					<?php
					if(is_active_sidebar('footer_widget_3')){
						dynamic_sidebar('footer_widget_3');
					}
					?>
				</div>

			</div>

		</div>

		<div class="footer__bottom">
			
			<div class="footer__widget widget">
				<?php
				if(is_active_sidebar('footer_widget_4')){
					dynamic_sidebar('footer_widget_4');
				}
				?>
			</div>

		</div>

	</div>

	</body>

</html>