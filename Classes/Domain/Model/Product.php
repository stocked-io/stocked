<?php
namespace Stocked\Stocked\Domain\Model;

use Stocked\Stocked\Domain\DateInterval;

class Product extends AbstractUserOwnedEntity {

	/**
	 * The default delivery time for that product in seconds
	 * @var DateInterval
	 */
	protected $defaultDeliveryTime;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @return DateInterval
	 */
	public function getDefaultDeliveryTime() {
		return $this->defaultDeliveryTime;
	}

	/**
	 * @param DateInterval $defaultDeliveryTime
	 */
	public function setDefaultDeliveryTime($defaultDeliveryTime) {
		$this->defaultDeliveryTime = $defaultDeliveryTime;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

}
