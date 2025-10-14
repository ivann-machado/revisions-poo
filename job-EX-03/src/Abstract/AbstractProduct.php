<?php
namespace App\Abstract;
use DateTime;
use App\Database;
use reflectionProperty;
use App\Interface\EntityInterface;

abstract class AbstractProduct implements EntityInterface {
	protected ?int $id;
	protected int $category_id;
	protected string $name;
	protected array $photo;
	protected int $price;
	protected string $description;
	protected int $quantity;
	protected DateTime $createdAt;
	protected DateTime $updatedAt;


	function __construct(?int $id = null, int $category_id = null, string $name = null, array $photo = null, int $price = null, string $description = null, int $quantity = null, DateTime $createdAt = null, DateTime $updatedAt = null) {
		$this->hydrate([
			'id' => $id ?? -1,
			'category_id' => $category_id,
			'name' => $name,
			'photo' => $photo ?? [],
			'price' => $price,
			'description' => $description,
			'quantity' => $quantity,
			'createdAt' => $createdAt,
			'updatedAt' => $updatedAt
		]);
	}

	public function getId(): int {
		return $this->id;
	}

	public function setId(?int $id): void {
		$this->id = $id;
	}

	public function getCategory_id(): int {
		return $this->category_id;
	}

	public function setCategory_id(int $category_id): void {
		$this->category_id = $category_id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): void {
		$this->name = $name;
	}

	public function getPhoto(): array {
		return $this->photo;
	}

	public function setPhoto(string|array $photo): void {
		if (is_string($photo)) {
			$photo = explode(',', $photo);
		}
		$this->photo = $photo;
	}

	public function getPrice(): int {
		return $this->price;
	}

	public function setPrice(int $price): void {
		$this->price = $price;
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function setDescription(string $description): void {
		$this->description = $description;
	}

	public function getQuantity(): int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity): void {
		$this->quantity = $quantity;
	}

	public function getCreatedAt(): DateTime {
		return $this->createdAt;
	}

	public function setCreatedAt(string|DateTime $createdAt): void {
		if (is_string($createdAt)) {
			$createdAt = new DateTime($createdAt);
		}
		$this->createdAt = $createdAt;
	}

	public function getUpdatedAt(): DateTime {
		return $this->updatedAt;
	}

	public function setUpdatedAt(string|DateTime $updatedAt): void {
		if (is_string($updatedAt)) {
			$updatedAt = new DateTime($updatedAt);
		}
		$this->updatedAt = $updatedAt;
	}

	public function getCategory(): ?Category {
		$pdo = Database::connect();
		$stmt = $pdo->prepare('SELECT * FROM `category` WHERE `id` = :id');
		$stmt->execute(['id' => $this->category_id]);
		$result = $stmt->fetch();

		if ($result) {
			return new Category($result['id'], $result['name'], new DateTime($result['createdAt']), new DateTime($result['updatedAt']));
		}
		return null;
	}

	protected function hydrate(array $data): void {
		foreach ($data as $key => $value) {
			if ($value !== null) {
				$method = 'set' . ucfirst($key);
				if (method_exists($this, $method)) {
					$this->$method($value);
				}
			}
		}
	}

	abstract public function findOneById(int $id): Bool|Self;

	abstract public static function findAll(): array;

	public function create(): bool|Self {
		if ($this->id) {
			return false;
		}
		$pdo = Database::connect();
		$stmt = $pdo->prepare('INSERT INTO `product` (`category_id`, `name`, `photo`, `price`, `description`, `quantity`, `createdAt`, `updatedAt`) VALUES (:category_id, :name, :photo, :price, :description, :quantity, :createdAt, :updatedAt)');
		$result = $stmt->execute([
			'category_id' => $this->category_id,
			'name' => $this->name,
			'photo' => implode(',', $this->photo),
			'price' => $this->price,
			'description' => $this->description,
			'quantity' => $this->quantity,
			'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
			'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
		]);

		if ($result) {
			$this->id = (int)$pdo->lastInsertId();
			return $this;
		}
		return false;
	}

	public function update(): void {
		$pdo = Database::connect();
		$stmt = $pdo->prepare('UPDATE `product` SET `category_id` = :category_id, `name` = :name, `photo` = :photo, `price` = :price, `description` = :description, `quantity` = :quantity, `createdAt` = :createdAt, `updatedAt` = :updatedAt WHERE `id` = :id');
		$stmt->execute([
			'id' => $this->id,
			'category_id' => $this->category_id,
			'name' => $this->name,
			'photo' => implode(',', $this->photo),
			'price' => $this->price,
			'description' => $this->description,
			'quantity' => $this->quantity,
			'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
			'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
		]);
	}

	// public abstract function save(): bool|Self;

	public function save(): bool|Self {
		if ($this->id > -1) {
			$this->update();
			return $this;
		}
		return $this->create();
	}
}
?>