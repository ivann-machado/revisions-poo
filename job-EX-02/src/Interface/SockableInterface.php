<?php
namespace App\Interface;

interface SockableInterface {
	// public function wearSocks();
	// public function removeSocks();
	// public function hasSocks(): bool;
	public function addStocks(int $quantity): self;
	public function removeStocks(int $quantity): self;
}
?>