<?php
namespace Stocked\Stocked\Domain\Repository;

use Stocked\Stocked\Domain\Model\Product;
use Stocked\Stocked\Domain\Model\Transaction;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class TransactionRepository extends AbstractAuthorizationRequiringRepository {

	/**
	 * @param Product $product
	 * @return array|QueryResultInterface
	 */
	public function findByProduct(Product $product) {
		$query = $this->createQuery();
		return $query->matching($query->equals('product', $product))->execute();
	}

	/**
	 * @param Product $product
	 * @return Transaction
	 */
	public function findFirstPurchase(Product $product) {
		$query = $this->createQuery();
		return $query
			->matching($query->equals('product', $product))
			->setOrderings(['completionDate' => Query::ORDER_ASCENDING])
			->setLimit(1)->execute()->getFirst();
	}

	/**
	 * @param Product $product
	 * @return array|QueryResultInterface
	 */
	public function findDispositions(Product $product) {
		return $this->findByType($product, Transaction::TYPE_DISPOSITION);
	}

	/**
	 * @param Product $product
	 * @return array|QueryResultInterface
	 */
	public function findPurchases(Product $product) {
		return $this->findByType($product, Transaction::TYPE_PURCHASE);
	}

	/**
	 * @param Product $product
	 * @param string $type
	 * @return array|QueryResultInterface
	 */
	protected function findByType(Product $product, $type) {
		$query = $this->createQuery();
		return $query->matching($query->logicalAnd([
			$query->equals('product', $product),
			$query->equals('type', $type),
		]))->execute();
	}

}
