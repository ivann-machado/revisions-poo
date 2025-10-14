<?php
namespace App\Interface;

interface EntityInterface {
	// public int $id { get; set; };

	public function getId(): int;
	public function setId(int $id): void;
}
?>