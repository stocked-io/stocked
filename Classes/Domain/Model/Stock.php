<?php
namespace Stocked\Stocked\Domain\Model;

class Stock extends AbstractUserOwnedEntity {

	/**
	 * @var int
	 */
	protected $amount;

	/**
	 * @var \DateTime
	 */
	protected $countDate;

	/**
	 * @var \Stocked\Stocked\Domain\Model\Product
	 */
	protected $product;

	/**
	 * @return int
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @param int $amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * @return \DateTime
	 */
	public function getCountDate() {
		return $this->countDate;
	}

	/**
	 * @param \DateTime $countDate
	 */
	public function setCountDate($countDate) {
		$this->countDate = $countDate;
	}

	/**
	 * @return Product
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * @param Product $product
	 */
	public function setProduct($product) {
		$this->product = $product;
	}

}
