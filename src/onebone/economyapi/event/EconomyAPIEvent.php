<?php
declare(strict_types=1);

namespace onebone\economyapi\event;

use onebone\economyapi\EconomyAPI;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\plugin\PluginEvent;

/**
 * Legacy EconomyAPI event base for compatibility.
 */
class EconomyAPIEvent extends PluginEvent implements Cancellable {

	use CancellableTrait;

	private string $issuer;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 * @param string $issuer Issuer.
	 */
	public function __construct(EconomyAPI $plugin, string $issuer) {
		parent::__construct($plugin);
		$this->issuer = $issuer;
	}

	/**
	 * Returns issuer.
	 *
	 * @return string
	 */
	public function getIssuer() :string {
		return $this->issuer;
	}
}
