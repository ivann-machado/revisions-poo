<?php
	class Product  {
		private int $id;
		private int $category_id;
		private string $name;
		private array $photo;
		private int $price;
		private string $description;
		private int $quantity;
		private DateTime $createdAt;
		private DateTime $updatedAt;


		function __construct(int $id = null, int $category_id = null, string $name = null, array $photo = null, int $price = null, string $description = null, int $quantity = null, DateTime $createdAt = null, DateTime $updatedAt = null) {
			$this->hydrate([
				'id' => $id,
				'category_id' => $category_id,
				'name' => $name,
				'photo' => $photo,
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

		public function setId(int $id): void {
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

		public function setPhoto(array $photo): void {
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

		public function setCreatedAt(DateTime $createdAt): void {
			$this->createdAt = $createdAt;
		}

		public function getUpdatedAt(): DateTime {
			return $this->updatedAt;
		}

		public function setUpdatedAt(DateTime $updatedAt): void {
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

		private function hydrate(array $data): void {
			foreach ($data as $key => $value) {
				$method = 'set' . ucfirst($key);
				if (method_exists($this, $method)) {
					$this->$method($value);
				}
			}
		}

		public function findOneById(int $id): Boolean|Product {
			$pdo = Database::connect();
			$stmt = $pdo->prepare('SELECT * FROM `product` WHERE `id` = :id');
			$stmt->execute(['id' => $id]);
			$result = $stmt->fetch();

			if ($result) {
				$this->hydrate($result);
				return $this;
			}
			return false;
		}
	}
?>