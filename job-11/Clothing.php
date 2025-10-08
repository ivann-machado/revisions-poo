<?php
class Clothing extends Product {
	private string $size;
	private string $color;
	private string $type;
	private int $material_fee;

	public function __construct(string $size = null, string $color = null, string $type = null, int $material_fee = null, int $id = null, int $category_id = null, string $name = null, array $photo = null, int $price = null, string $description = null, int $quantity = null, DateTime $createdAt = null, DateTime $updatedAt = null) {
		parent::__construct($id, $category_id, $name, $photo, $price, $description, $quantity, $createdAt, $updatedAt);
		$this->hydrate([
			'size' => $size,
			'color' => $color,
			'type' => $type,
			'material_fee' => $material_fee
		]);
	}

	public function getSize(): string {
		return $this->size;
	}

	public function setSize(string $size): void{
		$this->size = $size;
	}

	public function getColor(): string {
		return $this->color;
	}

	public function setColor(string $color): void {
		$this->color = $color;
	}

	public function getType(): string {
		return $this->type;
	}

	public function setType(string $type): void {
		$this->type = $type;
	}

	public function getMaterial_fee(): int {
		return $this->material_fee;
	}

	public function setMaterial_fee(int $material_fee): void {
		$this->material_fee = $material_fee;
	}
}
?>