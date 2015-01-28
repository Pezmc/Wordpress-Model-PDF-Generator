<?php

require_once '../GridLayout.php';
require_once '../SplitGrid.php';

include_once '../vendor/autoload.php';

/**
 * SplitGrid test case.
 */
class SplitGridTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var SplitGrid
	 */
	private $vertical;
	
	/**
	 * @var SplitGrid
	 */	
	private $horizontal;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();

		$this->vertical = new SplitGrid(2, 2, 4, 4, $vertical = true);
		$this->horizontal = new SplitGrid(2, 2, 10, 20, $vertical = false);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->vertical = null;
		$this->horizontal = null;
		
		parent::tearDown();
	}
	
	/**
	 * Tests SplitGrid->X()
	 */
	public function testX() {
		// Vertical split grid 2x2 -> 4x4
		$this->assertEquals(0, $this->vertical->X(0));
		$this->assertEquals(2, $this->vertical->X(1));
		$this->assertEquals(3, $this->vertical->X(2));
		$this->assertEquals(2, $this->vertical->X(3));
		$this->assertEquals(3, $this->vertical->X(4));
		
		$this->assertEquals(0, $this->vertical->X(5));
		$this->assertEquals(2, $this->vertical->X(6));
		
		// Horizontal split grid 2x2 -> 10x20
		$this->assertEquals(0, $this->horizontal->X(0));
		
		$this->assertEquals(0, $this->horizontal->X(1));
		$this->assertEquals(5, $this->horizontal->X(2));
		$this->assertEquals(0, $this->horizontal->X(3));
		$this->assertEquals(5, $this->horizontal->X(4));
		
		$this->assertEquals(0, $this->horizontal->X(5));
		
		$this->assertEquals(0, $this->horizontal->X(6));
		$this->assertEquals(5, $this->horizontal->X(7));
	}
	
	/**
	 * Tests SplitGrid->Y()
	 */
	public function testY() {
		// Vertical split grid 2x2 -> 4x4
		$this->assertEquals(0, $this->vertical->Y(0));
		$this->assertEquals(0, $this->vertical->Y(1));
		$this->assertEquals(0, $this->vertical->Y(2));
		$this->assertEquals(2, $this->vertical->Y(3));
		$this->assertEquals(2, $this->vertical->Y(4));
		
		$this->assertEquals(0, $this->vertical->Y(5));
		
		// Horizontal split grid 2x2 -> 10x20
		$this->assertEquals(0, $this->horizontal->Y(0));
		
		$this->assertEquals(10, $this->horizontal->Y(1));
		$this->assertEquals(10, $this->horizontal->Y(2));
		$this->assertEquals(15, $this->horizontal->Y(3));
		$this->assertEquals(15, $this->horizontal->Y(4));
		
		$this->assertEquals(0, $this->horizontal->Y(5));
		
		$this->assertEquals(10, $this->horizontal->Y(6));
		$this->assertEquals(10, $this->horizontal->Y(7));
		$this->assertEquals(15, $this->horizontal->Y(8));
	}
	
	/**
	 * Tests SplitGrid->H()
	 */
	public function testH() {
		// Vertical split grid 2x2 -> 4x4
		$this->assertEquals(4, $this->vertical->H(0));
		$this->assertEquals(2, $this->vertical->H(1));
		$this->assertEquals(2, $this->vertical->H(2));
		$this->assertEquals(2, $this->vertical->H(3));
		$this->assertEquals(2, $this->vertical->H(4));
		
		$this->assertEquals(4, $this->vertical->H(5));
		
		// Horizontal split grid 2x2 -> 10x20
		$this->assertEquals(10, $this->horizontal->H(0));
		$this->assertEquals(5, $this->horizontal->H(1));
		$this->assertEquals(5, $this->horizontal->H(2));
		$this->assertEquals(5, $this->horizontal->H(3));
		$this->assertEquals(5, $this->horizontal->H(4));
		
		$this->assertEquals(10, $this->horizontal->H(5));
	}
	
	/**
	 * Tests SplitGrid->W()
	 */
	public function testW() {
		// Vertical split grid 2x2 -> 4x4
		$this->assertEquals(2, $this->vertical->W(0));
		
		$this->assertEquals(1, $this->vertical->W(1));
		$this->assertEquals(1, $this->vertical->W(2));
		$this->assertEquals(1, $this->vertical->W(3));
		$this->assertEquals(1, $this->vertical->W(4));

		$this->assertEquals(2, $this->vertical->W(5));
		
		// Horizontal split grid 2x2 -> 10x20
		$this->assertEquals(10, $this->horizontal->W(0));
		
		$this->assertEquals(5, $this->horizontal->W(1));
		$this->assertEquals(5, $this->horizontal->W(2));
		$this->assertEquals(5, $this->horizontal->W(3));
		$this->assertEquals(5, $this->horizontal->W(4));
		
		$this->assertEquals(10, $this->horizontal->W(5));
	}
	
	/**
	 * Tests SplitGrid->newPage()
	 */
	public function testNewPage() {
		// 2x2
		$this->assertTrue($this->vertical->newPage(0));
		$this->assertTrue($this->vertical->newPage(5));
		$this->assertTrue($this->vertical->newPage(10));
		
		$this->assertFalse($this->vertical->newPage(1));
		$this->assertFalse($this->vertical->newPage(6));
		$this->assertFalse($this->vertical->newPage(11));
		
		// 2x2
		$this->assertTrue($this->horizontal->newPage(0));
		$this->assertTrue($this->horizontal->newPage(5));
		$this->assertTrue($this->horizontal->newPage(10));
		
		$this->assertFalse($this->horizontal->newPage(1));
		$this->assertFalse($this->horizontal->newPage(6));
		$this->assertFalse($this->horizontal->newPage(11));
	}
}

