<?php

function seznam_prejetih_narocil_shortcode(){

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	} ?>

	<div class="seznamNarocil">
		<div class="seznamNarocil__date">
			<div class="seznamNarocil__dateLabel">Od datuma</div>
			<div class="seznamNarocil__dateInputWrapper">
				<input type="date" class="seznamNarocil__dateInput js-narocila-seznam-od">
			</div>
		</div>
		<div class="seznamNarocil__date">
			<div class="seznamNarocil__dateLabel">Do datuma</div>
			<div class="seznamNarocil__dateInputWrapper">
				<input type="date" class="seznamNarocil__dateInput js-narocila-seznam-do">
			</div>
		</div>
		<div class="seznamNarocil__button">
			<input type="button" class="button js-narocila-seznam" value="Prikaži">
		</div>
	</div>
	<div class="fakture__response js-narocila-seznam-response"></div>

<?php } ?>