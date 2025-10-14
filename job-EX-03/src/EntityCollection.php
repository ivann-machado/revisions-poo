<?php
namespace App;

class EntityCollection {
	public array $entities = [];

	public function add(EntityInterface $entity): self {
		$this->entities[] = $entity;
		return $this;
	}

	public function remove(EntityInterface $entity): self {
		$index = array_search($entity, $this->entities, true);
		if ($index !== false) {
			unset($this->entities[$index]);
			$this->entities = array_values($this->entities);
		}
		return $this;
	}

	public function retrieve(EntityInterface $entity): self {
		// $index = array_search($entity, $this->entities, true);

		return $this;
	}
}
?>