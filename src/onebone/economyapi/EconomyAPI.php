<?php
declare(strict_types=1);

namespace onebone\economyapi;

use net\mydeacy\myeconomy\api\MyEconomyAPI;
use net\mydeacy\myeconomy\application\ResultCode;
use net\mydeacy\myeconomy\MyEconomyPlugin;
use onebone\economyapi\compat\EconomyEventBridge;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use RuntimeException;

/**
 * Compatibility adapter for EconomyAPI plugins.
 *
 * This class delegates all operations to MyEconomy.
 */
final class EconomyAPI extends PluginBase {

	public const API_VERSION = 3;
	public const PACKAGE_VERSION = "5.9";
	public const RET_NO_ACCOUNT = ResultCode::RET_NO_ACCOUNT;
	public const RET_CANCELLED = ResultCode::RET_CANCELLED;
	public const RET_NOT_FOUND = ResultCode::RET_NOT_FOUND;
	public const RET_INVALID = ResultCode::RET_INVALID;
	public const RET_SUCCESS = ResultCode::RET_SUCCESS;

	private static ?self $instance = null;

	private ?MyEconomyAPI $api = null;

	/**
	 * Returns the adapter instance.
	 *
	 * @throws RuntimeException if the plugin is not loaded.
	 */
	public static function getInstance() :self {
		if (self::$instance === null) {
			throw new RuntimeException("EconomyAPI is not loaded.");
		}
		return self::$instance;
	}

	/**
	 * Handles load.
	 */
	protected function onLoad() :void {
		self::$instance = $this;
	}

	/**
	 * Handles enable.
	 */
	protected function onEnable() :void {
		$plugin = $this->getServer()->getPluginManager()->getPlugin("MyEconomy");
		if (!$plugin instanceof MyEconomyPlugin || !$plugin->isEnabled()) {
			$this->getLogger()->error("MyEconomy is not enabled.");
			$this->getServer()->getPluginManager()->disablePlugin($this);
			return;
		}
		$this->api = $plugin->getApi();
		$this->getServer()->getPluginManager()->registerEvents(new EconomyEventBridge($this), $this);
	}

	/**
	 * Handles disable.
	 */
	protected function onDisable() :void {
		self::$instance = null;
	}

	/**
	 * Returns command metadata for a language.
	 *
	 * @param string $command Command name.
	 * @param string|bool $lang Language code, or false to use default.
	 *
	 * @return array<string, string>
	 */
	public function getCommandMessage(string $command, string|bool $lang = false) :array {
		$resolvedLanguage = $lang === false ? $this->api->getDefaultLang() : (string)$lang;
		return $this->api->getCommandMessage($command, $resolvedLanguage);
	}

	/**
	 * Returns a localized message.
	 *
	 * @param string $key Message key.
	 * @param array<int, mixed> $params Message parameters.
	 * @param string $player Player name (used for language resolution).
	 */
	public function getMessage(string $key, array $params = [], string $player = "console") :string {
		return $this->api->getMessage($key, $params, $player);
	}

	/**
	 * Sets a player's language preference.
	 */
	public function setPlayerLanguage(string $player, string $language) :bool {
		return $this->api->setPlayerLanguage($player, $language);
	}

	/**
	 * Returns the monetary unit (currency symbol).
	 */
	public function getMonetaryUnit() :string {
		return $this->api->getMonetaryUnit();
	}

	/**
	 * Returns all balances keyed by player name.
	 *
	 * @return array<string, float>
	 */
	public function getAllMoney() :array {
		return $this->api->getAllMoney();
	}

	/**
	 * Creates an account if it does not already exist.
	 *
	 * @param Player|string $player Player instance or name.
	 * @param float|bool $defaultMoney Default balance or false to use config.
	 * @param bool $force If true, ignores cancellation from events.
	 */
	public function createAccount(Player|string $player, float|bool $defaultMoney = false, bool $force = false) :bool {
		$resolvedMoney = $defaultMoney === false ? null : (int)$defaultMoney;
		return $this->api->createAccount($player, $resolvedMoney, $force, "none");
	}

	/**
	 * Checks if an account exists for the player.
	 *
	 * @param Player|string $player Player instance or name.
	 */
	public function accountExists(Player|string $player) :bool {
		return $this->api->accountExists($player);
	}

	/**
	 * Returns the balance for a player name or Player.
	 *
	 * @param Player|string $player Player instance or name.
	 *
	 * @return float|bool Balance, or false if the account does not exist.
	 */
	public function myMoney(Player|string $player) :float|bool {
		return $this->api->myMoney($player);
	}

	/**
	 * Sets the player's balance.
	 *
	 * @param Player|string $player Player instance or name.
	 * @param float $amount New balance.
	 * @param bool $force If true, ignores cancellation from events.
	 * @param string $issuer Identifier for auditing/events.
	 *
	 * @return int Result code from ResultCode::RET_*.
	 */
	public function setMoney(Player|string $player, float $amount, bool $force = false, string $issuer = "none") :int {
		return $this->api->setMoney($player, (int)$amount, $force, $issuer);
	}

	/**
	 * Adds money to the player's balance.
	 *
	 * @param Player|string $player Player instance or name.
	 * @param float $amount Amount to add.
	 * @param bool $force If true, ignores cancellation from events.
	 * @param string $issuer Identifier for auditing/events.
	 *
	 * @return int Result code from ResultCode::RET_*.
	 */
	public function addMoney(Player|string $player, float $amount, bool $force = false, string $issuer = "none") :int {
		return $this->api->addMoney($player, (int)$amount, $force, $issuer);
	}

	/**
	 * Reduces money from the player's balance.
	 *
	 * @param Player|string $player Player instance or name.
	 * @param float $amount Amount to reduce.
	 * @param bool $force If true, ignores cancellation from events.
	 * @param string $issuer Identifier for auditing/events.
	 *
	 * @return int Result code from ResultCode::RET_*.
	 */
	public function reduceMoney(
		Player|string $player,
		float $amount,
		bool $force = false,
		string $issuer = "none"
	) :int {
		return $this->api->reduceMoney($player, (int)$amount, $force, $issuer);
	}
}
