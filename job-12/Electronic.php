<?php
class Electronic extends Product {
	private string $brand;
	private int $warranty_fee;

	public function __construct(string $brand = null, int $warranty_fee = null, int $id = null, int $category_id = null, string $name = null, array $photo = null, int $price = null, string $description = null, int $quantity = null, DateTime $createdAt = null, DateTime $updatedAt = null) {
		parent::__construct($id, $category_id, $name, $photo, $price, $description, $quantity, $createdAt, $updatedAt);
		$this->hydrate([
			'brand' => $brand,
			'warranty_fee' => $warranty_fee
		]);
	}

	public function getBrand(): string {
		return $this->brand;
	}

	public function setBrand(string $brand): void {
		$this->brand = $brand;
	}

	public function getWarranty_fee(): int {
		return $this->warranty_fee;
	}

	public function setWarranty_fee(int $warranty_fee): void {
		$this->warranty_fee = $warranty_fee;
	}

	public function create(): Bool|Electronic {
		if(parent::create() instanceof Product) {
			$pdo = Database::connect();
			$req = $pdo->prepare('INSERT INTO electronic (product_id, brand, warranty_fee) VALUES (:product_id, :brand, :warranty_fee)');
			$params = [
				'product_id' => $this->$id,
				'brand' => $this->$brand,
				'warranty_fee' => $this->$warranty_fee
			];
			if($req->execute($params)) {
				return $this;
			}
			return false;
		}
		return false;
	}

}
?>