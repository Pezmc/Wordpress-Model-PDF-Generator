<?php

/**
 * An extension to the PDF generating class that sets defaults for use on maverickmodels.co.uk
 * 
 * @author pezcuckow
 * @copyright 2015 Pez Cuckow
 */
class MaverickPDF extends ModelPDF {

	const SplitGrid = 'SplitGrid';
	const SideBySide = 'SideBySide';
	const Grid = 'Grid';

	public function __construct($modelName, $modelDetails, $pdfStyle) {
		parent::__construct(false);
		$this->pdf->SetCreator('Model PDF');
		$this->pdf->SetAuthor('Maverick Models');
		$this->pdf->SetTitle($modelName . ' - Maverick Model');
		$this->pdf->SetSubject('Maverick Models');
		$this->pdf->SetKeywords('Maverick Models');
		
		$this->footerImage = dirname(__FILE__) . '/../images/maverick.png';
		$this->footerAddress = "12-14 LEVER STREET, MANCHESTER, M1 1LN 	 Tel: 0161 236 2874";
		
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