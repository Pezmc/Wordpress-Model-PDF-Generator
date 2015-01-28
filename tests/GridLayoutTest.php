<?php
require_once '../GridLayout.php';
include_once '../vendor/autoload.php';

/**
 * GridLayout test case.
 */
class GridLayoutTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var GridLayout
	 */
	private $square;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$this->square = new GridLayout(5, 5, 5, 5);
		
		$this->rect = new GridLayout(4, 4, 100, 200);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->square = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests GridLayout->X()
	 */
	public function testX() {
		// 5x5 grid -> 5x5 grid
		$this->assertEquals(0, $this->square->X(0));
		$this->assertEquals(1, $this->square->X(1));
		$this->assertEquals(4, $this->square->X(4));
		$this->assertEquals(0, $this->square->X(5));
		$this->assertEquals(1, $this->square->X(6));
		
		// 4x4 grid -> 100x200 grid
		$this->assertEquals(0, $this->rect->X(0));
		$this->assertEquals(25, $this->rect->X(1));
		$this->assertEquals(50, $this->rect->X(2));
		$this->assertEquals(75, $this->rect->X(3));
		$this->assertEquals(0, $this->rect->X(4));
		$this->assertEquals(25, $this->rect->X(5));
	}
	
	/**
	 * Tests GridLayout->Y()
	 */
	public function testY() {
		$this->assertEquals(0, $this->square->Y(0));
		$this->assertEquals(0, $this->square->Y(1));
		$this->assertEquals(0, $this->square->Y(4));
		$this->assertEquals(1, $this->square->Y(5));
		$this->assertEquals(1, $this->square->Y(6));
		
		// 4x4 grid -> 100x200 grid
		$this->assertEquals(0, $this->rect->Y(0));
		$this->assertEquals(0, $this->rect->Y(1));
		$this->assertEquals(0, $this->rect->Y(2));
		$this->assertEquals(0, $this->rect->Y(3));
		$this->assertEquals(50, $this->rect->Y(4));
		$this->assertEquals(50, $this->rect->Y(7));
		$this->assertEquals(100, $this->rect->Y(8));
		$this->assertEquals(150, $this->rect->Y(12));
		$this->assertEquals(0, $this->rect->Y(16));
	}
	
	/**
	 * Tests GridLayout->H()
	 */
	public function testH() {
		$this->assertEquals(1, $this->square->H(1));
		$this->assertEquals(1, $this->square->H(2));
		
		$this->assertEquals(50, $this->rect->H(1));
	}
	
	/**
	 * Tests GridLayout->W()
	 */
	public function testW() {
		$this->assertEquals(1, $this->square->W(1));
		$this->assertEquals(1, $this->square->W(2));
		
		$this->assertEquals(25, $this->rect->W(1));
	}
}

