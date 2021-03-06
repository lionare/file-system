<?php

namespace FileSystem;


use Agreed\Technical\Configuration;

use FileSystem\Drivers\LocalFileSystem;
use FileSystem\Disk;
use FileSystem\Disks\Manager as Disks;
use FileSystem\Facades\DirectoryFinder;
use FileSystem\Facades\FileFinder;
use FileSystem\FileTree;

use Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{
	private $drivers = array (

		'local file system'	=> LocalFileSystem::class
	);

	public function register ( )
	{
		$this->bindDisks ( );
		$this->bindTree ( );
		$this->bindFacades ( );
	}

	private function bindDisks ( )
	{
		$this->application->share ( Disk::class, function ( Configuration $configuration )
		{
			$configuredDisks = $configuration->get ( 'file system disks' );
			$disks = new Disks;

			foreach ( $configuredDisks as $name => $disk )
				$disks->add ( new Disk ( $name, $disk [ 'location' ], new $this->drivers [ $disk [ 'driver' ] ] ) );

			return $disks;
		} );
	}

	private function bindTree ( )
	{
		$this->application->share ( FileTree::class, function ( Configuration $configuration )
		{
			$objects = $configuration->get ( 'file system tree' );
			$fileTree = new FileTree;

			foreach ( $objects as $object )
				$fileTree->add ( $object );

			return $fileTree;
		} );
	}

	private function bindFacades ( )
	{
		$this->application->share ( DirectoryFinder::class, function ( FileTree $fileTree )
		{
			return new DirectoryFinder ( $fileTree->objects );
		} );

		$this->application->share ( FileFinder::class, function ( FileTree $fileTree )
		{
			return new FileFinder ( $fileTree->objects );
		} );
	}
}