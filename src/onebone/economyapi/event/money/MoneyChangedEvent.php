<?php
declare(strict_types=1);

namespace onebone\economyapi\event\money;

use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\EconomyAPIEvent;

/**
 * Fired after an account balance is changed (legacy).
 */
final class MoneyChangedEvent extends EconomyAPIEvent {

	private string $username;

	private float $newMoney;

	private ?float $oldMoney;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 * @param string $username Username.
	 * @param float $newMoney New money.
	 * @param string $issuer Issuer.
	 * @param ?float $oldMoney Old money.
	 */
	public function __construct(
		EconomyAPI $plugin,
		string $username,
		float $newMoney,
		string $issuer,
		?float $oldMoney = null
	) {
		parent::__construct($plugin, $issuer);
		$this->username = $username;
		$this->newMoney = $newMoney;
		$this->oldMoney = $oldMoney;
	}

	/**
	 * Returns username.
	 *
	 * @return string
	 */
	public function getUsername() :string {
		return $this->username;
	}

	/**
	 * Returns new money (deprecated).
	 *
	 * @deprecated
	 */
	public function getMoney() :float {
		return $this->newMoney;
	}

	/**
	 * Returns new money.
	 *
	 * @return float
	 */
	public function getNewMoney() :float {
		return $this->newMoney;
	}

	/**
	 * Returns old money.
	 *
	 * @return ?float Value or null if not available.
	 */
	public function getOldMoney() :?float {
		return $this->oldMoney;
	}
}
