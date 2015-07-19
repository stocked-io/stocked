<?php
namespace Stocked\Stocked\Tests\Unit\Domain\Model\Stocktaker;

use Stocked\Stocked\Domain\Model\Product;
use Stocked\Stocked\Domain\Model\Stock;
use Stocked\Stocked\Domain\Model\Transaction;

class StocktakerCountTest extends AbstractStocktakerTest {

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

}
