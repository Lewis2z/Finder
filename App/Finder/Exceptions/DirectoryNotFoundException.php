<?php

namespace Finder\Exceptions;

/**
 * 
 */
class DirectoryNotFoundException extends \Exception
{
	public $message;
	function __construct(string $message) {
		$this->message = $message;
	}
}