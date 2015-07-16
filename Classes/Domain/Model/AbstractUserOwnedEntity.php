<?php
namespace Stocked\Stocked\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class AbstractUserOwnedEntity extends AbstractEntity {

	/**
	 * @var FrontendUserGroup;
	 */
	protected $company;

	/**
	 * @var FrontendUser
	 */
	protected $user;

	/**
	 * @return FrontendUserGroup
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * @param FrontendUserGroup $company
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

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
