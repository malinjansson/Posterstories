<?php

class Cart {
    private $dbConnection;
    private $sessionId;
    private $userId;
    private $cartItems = [];

    public function getItemsCount() {
        $totalQuantity = 0;
        foreach($this->cartItems as $item){
            $totalQuantity += $item->quantity;
        }
        return $totalQuantity;
    }

    public function __construct($dbConnection, $sessionId, $userId = null) {
        $this->dbConnection = $dbConnection;
        $this->sessionId = $sessionId;
        $this->userId = $userId;
        $this->cartItems = $this->dbConnection->getCartItems($userId,$sessionId);

    }

    public function convertSessionToUser($userId, $newSessionId) {
        $this->dbConnection->convertSessionToUser($this->sessionId, $userId, $newSessionId);
      
        $this->userId = $userId;
        $this->sessionId = $newSessionId;
    }

    public function addItem($productId, $quantity) {
        $item = $this->getCartItem($productId);
        if (!$item) {
            $item = new CartItem();
            $item->productId = $productId;
            $item->quantity = $quantity;
            array_push($this->cartItems, $item);
        }else{
            $item->quantity += $quantity;
        }
        $this->dbConnection->updateCartItem($this->userId,$this->sessionId, $productId, $item->quantity);
    }

    public function removeItem($productId, $quantity) {
        $item = $this->getCartItem($productId);
        if( !$item) {
            return;
        }
        $item->quantity -= $quantity;
        $this->dbConnection->updateCartItem($this->userId,$this->sessionId, $productId, $item->quantity);
        if ($item->quantity <= 0) {
            array_splice($this->cartItems, array_search($item, $this->cartItems), 1);
        }
    }

    public function getCartItem($productId) {
        foreach ($this->cartItems as $item) {
            if ($item->productId == $productId) {
                return $item;
            }
        }
        return null;
    }

    public function getItems() {
        return $this->cartItems;
    }

    public function clearCart() {
        $this->cartItems = [];
    }
}

?>