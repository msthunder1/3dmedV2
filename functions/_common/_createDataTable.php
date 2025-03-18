<?php

/*
** A common file used by multiple other scripts
** Create a data table
** $itemData['link'] is reserved generally for links to the post
*/

function createDataTable($items_data, $id='', $class='', $export=false) {

	// Ready the headers for the table
	$items_header = (reset($items_data));
	unset($items_header['link']);
	$items_header = array_keys($items_header);

	// Get the id of the CPT for the fields
	$items_id = array_keys($items_data);

	if (!empty($items_data)) { ?>

	<div class="dataTable">
		<table id="<?php echo $id ?>" class="dataTable__table js-dataTable__table">
			<thead class="dataTable__head">
				<tr class="dataTable__headerRow">
					<?php createDataTable_Header($items_header, $items_id[0]) ?>
				</tr>
			</thead>
			<tbody class="dataTable__body">
				<?php createDataTable_Row($items_data) ?>
			</tbody>
		</table>

		<?php if($export) { ?>
			<div class="dataTable__export js-dataTable__export">
				Export
			</div>
		<?php } ?>
	</div>

	<?php }

}

function createDataTable_Header($items_header, $items_id){

	foreach ($items_header as $fieldKey) {

		if($fieldKey === 'title') {
			$field["label"] = "Naslov";
		} else if($fieldKey === 'timestamp') {
			$field["label"] = "Datum urejanja";
		} else if($fieldKey === 'Ime') {
			$field["label"] = "Ime";
		} else if($fieldKey === 'priimek') {
			$field["label"] = "Priimek";
		} else if($fieldKey === 'podjetje') {
			$field["label"] = "Podjetje";
		} else {
			$field = get_field_object($fieldKey, $items_id);
		} ?>

		<th class="dataTable__header"><?php echo $field["label"]; ?></th>
		
	<?php }
}

function createDataTable_Row($items_data){

	foreach ($items_data as $item_data) {
		$item_link = $item_data['link'];
		unset($item_data['link']); ?>
		<tr class="dataTable__row" onclick="window.location='<?php echo $item_link ?>';">
			<?php foreach ($item_data as $data) {
				if($data === 'link') continue;
				?><td class="dataTable__cell"><?php echo $data; ?></td>
			<?php } ?>
		</tr>
	<?php }
}

?>