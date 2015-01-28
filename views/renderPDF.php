<?php

function cmInFeetAndInches($cm) {
		$inches = ceil($cm / 2.54);
		$feet = floor($inches / 12);

		return $feet."'".($inches % 12).'"';
}


function printError($message) {
		get_header();
		?>
		<div class="container">
			<h1><?php the_title();?></h1>
			<h3><?php echo $message; ?></h3>
		</div>
	<?php
	get_footer();
}

$images = array();
$modelName = "";
$modelDetails = array();

// Collect information about our model
$query = new WP_Query(array(
		'post_type' => 'models',
		'models' => $wp_query->query_vars['model_id'],
		'name' => $wp_query->query_vars['model_id']
));
if($query->have_posts()) {
	while ($query->have_posts()) {
		$query->the_post();
		$modelName = get_the_title();
	
		while(have_rows('model_image')) {
			the_row(); 
			$image = get_sub_field('image');
			
			$images[] = get_template_directory_uri() . "/thumb.php?src=$image&h=1480&w=1200"; //adjust the aspect ratio

		}
		
		if(get_field('height')) {
				$modelDetails['Height'] = cmInFeetAndInches(get_field('height')) . '/' . ceil(get_field('height')) . 'cm';
		}
		$modelDetails['Waist'] = get_field('waist');
		$modelDetails['Hips'] = get_field('hips');
		$modelDetails['Chest'] = get_field('chest');
		$modelDetails['Inseam'] = get_field('inseam');
		$modelDetails['Shoes'] = get_field('shoes');
		$modelDetails['Dress size'] = get_field('dress');
		$modelDetails['Suit size'] = get_field('suit');
	}
}

// Filter blanks + reformat
$modelDetails = array_filter($modelDetails);
array_walk($modelDetails, function(&$value, $key) {
		$value = $key . ' ' . $value;
});

// Ensure we have something to draw
if(empty($images)) {
	printError('Unable to find a model with that name, please try again.');
} else {
	$reply = ModelPDFPlugin::includeRequirements();
	if(is_wp_error($reply)) {
			return printError($reply->get_error_message());
	}
	
	// What format PDF
	switch($wp_query->query_vars['pdf_style']) {
			case 'side-by-side':
					$pdfStyle = MaverickPDF::SideBySide;
					break;
			case 'grid':
					$pdfStyle = MaverickPDF::Grid;
					break;
			default:
					$pdfStyle = MaverickPDF::SplitGrid;
	}
	
	// Render away
	$pdf = new MaverickPDF($modelName, implode(' | ', $modelDetails), $pdfStyle);
	$pdf->addImages($images);
	$pdf->output(__DIR__ . '/output.pdf', 'I');
}