<?php
declare(strict_types=1);

namespace onebone\economyapi\event\money;

use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\EconomyAPIEvent;

/**
 * Fired before an account balance is set (legacy).
 */
final class SetMoneyEvent extends EconomyAPIEvent {

	private string $username;

	private float $money;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 * @param string $username Username.
	 * @param float $money Money amount.
	 * @param string $issuer Issuer.
	 */
	public function __construct(EconomyAPI $plugin, string $username, float $money, string $issuer) {
		parent::__construct($plugin, $issuer);
		$this->username = $username;
		$this->money = $money;
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
	 * Returns money.
	 *
	 * @return float
	 */
	public function getMoney() :float {
		return $this->money;
	}
}
