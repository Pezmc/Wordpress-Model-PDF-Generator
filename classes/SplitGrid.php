<?php

/**
 * Converts item numbers into X & Y positions using grid on one half and a single item on the other
 * Can be split horitonzally or vertically
 *
 * @author pezcuckow
 * @copyright 2015 Pez Cuckow
 */
class SplitGrid extends GridLayout {
	
	protected $splitWidth;
	protected $splitHeight;
	protected $vertical;
	
	public function __construct($gridX, $gridY, $width, $height, $vertical = true) {
		
		if($vertical) {
			$this->splitWidth = $width / 2;
			$this->splitHeight = $height;
		} else {
			$this->splitWidth = $width;
			$this->splitHeight = $height / 2;
		}
		
		$this->vertical = $vertical;
		
		parent::__construct($gridX, $gridY, $this->splitWidth, $this->splitHeight);
	}
	
	public function X($n) {
		$offset = $this->vertical ? $this->splitWidth : 0;
		
		
		return $this->NewPage($n) ? 0 : (parent::X($this->OffsetN($n)) + $offset);
	}
	
	public function Y($n) {
		$offset = !$this->vertical ? $this->splitHeight : 0;
		$offsetN = floor($n / $this->PerPage()) + 1;
		
		return $this->NewPage($n) ? 0 : (parent::Y($this->OffsetN($n)) + $offset);
	}
	
	public function H($n) {
		return $this->NewPage($n) ? $this->splitHeight : parent::H($n);
	}
	
	public function W($n) {
		return $this->NewPage($n) ? $this->splitWidth : parent::W($n);
	}
	
	public function NewPage($n) {
		return 0 == $n % $this->PerPage();
	}
	
	public function PerPage() {
		return ($this->rowsInY * $this->columnsInX) + 1;
	}
	
	private function OffsetN($n) {
		return $n - (floor($n / $this->PerPage()) + 1);
	}
}