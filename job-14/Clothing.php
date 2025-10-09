<?php
class Clothing extends AbstractProduct implements SockableInterface {
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

	public function create(): Bool|Clothing {
		if(parent::create() instanceof Product) {
			$pdo = Database::connect();
			$req = $pdo->prepare('INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)');
			$params = [
				'product_id' => $this->id,
				'size' => $this->size,
				'color' => $this->color,
				'type' => $this->type,
				'material_fee' => $this->material_fee
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
		$stmt = $pdo->prepare('UPDATE clothing SET size = :size, color = :color, type = :type, material_fee = :material_fee WHERE product_id = :product_id');
		$stmt->execute([
			'product_id' => $this->id,
			'size' => $this->size,
			'color' => $this->color,
			'type' => $this->type,
			'material_fee' => $this->material_fee
		]);
	}

	public function findOneById(int $id): Bool|Clothing {
		$pdo = Database::connect();
		$stmt = $pdo->prepare('SELECT p.*, c.size, c.color, c.type, c.material_fee FROM product p JOIN clothing c ON p.id = c.product_id WHERE p.id = :id');
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
		$stmt = $pdo->query('SELECT p.*, c.size, c.color, c.type, c.material_fee FROM product p JOIN clothing c ON p.id = c.product_id');
		$results = $stmt->fetchAll();
		$clothings = [];
		foreach ($results as $result) {
			$clothings[] = new Clothing($result['size'], $result['color'], $result['type'], $result['material_fee'], $result['id'], $result['category_id'], $result['name'], explode(',', $result['photo']), $result['price'], $result['description'], $result['quantity'], new DateTime($result['createdAt']), new DateTime($result['updatedAt']));
		}
		return $clothings;
	}
	public function addStocks(int $quantity): self {
		$this->quantity += $quantity;
		$this->update();
		return $this;
	}

	public function removeStocks(): self {
		if ($this->quantity > 0) {
			$this->quantity -= 1;
			$this->update();
		}
		return $this;
	}
}
?>