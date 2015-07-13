<?php
namespace Stocked\Stocked\Tests\Unit\Domain;

use Stocked\Stocked\Domain\Model\Product;
use Stocked\Stocked\Domain\Model\Stock;
use Stocked\Stocked\Domain\Model\Transaction;
use Stocked\Stocked\Domain\Repository\StockRepository;
use Stocked\Stocked\Domain\Repository\TransactionRepository;
use Stocked\Stocked\Domain\StockTaker;
use TYPO3\CMS\Core\Tests\UnitTestCase;

class StockTakerTest extends UnitTestCase {

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|StockRepository
	 */
	protected $stockRepositoryMock;

	/**
	 * @var \Stocked\Stocked\Domain\StockTaker
	 */
	protected $stockTaker;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|TransactionRepository
	 */
	protected $transactionRepositoryMock;

	/**
	 *
	 */
	public function setUp() {
		$this->stockRepositoryMock = $this->getMockBuilder(StockRepository::class)
			->disableOriginalConstructor()
			->getMock();
		$this->transactionRepositoryMock = $this->getMockBuilder(TransactionRepository::class)
			->disableOriginalConstructor()
			->getMock();
		$this->stockTaker = new StockTaker;
		$this->inject($this->stockTaker, 'stockRepository', $this->stockRepositoryMock);
		$this->inject($this->stockTaker, 'transactionRepository', $this->transactionRepositoryMock);
	}

	/**
	 * @test
	 */
	public function countByLastStockCount() {
		/** @var \PHPUnit_Framework_MockObject_MockObject|Product $productMock */
		$productMock = $this->getMock(Product::class);
		/** @var \PHPUnit_Framework_MockObject_MockObject|Stock $stockMock */
		$stockMock = $this->getMock(Stock::class);
		$stockMock->method('getAmount')->willReturn(42);
		$this->stockRepositoryMock->method('findLatest')->with($this->equalTo($productMock))->willReturn($stockMock);
		$this->assertEquals(42, $this->stockTaker->count($productMock));
	}

	/**
	 * @test
	 */
	public function countByNoStockCountAndNoTransactions() {
		/** @var \PHPUnit_Framework_MockObject_MockObject|Product $productMock */
		$productMock = $this->getMock(Product::class);
		$this->assertEquals(0, $this->stockTaker->count($productMock));
	}

	/**
	 * @test
	 */
	public function countByTransactions() {
		/** @var \PHPUnit_Framework_MockObject_MockObject|Product $productMock */
		$productMock = $this->getMock(Product::class);
		$transactions = [
			$this->getTransactionMock(Transaction::TYPE_PURCHASE, 10),
			$this->getTransactionMock(Transaction::TYPE_DISPOSITION, 8),
			$this->getTransactionMock(Transaction::TYPE_PURCHASE, 10),
		];
		$this->transactionRepositoryMock->method('findByProduct')->with($this->equalTo($productMock))->willReturn($transactions);
		$this->assertEquals(12, $this->stockTaker->count($productMock));
	}

	/**
	 * @test
	 */
	public function countByLastStockCountAndTransactions() {
		/** @var \PHPUnit_Framework_MockObject_MockObject|Product $productMock */
		$productMock = $this->getMock(Product::class);
		/** @var \PHPUnit_Framework_MockObject_MockObject|Stock $stockMock */
		$stockMock = $this->getMock(Stock::class);
		$stockMock->method('getAmount')->willReturn(42);
		$this->stockRepositoryMock->method('findLatest')->with($this->equalTo($productMock))->willReturn($stockMock);
		$transactions = [
			$this->getTransactionMock(Transaction::TYPE_PURCHASE, 10),
			$this->getTransactionMock(Transaction::TYPE_DISPOSITION, 8),
			$this->getTransactionMock(Transaction::TYPE_PURCHASE, 10),
		];
		$this->transactionRepositoryMock->method('findByProduct')->with($this->equalTo($productMock))->willReturn($transactions);
		$this->assertEquals(54, $this->stockTaker->count($productMock));
	}

	/**
	 * @test
	 * @expectedException \Stocked\Stocked\Domain\Exception\InvalidTransactionTypeException
	 * @expectedExceptionCode 1436819104
	 */
	public function countUnsupportedTransaction() {
		/** @var \PHPUnit_Framework_MockObject_MockObject|Product $productMock */
		$productMock = $this->getMock(Product::class);
		$transactions = [
			$this->getTransactionMock('unsupported_type', 10),
		];
		$this->transactionRepositoryMock
			->method('findByProduct')
			->with($this->equalTo($productMock))
			->willReturn($transactions);
		$this->stockTaker->count($productMock);
	}

	/**
	 * @param string $type
	 * @param int $amount
	 * @return \PHPUnit_Framework_MockObject_MockObject|Transaction
	 */
	protected function getTransactionMock($type, $amount) {
		/** @var \PHPUnit_Framework_MockObject_MockObject|Transaction $transaction */
		$transaction = $this->getMock(Transaction::class);
		$transaction
			->method('getAmount')
			->willReturn($amount);
		$transaction
			->method('getType')
			->willReturn($type);
		return $transaction;
	}

}
