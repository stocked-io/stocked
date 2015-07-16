<?php
namespace Stocked\Stocked\Domain;

use TYPO3\CMS\Core\Type\TypeInterface;

class DateInterval extends \DateInterval implements TypeInterface {

	/**
	 * @param int $value
	 */
	public function __construct($value) {
		parent::__construct($value . 's');
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->s;
	}
}
