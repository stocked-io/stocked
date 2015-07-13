<?php
namespace Stocked\Stocked\Domain;

use Stocked\Stocked\Domain\Exception\InvalidTransactionTypeException;
use Stocked\Stocked\Domain\Model\Product;
use Stocked\Stocked\Domain\Model\Stock;
use Stocked\Stocked\Domain\Model\Transaction;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The Stocktaker calculates several statistical metrics for a given product:
 * * count()
 * * estimateDeliveryTime()
 * * salesPerSecond()
 * * saleStartDate()
 */
class StockTaker {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 * @inject
	 */
	protected $objectManager;

	/**
	 * @var \Stocked\Stocked\Domain\Repository\StockRepository
	 * @inject
	 */
	protected $stockRepository;

	/**
	 * @var \Stocked\Stocked\Domain\Repository\TransactionRepository
	 * @inject
	 */
	protected $transactionRepository;

	/**
	 * @param Product $product
	 * @return int
	 * @throws InvalidTransactionTypeException
	 */
	public function count(Product $product) {
		$latestStockCount = $this->stockRepository->findLatest($product);
		$count = ($latestStockCount instanceof Stock) ? $latestStockCount->getAmount() : 0;
		$transactions = $this->transactionRepository->findByProduct($product);
		if (is_array($transactions) || $transactions instanceof \Traversable) {
			foreach ($transactions as $transaction) {
				if ($transaction instanceof Transaction) {
					$amount = $transaction->getAmount();
					$type = $transaction->getType();
					if ($type === Transaction::TYPE_PURCHASE) {
						$count += $amount;
					} elseif ($type === Transaction::TYPE_DISPOSITION) {
						$count -= $amount;
					} else {
						throw new InvalidTransactionTypeException('Transaction type ' . $type . ' is not supported', 1436819104);
					}
				}
			}
		}
		return $count;
	}

	/**
	 * @param Product $product
	 * @return int
	 */
	public function estimateDeliveryTime(Product $product) {
		$purchases = $this->transactionRepository->findPurchases($product);
		if ($purchases instanceof QueryResultInterface) {
			$purchases = $purchases->toArray();
		}
		$purchases[] = $this->getFakeTransactionForStockBeforeFirstPurchase($product);
		$deliveryTimeSum = 0;
		foreach ($purchases as $purchase) {
			if ($purchase instanceof Transaction) {
				$deliveryTimeSum += abs($purchase->getCompletionDate()->diff($purchase->getOrderDate())->s);
			}
		}
		return $deliveryTimeSum / count($purchases);
	}

	/**
	 * @param Product $product
	 * @return float
	 */
	public function salesPerSecond(Product $product) {
		$sales = 0;
		foreach($this->transactionRepository->findDispositions($product) as $disposition) {
			if ($disposition instanceof Transaction) {
				$sales += $disposition->getAmount();
			}
		}
		return $sales / abs($this->saleStartDate($product)->diff(new \DateTime('now')));
	}

	/**
	 * @param Product $product
	 * @return \DateTime
	 */
	public function saleStartDate(Product $product) {
		$firstStockCountDate = $this->stockRepository->findFirst($product)->getCountDate();
		$firstPurchaseCompletionDate = $this->transactionRepository->findFirstPurchase($product)->getCompletionDate();
		return $firstStockCountDate < $firstPurchaseCompletionDate ? $firstStockCountDate : $firstPurchaseCompletionDate;
	}

	/**
	 * @param Product $product
	 * @return Transaction
	 */
	protected function getFakeTransactionForStockBeforeFirstPurchase(Product $product) {
		$firstProductPurchase = $this->transactionRepository->findFirstPurchase($product);
		$lastStockCountBeforeFirstPurchase = $this->stockRepository->findLatestBefore($product, $firstProductPurchase->getCompletionDate());
		if (!$lastStockCountBeforeFirstPurchase instanceof Stock) {
			return NULL;
		}
		/** @var Transaction $transaction */
		$transaction = $this->objectManager->get(Transaction::class);
		$transaction->setType(Transaction::TYPE_PURCHASE);
		$transaction->setAmount($lastStockCountBeforeFirstPurchase->getAmount());
		$transaction->setOrderDate(new \DateTime('- ' . $product->getDefaultDeliveryTime() . ' seconds'));
		$transaction->setCompletionDate(new \DateTime('now'));
		return $transaction;
	}

}
