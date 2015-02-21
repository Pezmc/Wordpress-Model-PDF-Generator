<?php

/**
 * Model PDF generator.
 * Takes an array of images and draws them on a page PDF with a footer, using a GridLayout for positioning.
 * 
 * @author pezcuckow
 * @copyright 2015 Pez Cuckow
 */
abstract class ModelPDF {
	
	// Default grid types
	const SplitGrid = 'SplitGrid';
	const SideBySide = 'SideBySide';
	const Grid = 'Grid';
	
	protected $pdf;
	protected $imagePaths = array();
	protected $imagesInX = 2;
	protected $imagesInY = 2;
	protected $footerHeight = 25;
	protected $footerImage;
	protected $footerAddress;
	
	protected $modelName;
	protected $modelDetails;
	
	public function __construct($splitGrid = false) {
		$this->pdf = new TCPDF($orientation='L', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false);
		$this->pdf->setPageOrientation($orientation='L', $autopagebreak = false, $bottommargin = 10);
		
		$this->pdf->SetCellPadding(0);
		
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);
		
		$this->pdf->SetMargins($left=15, $top=10, $right=-1, $keepmargins=false);
	}
	
	protected function getGrid($type) {
		return new $type($this->imagesInX, $this->imagesInY, $this->pageWidthLessMargins(), $this->pageHeightLessMargins());
	}
	
	public function addImage($imagePath) {
		$this->imagePaths[] = $imagePath;
	}
	
	public function addImages($imagePaths) {
		foreach($imagePaths as $imagePath) {
			$this->addImage($imagePath);
		}
	}
	
	private function pageWidthLessMargins() {
		$margins = $this->pdf->getMargins();
		
		return $this->pdf->getPageWidth() - $margins['left'] - $margins['right'];
	}
	
	private function pageHeightLessMargins() {
		$margins = $this->pdf->getMargins();
		
		return $this->pdf->getPageHeight() - $margins['top'] - $margins['bottom'] - $this->footerHeight;;
	}
	
	public function output($filename = 'example.pdf', $destination = 'I') {
		
		$this->drawImages();
		$this->drawFooter();
		
		return $this->pdf->Output($filename, $destination);
	}
	
	private function drawImages() {
		if(!$this->grid) {
				$this->grid = $this->getGrid('SplitGrid');
		}
			
		foreach($this->imagePaths as $key => $imagePath) {
			$this->drawImage($key, $imagePath);
		}
	}
	
	private function addPage() {
		// Draw footer
		if($this->pdf->PageNo() >= 1) {
			$this->drawFooter();
		}
		
		// New page
		$this->pdf->AddPage();
	}
	
	private function drawFooter() {
		$bottomMargin = $this->pdf->getMargins()['bottom'];
		
		$leftMargin = $this->pdf->getMargins()['left'];
		
		$pageHeight = $this->pdf->getPageHeight();
		
		$footerHeight = $this->footerHeight;
		
		$pageWidth = $this->pdf->getPageWidth();
		$rightMargin = $this->pdf->getMargins()['right'];
		
		$x = $leftMargin;
		$y = $pageHeight - $bottomMargin - $footerHeight + 2;
		$h = $footerHeight - 3;
		$this->pdf->Image($this->footerImage, $x, $y, $w=0, $h, $type='', $link='', $align='', $resize=true, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array());
		
		$this->pdf->SetXY($leftMargin - 0.75, $pageHeight - $bottomMargin);
		$this->pdf->Write($h=0, $this->footerAddress);
		
		$this->pdf->SetXY($pageWidth / 2, $pageHeight - $bottomMargin - $footerHeight / 3 * 2);
		$this->pdf->writeHTML("<b>" . $this->modelName . "</b>", $ln=true, $fill=false, $reseth=false, $cell=false, $align='R');
		$this->pdf->writeHTML($this->modelDetails, $ln=true, $fill=false, $reseth=false, $cell=false, $align='R');
	}
	
	private function drawImage($n, $imagePath) {
		
		$perPage = $this->imagesInX * $this->imagesInY;
		
		$grid = &$this->grid;

		$this->pdf->SetLineWidth(0.25);
		$this->pdf->SetFillColor(255, 0, 0);
		$this->pdf->SetDrawColor(127, 0, 0);

		$margins = $this->pdf->getMargins();
		
		if($grid->NewPage($n)) {
			$this->addPage();
		}

		$x = $margins['left'] + $grid->X($n);
		$y = $margins['top'] + $grid->Y($n);
		//$this->pdf->Rect($x, $y, $grid->W($n), $grid->H($n), 'DF');
		
		$this->pdf->Image($imagePath, $x, $y, $grid->W($n), $grid->H($n), $type='', $link='', $align='', $resize=true, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox='CM', $hidden=false, $fitonpage=false, $alt=false, $altimgs=array());
	}
}

?>