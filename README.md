# EconomyAPI (MyEconomy Adapter)

This plugin is a compatibility layer that provides the classic `EconomyAPI` API surface while delegating all storage and
logic to MyEconomy.

## Requirements

- PocketMine-MP API 5
- MyEconomy plugin enabled

## Installation

1. Copy both `MyEconomy` and `EconomyAPI` into your server `plugins` directory.
2. Start the server. The `EconomyAPI` adapter will bind to MyEconomy automatically.

## Usage

Existing EconomyAPI-based plugins should work without changes. The adapter exposes the familiar API and emits legacy
events for listeners.

## API Example

```php
use onebone\economyapi\EconomyAPI;

$api = EconomyAPI::getInstance();
$api->addMoney("Steve", 100);
```

## Notes

- The adapter does not store data itself; all data lives in MyEconomy.
- MyEconomy events are the primary integration point for new plugins.
