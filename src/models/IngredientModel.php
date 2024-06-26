<?php
class IngredientModel extends DB {
    public function __construct() {
        parent::__construct();
    }

    public function getAllIngredients() {
        $sql = "SELECT id,name,inventory,price,unit,inventory*price as total_price FROM ingredients Where status >= 0 ORDER by id DESC";
        return $this->query($sql)->fetchAll();
    }

    public function getIngredientById($id) {
        $sql = "SELECT * FROM ingredients WHERE id = :id";
        return $this->query($sql, ['id' => $id])->fetch();
    }

    public function createIngredient($name, $price, $unit, $inventory) {
        $sql = "INSERT INTO ingredients (name, price, unit, inventory) VALUES (:name, :price, :unit, :inventory)";
        return $this->execute($sql, ['name' => $name, 'price' => $price, 'unit' => $unit, 'inventory' => $inventory]);
    }

    public function updateIngredient($id, $name, $price, $unit, $inventory) {
        $sql = "UPDATE ingredients SET name = :name, price = :price, unit = :unit, inventory = :inventory WHERE id = :id";
        echo 'id='.$id.'_name='.$name.'_price='.$price.'_unit='.$unit.'_iven='.$inventory;
        return $this->execute($sql, ['id' => $id, 'name' => $name, 'price' => $price, 'unit' => $unit, 'inventory' => $inventory]);
    }

    public function deleteIngredient($id) {
        // $sql = "DELETE FROM ingredients WHERE id = :id";
        $sql = "UPDATE ingredients SET status = -1 WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}
?>
