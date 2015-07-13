<?php
namespace Stocked\Stocked\Domain\Model;

class Transaction extends AbstractUserOwnedEntity {

	const TYPE_PURCHASE = 'purchase';
	const TYPE_DISPOSITION = 'disposition';

	/**
	 * @var int
	 */
	protected $amount;

	/**
	 * @var \DateTime
	 */
	protected $completionDate;

	/**
	 * @var \DateTime
	 */
	protected $orderDate;

	/**
	 * @var float
	 */
	protected $price;

	/**
	 * @var \Stocked\Stocked\Domain\Model\Product
	 */
	protected $product;

	/**
	 * @var string
	 */
	protected $tradePartner;

	/**
	 * @var string
	 */
	protected $type;

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
	public function getCompletionDate() {
		return $this->completionDate;
	}

	/**
	 * @param \DateTime $completionDate
	 */
	public function setCompletionDate($completionDate) {
		$this->completionDate = $completionDate;
	}

	/**
	 * @return \DateTime
	 */
	public function getOrderDate() {
		return $this->orderDate;
	}

	/**
	 * @param \DateTime $orderDate
	 */
	public function setOrderDate($orderDate) {
		$this->orderDate = $orderDate;
	}

	/**
	 * @return float
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice($price) {
		$this->price = $price;
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

	/**
	 * @return string
	 */
	public function getTradePartner() {
		return $this->tradePartner;
	}

	/**
	 * @param string $tradePartner
	 */
	public function setTradePartner($tradePartner) {
		$this->tradePartner = $tradePartner;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

}
