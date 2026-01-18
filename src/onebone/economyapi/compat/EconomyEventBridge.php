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
use pocketmine\event\EventHandler;
use pocketmine\event\EventPriority;
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
	 * @param NewAccountCreateEvent $event Event.
	 */
	#[EventHandler(priority: EventPriority::LOWEST)]
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
	 * @param NewAddMoneyEvent $event Event.
	 */
	#[EventHandler(priority: EventPriority::LOWEST)]
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
	 * @param NewReduceMoneyEvent $event Event.
	 */
	#[EventHandler(priority: EventPriority::LOWEST)]
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
	 * @param NewSetMoneyEvent $event Event.
	 */
	#[EventHandler(priority: EventPriority::LOWEST)]
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
	 * @param NewPayMoneyEvent $event Event.
	 */
	#[EventHandler(priority: EventPriority::LOWEST)]
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
	 * @param NewMoneyChangedEvent $event Event.
	 */
	#[EventHandler(priority: EventPriority::MONITOR)]
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
