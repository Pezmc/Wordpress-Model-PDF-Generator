<?php

/**
 * An extension to the PDF generating class that sets defaults for an example "my models
 * 
 * @author pezcuckow
 * @copyright 2015 Pez Cuckow
 */
class MyModelPDF extends ModelPDF {

	const SplitGrid = 'SplitGrid';
	const SideBySide = 'SideBySide';
	const Grid = 'Grid';

	public function __construct($modelName, $modelDetails, $pdfStyle) {
		parent::__construct(false);
		$this->pdf->SetCreator('Model PDF Generator');
		$this->pdf->SetAuthor('My Models');
		$this->pdf->SetTitle($modelName . ' - My Models');
		$this->pdf->SetSubject('My Models');
		$this->pdf->SetKeywords('My Models');
		
		$this->footerImage = dirname(__FILE__) . '/../images/mymodels.png';
		$this->footerAddress = "123 MODEL STREET, London, N1 123 	 Tel: 020 7946 0103";
		
		$this->modelName = $modelName;
		$this->modelDetails = $modelDetails;
		
		if($pdfStyle == self::SplitGrid) {
				$this->splitGrid(2, 2);
		} elseif($pdfStyle == self::SideBySide) {
				$this->grid(2, 1);
		} elseif($pdfStyle == self::Grid) {
				$this->grid(4, 2);
		} else {
				throw new InvalidArgumentException('Unknown PDF style');
		}
	}
	
	public function splitGrid($x, $y) {
			$this->imagesInX = $x;
			$this->imagesInY = $y;
			
			$this->grid = $this->getGrid('SplitGrid');
	}
	
	public function grid($x, $y) {
			$this->imagesInX = $x;
			$this->imagesInY = $y;
			
			$this->grid = $this->getGrid('GridLayout');
	}
}

?>