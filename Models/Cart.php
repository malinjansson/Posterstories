Cart-php
<?php
class Cart {
     private $dbContext;
     private $sessionId;
     private $userId;
     private $cartItems = [];
     public function __construct($dbContext, $sessionId, $userId = null) {
         $this->dbContext = $dbContext;
         $this->session_id = $sessionId;
         $this->userId = $userId;
         $this->cartItems = $this->dbContext->getCartItems($userId,$sessionId);
     }
     public function addItem($productId, $quantity) {
         if (isset($this->cartItems[$productId])) {
             $this->cartItems[$productId] += $quantity;
         } else {
             $this->cartItems[$productId] = $quantity;
         }
         $this->dbContext->updateCartItem($this->userId,$this->sessionId,  $productId, $this->cartItems[$productId]);
     }
     public function removeItem($productId, $quantity) {
         if (isset($this->cartItems[$productId])) {
             $this->cartItems[$productId] -= $quantity;
             $this->dbContext->updateCartItem($this->userId,$this->sessionId, $productId, $this->cartItems[$productId]);
             if ($this->cartItems[$productId] <= 0) {
                 unset($this->cartItems[$productId]);
             } 
         }
     }
     public function getItems() {
         return $this->cartItems;
     }
     public function clearCart() {
         $this->cartItems = [];
     }
}

?>