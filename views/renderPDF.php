<?php

/**
 * Customise this file to get an array of images and pass it to the PDF generator
 * The code here is just an example and shows grabbing model information from a wordpress post
 */
 
// Handy functions
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

// Information to pass to the PDF generator
$images = array();
$modelName = "";
$modelDetails = array();

// Collect information about our model by searching for a post with this ID
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
			
			$images[] = plugins_url('vendor/timthumb.php?src=$image&h=1480&w=1200', MPDF_BASE) // use timthumb to adjust the aspect ratio
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
					$pdfStyle = MyModelPDF::SideBySide;
					break;
			case 'grid':
					$pdfStyle = MyModelPDF::Grid;
					break;
			default:
					$pdfStyle = MyModelPDF::SplitGrid;
	}
	
	// Render away - this is where you set your custom template generator
	$pdf = new MyModelPDF($modelName, implode(' | ', $modelDetails), $pdfStyle);
	$pdf->addImages($images);
	$pdf->output(__DIR__ . '/output.pdf', 'I');
}