<?php

/**
 * Converts item numbers into X & Y positions using a grid pattern
 * 
 * @author pezcuckow
 * @copyright 2015 Pez Cuckow
 */
class GridLayout {
	
	protected $columnsInX;
	protected $rowsInY; 
	
	protected $width;
	protected $height;
	
	public function __construct($gridX, $gridY, $width, $height) {
		$this->columnsInX = $gridX;
		$this->rowsInY = $gridY;
	
		$this->width = $width;
		$this->height = $height;
	}
	
	public function X($n) {
		$column = $n % $this->columnsInX;
		
		return $column * $this->StepX();
	}
	
	public function Y($n) {
		$row = floor($n / $this->columnsInX) % $this->rowsInY;
		
		return $this->StepY() * $row;
	}
	
	public function H($n) {
		return $this->StepY();
	}
	
	public function W($n) {
		return $this->StepX();
	}
	
	public function NewPage($n) {
		return 0 == $n % $this->PerPage();
	}

	private function StepX() {
		return $this->width / $this->columnsInX;
	}
	
	private function StepY() {
		return $this->height / $this->rowsInY;
	}
	
	public function PerPage() {
		return ($this->rowsInY * $this->columnsInX) + 1;
	}
}

?>