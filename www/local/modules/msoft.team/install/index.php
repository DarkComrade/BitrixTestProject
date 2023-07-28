<?

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Type\DateTime;

class msoft_team extends \CModule
{
	var $MODULE_ID = "msoft.team";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct()
	{
		$arModuleVersion = array();

		include(__DIR__ . '/version.php');

		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->PARTNER_NAME = 'MediaSoft';
		$this->PARTNER_URI = 'http://php73.ru';


		$this->MODULE_NAME = 'Вспомогательный модуль';
		$this->MODULE_DESCRIPTION = '';
	}

	function DoInstall()
	{
		ModuleManager::registerModule($this->MODULE_ID);
		Loader::includeModule($this->MODULE_ID);

	}


	function DoUninstall()
	{
		Loader::includeModule($this->MODULE_ID);
		ModuleManager::unRegisterModule($this->MODULE_ID);

		return true;
	}

}
