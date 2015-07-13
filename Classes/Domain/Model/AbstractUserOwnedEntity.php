<?php
namespace Stocked\Stocked\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class AbstractUserOwnedEntity extends AbstractEntity {

	/**
	 * @var FrontendUser
	 */
	protected $user;

	/**
	 * @return FrontendUser
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param FrontendUser $user
	 */
	public function setUser($user) {
		$this->user = $user;
	}

}
