<?php
namespace Stocked\Stocked\Domain\Repository;

use Stocked\Stocked\Domain\Model\Product;
use Stocked\Stocked\Domain\Model\Stock;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class StockRepository extends Repository {

	/**
	 * @param Product $product
	 * @return Stock
	 */
	public function findLatest(Product $product) {
		$query = $this->createQuery();
		return $query->matching($query->equals('product', $product))
			->setOrderings(['countDate' => QueryInterface::ORDER_DESCENDING])
			->setLimit(1)
			->execute()->getFirst();
	}

	/**
	 * @param Product $product
	 * @param int|\DateTime $time
	 * @return Stock
	 */
	public function findLatestBefore(Product $product, $time) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd([
					$query->equals('product', $product),
					$query->lessThan('countDate', $time),
				])
			)
			->setOrderings(['countDate' => QueryInterface::ORDER_DESCENDING])
			->setLimit(1)
			->execute()->getFirst();
	}

	/**
	 * @param Product $product
	 * @return Stock
	 */
	public function findFirst(Product $product) {
		$query = $this->createQuery();
		return $query->matching($query->equals('product', $product))
			->setOrderings(['countDate' => QueryInterface::ORDER_ASCENDING])
			->setLimit(1)
			->execute()->getFirst();
	}

}
