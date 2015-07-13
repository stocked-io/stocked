<?php
namespace Stocked\Stocked\Domain\Model;

class Product extends AbstractUserOwnedEntity {

	/**
	 * The default delivery time for that product in seconds
	 * @var int
	 */
	protected $defaultDeliveryTime;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @return int
	 */
	public function getDefaultDeliveryTime() {
		return $this->defaultDeliveryTime;
	}

	/**
	 * @param int $defaultDeliveryTime
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
