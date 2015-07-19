<?php
namespace Stocked\Stocked\Tests\Unit\Domain\Model\Stocktaker;

use Stocked\Stocked\Domain\Model\Transaction;
use Stocked\Stocked\Domain\Repository\StockRepository;
use Stocked\Stocked\Domain\Repository\TransactionRepository;
use Stocked\Stocked\Domain\StockTaker;
use TYPO3\CMS\Core\Tests\UnitTestCase;

abstract class AbstractStocktakerTest extends UnitTestCase {

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
