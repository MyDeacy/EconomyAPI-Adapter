<?php
declare(strict_types=1);

namespace onebone\economyapi\compat;

use net\mydeacy\myeconomy\event\account\AccountCreateEvent as NewAccountCreateEvent;
use net\mydeacy\myeconomy\event\money\AddMoneyEvent as NewAddMoneyEvent;
use net\mydeacy\myeconomy\event\money\MoneyChangedEvent as NewMoneyChangedEvent;
use net\mydeacy\myeconomy\event\money\PayMoneyEvent as NewPayMoneyEvent;
use net\mydeacy\myeconomy\event\money\ReduceMoneyEvent as NewReduceMoneyEvent;
use net\mydeacy\myeconomy\event\money\SetMoneyEvent as NewSetMoneyEvent;
use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\account\CreateAccountEvent;
use onebone\economyapi\event\money\AddMoneyEvent;
use onebone\economyapi\event\money\MoneyChangedEvent;
use onebone\economyapi\event\money\PayMoneyEvent;
use onebone\economyapi\event\money\ReduceMoneyEvent;
use onebone\economyapi\event\money\SetMoneyEvent;
use pocketmine\event\Listener;

/**
 * EconomyAPI compatibility event bridge.
 */
final class EconomyEventBridge implements Listener {

	private EconomyAPI $plugin;

	/**
	 * Creates a new instance.
	 *
	 * @param EconomyAPI $plugin Plugin.
	 */
	public function __construct(EconomyAPI $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * Handles account create.
	 *
	 * @priority LOWEST
	 * @param NewAccountCreateEvent $event Event.
	 */
	public function onAccountCreate(NewAccountCreateEvent $event) :void {
		$legacy = new CreateAccountEvent(
			$this->plugin,
			$event->getUsername(),
			$event->getDefaultMoney(),
			$event->getIssuer()
		);
		$legacy->call();
		if ($legacy->isCancelled()) {
			$event->cancel();
			return;
		}
		if ($legacy->getDefaultMoney() !== $event->getDefaultMoney()) {
			$event->setDefaultMoney($legacy->getDefaultMoney());
		}
	}

	/**
	 * Handles add money.
	 *
	 * @priority LOWEST
	 * @param NewAddMoneyEvent $event Event.
	 */
	public function onAddMoney(NewAddMoneyEvent $event) :void {
		$legacy = new AddMoneyEvent(
			$this->plugin,
			$event->getUsername(),
			$event->getAmount(),
			$event->getIssuer()
		);
		$legacy->call();
		if ($legacy->isCancelled()) {
			$event->cancel();
		}
	}

	/**
	 * Handles reduce money.
	 *
	 * @priority LOWEST
	 * @param NewReduceMoneyEvent $event Event.
	 */
	public function onReduceMoney(NewReduceMoneyEvent $event) :void {
		$legacy = new ReduceMoneyEvent(
			$this->plugin,
			$event->getUsername(),
			$event->getAmount(),
			$event->getIssuer()
		);
		$legacy->call();
		if ($legacy->isCancelled()) {
			$event->cancel();
		}
	}

	/**
	 * Handles set money.
	 *
	 * @priority LOWEST
	 * @param NewSetMoneyEvent $event Event.
	 */
	public function onSetMoney(NewSetMoneyEvent $event) :void {
		$legacy = new SetMoneyEvent(
			$this->plugin,
			$event->getUsername(),
			$event->getMoney(),
			$event->getIssuer()
		);
		$legacy->call();
		if ($legacy->isCancelled()) {
			$event->cancel();
		}
	}

	/**
	 * Handles pay money.
	 *
	 * @priority LOWEST
	 * @param NewPayMoneyEvent $event Event.
	 */
	public function onPayMoney(NewPayMoneyEvent $event) :void {
		$legacy = new PayMoneyEvent(
			$this->plugin,
			$event->getPayer(),
			$event->getTarget(),
			$event->getAmount()
		);
		$legacy->call();
		if ($legacy->isCancelled()) {
			$event->cancel();
		}
	}

	/**
	 * Handles money changed.
	 *
	 * @priority MONITOR
	 * @param NewMoneyChangedEvent $event Event.
	 */
	public function onMoneyChanged(NewMoneyChangedEvent $event) :void {
		$legacy = new MoneyChangedEvent(
			$this->plugin,
			$event->getUsername(),
			$event->getNewMoney(),
			$event->getIssuer(),
			$event->getOldMoney()
		);
		$legacy->call();
	}
}
