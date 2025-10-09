<?php
namespace App;
use DateTime;
use App\Abstract\AbstractProduct;
use App\Interface\SockableInterface;

class Electronic extends AbstractProduct implements SockableInterface {
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
		if(parent::create() instanceof AbstractProduct) {
			$pdo = Database::connect();
			$req = $pdo->prepare('INSERT INTO electronic (product_id, brand, warranty_fee) VALUES (:product_id, :brand, :warranty_fee)');
			$params = [
				'product_id' => $this->id,
				'brand' => $this->brand,
				'warranty_fee' => $this->warranty_fee
			];
			if($req->execute($params)) {
				return $this;
			}
			return false;
		}
		return false;
	}

	public function update(): void {
		parent::update();
		$pdo = Database::connect();
		$stmt = $pdo->prepare('UPDATE electronic SET brand = :brand, warranty_fee = :warranty_fee WHERE product_id = :product_id');
		$stmt->execute([
			'product_id' => $this->id,
			'brand' => $this->brand,
			'warranty_fee' => $this->warranty_fee
		]);
	}

	public function findOneById(int $id): Bool|Electronic {
		$pdo = Database::connect();
		$stmt = $pdo->prepare('SELECT p.*, e.brand, e.warranty_fee FROM product p JOIN electronic e ON p.id = e.product_id WHERE p.id = :id');
		$stmt->execute(['id' => $id]);
		$result = $stmt->fetch();

		if ($result) {
			$this->hydrate($result);
			return $this;
		}
		return false;
	}

	public static function findAll(): array {
		$pdo = Database::connect();
		$stmt = $pdo->query('SELECT p.*, e.brand, e.warranty_fee FROM product p JOIN electronic e ON p.id = e.product_id');
		$results = $stmt->fetchAll();

		$electronics = [];
		foreach ($results as $result) {
			$electronics[] = new Electronic($result['brand'], $result['warranty_fee'], $result['id'], $result['category_id'], $result['name'], explode(',', $result['photo']), $result['price'], $result['description'], $result['quantity'], new DateTime($result['createdAt']), new DateTime($result['updatedAt']));
		}
		return $electronics;
	}
	public function addStocks(int $quantity): self {
		$this->quantity += $quantity;
		$this->update();
		return $this;
	}

	public function removeStocks(int $quantity): self {
		if ($this->quantity > 0) {
			$this->quantity -= $quantity;
			$this->update();
		}
		return $this;
	}
}
?>