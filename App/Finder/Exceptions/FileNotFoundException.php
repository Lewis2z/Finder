<?php

namespace Finder\Exceptions;

/**
 * 
 */
class FileNotFoundException extends \Exception
{
	public $message;
	function __construct(string $message) {
		$this->message = $message;
	}
}