<?php

function singleCenik() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__cenik();
			} else {
				echo handlePostNotificationError($error['messages']);
			}
		}
	}

	$item_id = get_the_ID();

	?>
	<div class='form__wrapper cenikiEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class='form__title'>
				<h2>Urejanje cenika: <?php echo get_the_title($item_id)?></h2>
			</div>

			<?php
				$vrsta = getField__value('vrsta_cenika');
				if($vrsta === 'cenik_abc'){

					if ( have_rows( 'cenik_abc' ) ) {
			    		while( have_rows( 'cenik_abc' ) ) {
			    			the_row();
			    			$seznam = array();
			    			$seznam['a']['label'] = getField__Label('cenik_a', 'cenik_abc');
							$seznam['a']['input'] = getField__input('cenik_a', 'cenik_abc');
							$seznam['b']['label'] = getField__Label('cenik_b', 'cenik_abc');
							$seznam['b']['input'] = getField__input('cenik_b', 'cenik_abc');
							$seznam['c']['label'] = getField__Label('cenik_c', 'cenik_abc');
							$seznam['c']['input'] = getField__input('cenik_c', 'cenik_abc');
							?>
							<div class="form__row">
								<div class="form__label"><?php echo $seznam['a']['label'] ?></div>
								<div class="form__value"><?php echo $seznam['a']['input'] ?><span class="sign-eur">€</span></div>
							</div>
							<div class="form__row">
								<div class="form__label"><?php echo $seznam['b']['label'] ?></div>
								<div class="form__value"><?php echo $seznam['b']['input'] ?><span class="sign-eur">€</span></div>
							</div>
							<div class="form__row">
								<div class="form__label"><?php echo $seznam['c']['label'] ?></div>
								<div class="form__value"><?php echo $seznam['c']['input'] ?><span class="sign-eur">€</span></div>
							</div>
							<?php 
						}
			    	}

					
				} else if ($vrsta === 'spisek_cen'){
					if ( have_rows( 'spisek_cen' ) ) {
			    		while( have_rows( 'spisek_cen' ) ) {
			    			the_row();
			    			?>
			    			<div class="form__message"><?php echo getField__label('cena_1', 'spisek_cen') ?></div>
			    			<?php if ( have_rows( 'cena_1' ) ) {
					    		while( have_rows( 'cena_1' ) ) {
					    			the_row(); ?>
					    			<div class="form__row">
						    			<div class="form__label"><?php echo getField__label('naziv', 'cena_1') ?></div>
										<div class="form__value"><?php echo getField__input('naziv', 'cena_1') ?></div>
									</div>
					    			<div class="form__row">
						    			<div class="form__label"><?php echo getField__label('vrednost', 'cena_1') ?></div>
										<div class="form__value"><?php echo getField__input('vrednost', 'cena_1') ?><span class="sign-eur">€</span></div>
									</div>
					    			<?php
					    		}
					    	} ?>
			    			<div class="form__message"><?php echo getField__label('cena_2', 'spisek_cen') ?></div>
			    			<?php if ( have_rows( 'cena_2' ) ) {
					    		while( have_rows( 'cena_2' ) ) {
					    			the_row(); ?>
					    			<div class="form__row">
						    			<div class="form__label"><?php echo getField__label('naziv', 'cena_2') ?></div>
										<div class="form__value"><?php echo getField__input('naziv', 'cena_2') ?></div>
									</div>
					    			<div class="form__row">
						    			<div class="form__label"><?php echo getField__label('vrednost', 'cena_2') ?></div>
										<div class="form__value"><?php echo getField__input('vrednost', 'cena_2') ?><span class="sign-eur">€</span></div>
									</div>
					    			<?php
					    		}
					    	} ?>
			    			<div class="form__message"><?php echo getField__label('cena_3', 'spisek_cen') ?></div>
			    			<?php if ( have_rows( 'cena_3' ) ) {
					    		while( have_rows( 'cena_3' ) ) {
					    			the_row(); ?>
					    			<div class="form__row">
						    			<div class="form__label"><?php echo getField__label('naziv', 'cena_3') ?></div>
										<div class="form__value"><?php echo getField__input('naziv', 'cena_3') ?></div>
									</div>
					    			<div class="form__row">
						    			<div class="form__label"><?php echo getField__label('vrednost', 'cena_3') ?></div>
										<div class="form__value"><?php echo getField__input('vrednost', 'cena_3') ?><span class="sign-eur">€</span></div>
									</div>
					    			<?php
					    		}
					    	}
						}
					}
				} else { ?>
					<div class="form__row">
						<div class="form__label"><?php echo getField__label('cena') ?></div>
						<div class="form__value"><?php echo getField__input('cena') ?><span class="sign-eur">€</span></div>
					</div>
				<?php }
			?>

			<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Posodobi cenik' >
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>
	<?php

}

function handlePostUpdate__cenik(){

	$item_id = $_POST["item_id"];
	$messages = array();

	if(isset($_POST["cena"]['value'])){
		$val = $_POST["cena"]['value'];
		update_field('cena', $val, $item_id);
		array_push($messages, "Cena uspešno posodobljena.");
	}

	foreach($_POST as $key => $value){
		if(strpos($key, 'cenik_abc') !== false){

			$sb = explode('_0', $key);
			$field = $sb[0].$sb[1];

			if(isset($value['value']) && $value['value'] !== ''){
				update_field( $field, $value['value'] );
				array_push($messages, "Polje <b>".$sb[1]."</b> uspešno posodobljeno.");
			}
		}

		if(strpos($key, 'spisek_cen') !== false){

			$sb = explode('_0', $key);
			$field = $sb[0].$sb[1].$sb[2];

			if(isset($value['value']) && $value['value'] !== ''){
				update_field( $field, $value['value'] );
				array_push($messages, "Polje <b>".$sb[1]." - ".$sb[2]."</b> uspešno posodobljeno.");
			}
	    
		}

	}

	return handlePostNotificationUpdate($messages);
}

?>