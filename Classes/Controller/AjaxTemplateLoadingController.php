<?php
namespace Stocked\Stocked\Controller;

use AppZap\ThemeFoundationApps\RoutesFileGenerator;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class AjaxTemplateLoadingController {

	/**
	 * @var \TYPO3\CMS\Fluid\View\StandaloneView
	 * @inject
	 */
	protected $view;

	/**
	 * @param string $templateName
	 * @param string $appExtensionKey
	 * @return string
	 */
	public function loadTemplateAction($templateName, $appExtensionKey) {
		$appTemplatesPath = sprintf(
			RoutesFileGenerator::APP_TEMPLATES_FOLDER,
			ExtensionManagementUtility::extPath($appExtensionKey)
		);
		$templateFilePath = $appTemplatesPath . '/' . $templateName;
		if (!file_exists($templateFilePath)) {
			return '';
		} else {
			$this->view->setTemplatePathAndFilename($templateFilePath);
			return $this->view->render();
		}
	}

}
