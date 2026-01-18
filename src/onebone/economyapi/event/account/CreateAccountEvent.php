<?php
declare(strict_types=1);

namespace onebone\economyapi\event\account;

use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\EconomyAPIEvent;

/**
 * Fired before an account is created (legacy).
 */
final class CreateAccountEvent extends EconomyAPIEvent {

	private string $username;

	private float $defaultMoney;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 * @param string $username Username.
	 * @param float $defaultMoney Default money.
	 * @param string $issuer Issuer.
	 */
	public function __construct(EconomyAPI $plugin, string $username, float $defaultMoney, string $issuer) {
		parent::__construct($plugin, $issuer);
		$this->username = $username;
		$this->defaultMoney = $defaultMoney;
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
	 * Returns default money.
	 *
	 * @return float
	 */
	public function getDefaultMoney() :float {
		return $this->defaultMoney;
	}

	/**
	 * Sets default money.
	 *
	 * @param float $money Money amount.
	 */
	public function setDefaultMoney(float $money) :void {
		$this->defaultMoney = $money;
	}
}
