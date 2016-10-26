<?php

namespace FileSystem\Facades;

use Exception;
use FileSystem\File;

class FileFinder
{
	private $objects = array ( );

	public function __construct ( array $objects = array ( ) )
	{
		$this->objects = $objects;
	}

	public function at ( $path )
	{
		foreach ( $this->objects as $object )
			if ( $object instanceOf File and $object->path === $path )
				return $object;

		throw new Exception ( "Could not find a file at path: $path." );
	}
}