<?php

function showLoginForm() {

	$registerLink = get_page_link(209);
	$variable = isset($_GET['login']) ? $_GET['login'] : '';

	?>

	<div class="loginWindow">

		<div class="loginWindow__background">
			<?php
			srcset_image(398, '100vw', 'loginWindow__image');
			?>
		</div>

		<div class="loginWindow__container">

			<?php

			if($variable === 'failed'){ ?>

				<div class="flashMessage error">
					<div class="flashMessage__single">Napaka pri prijavi. Prosimo poiskusite znova.</div>
				</div>

			<?php } ?>

			<div class="loginWindow__loginForm">
				<?php wp_login_form(
					array(
						'label_username' => __( 'E-mail' ),
				        'label_password' => __( 'Geslo' ),
				        'label_remember' => __( 'Zapomni si me' ),
				        'label_log_in'   => __( 'Prijava' ),
				    )
				); ?>
			</div>

			<div class="loginWindow__forgotPasswordWrapper">
				<div class="loginWindow__forgotPasswordText">
					V primeru, da ste izgubili geslo, <a href="<?php echo wp_lostpassword_url( home_url() ); ?>">kliknite tukaj.</a>
				</div>
			</div>

			<div class="loginWindow__registerTextWrapper">
				<div class="loginWindow__registerText">
					Še niste registrirani?<a href="<?php echo $registerLink ?>"> Registrirajte se tukaj.</a>
				</div>
			</div>

		</div>

	</div>

<?php } ?>
