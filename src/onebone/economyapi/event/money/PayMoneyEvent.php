<?php
declare(strict_types=1);

namespace onebone\economyapi\event\money;

use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\EconomyAPIEvent;

/**
 * Fired before a payment is executed (legacy).
 */
final class PayMoneyEvent extends EconomyAPIEvent {

	private string $payer;

	private string $target;

	private float $amount;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 * @param string $payer Payer name.
	 * @param string $target Target name.
	 * @param float $amount Amount.
	 */
	public function __construct(EconomyAPI $plugin, string $payer, string $target, float $amount) {
		parent::__construct($plugin, "PayCommand");
		$this->payer = $payer;
		$this->target = $target;
		$this->amount = $amount;
	}

	/**
	 * Returns payer.
	 *
	 * @return string
	 */
	public function getPayer() :string {
		return $this->payer;
	}

	/**
	 * Returns target.
	 *
	 * @return string
	 */
	public function getTarget() :string {
		return $this->target;
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
