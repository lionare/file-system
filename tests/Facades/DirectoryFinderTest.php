<?php

namespace FileSystem\Facades\Tests;

use Mockery;
use Packaged\FileSystem\Facades\DirectoryFinder;
use Testing\TestCase;

class DirectoryFinderTest extends TestCase
{
	private $directory, $application = null;
	public function setUp ( )
	{
		$objects = array (
			$root = Mockery::mock ( 'FileSystem\\Root' )->shouldIgnoreMissing ( ),
			$this->application = Mockery::mock ( 'FileSystem\\Directory', array ( 'application', $root ) )->shouldIgnoreMissing ( ),
		);

		$this->directory = new DirectoryFinder ( $objects );
	}

	/**
	 * @test
	 * @expectedException Exception
	 */
	public function at_withPathWhenNoDirectoryIsAtThatPath_throwsException ( )
	{		
		$this->directory->at ( 'non/existent/path' );
	}

	/**
	 * @test
	 */
	public function at_withPathWhenDirectoryIsAtThatPath_returnsDirectory ( )
	{
		assertThat ( $this->directory->at ( '/application' ), is ( identicalTo ( $this->application ) ) );
	}
}