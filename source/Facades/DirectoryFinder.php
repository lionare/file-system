<?php

namespace FileSystem\Facades;

use Exception;
use FileSystem\Directory;

class DirectoryFinder
{
	private $objects = array ( );

	public function __construct ( array $objects = array ( ) )
	{
		$this->objects = $objects;
	}

	public function at ( $path )
	{
		foreach ( $this->objects as $object )
			if ( $object instanceOf Directory and $object->path === $path )
				return $object;

		throw new Exception ( "Could not find a directory at path: $path." );
	}
}