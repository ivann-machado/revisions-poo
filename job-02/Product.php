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


		function __construct(int $id, int $category_id, string $name, array $photo, int $price, string $description, int $quantity, DateTime $createdAt, DateTime $updatedAt) {
			$this->id = $id;
			$this->category_id = $category_id;
			$this->name = $name;
			$this->photo = $photo;
			$this->price = $price;
			$this->description = $description;
			$this->quantity = $quantity;
			$this->createdAt = $createdAt;
			$this->updatedAt = $updatedAt;
		}

		public function getId(): int {
			return $this->id;
		}

		public function setId(int $id): void {
			$this->id = $id;
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
	}
?>