<?php
declare(strict_types=1);

namespace onebone\economyapi\event\money;

use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\EconomyAPIEvent;

/**
 * Fired before money is added to an account (legacy).
 */
final class AddMoneyEvent extends EconomyAPIEvent {

	private string $username;

	private float $amount;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 * @param string $username Username.
	 * @param float $amount Amount.
	 * @param string $issuer Issuer.
	 */
	public function __construct(EconomyAPI $plugin, string $username, float $amount, string $issuer) {
		parent::__construct($plugin, $issuer);
		$this->username = $username;
		$this->amount = $amount;
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
	 * Returns amount.
	 *
	 * @return float
	 */
	public function getAmount() :float {
		return $this->amount;
	}
}
