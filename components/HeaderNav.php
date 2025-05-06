<?php
require_once("Models/Database.php");
require_once("Models/Cart.php");
    function HeaderNav (){
        $dbConnection = new Database();

        $userId = null;
        $session_id = null;
        
        if($dbConnection->getUsersDatabase()->getAuth()->isLoggedIn()){
            $userId = $dbConnection->getUsersDatabase()->getAuth()->getUserId();
        }
        $session_id = session_id();
        
        $cart = new Cart($dbConnection, $session_id, $userId);
    ?>
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <a class="navbar-brand" href="/">Poster stories</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/category?all-products">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <?php
                                foreach($dbConnection->getAllCategories() as $cat){
                                    echo "<li><a class='dropdown-item' href='/category?catname=$cat'>$cat</a></li>";
                                }
                                ?>
                            </ul> 
                        </li>
                        <?php
                         if($dbConnection->getUsersDatabase()->getAuth()->isLoggedIn()){ ?>
                             <li class="nav-item"><a class="nav-link" href="/user/logout">Logout</a></li>
                         <?php }else{ ?>
                             <li class="nav-item"><a class="nav-link" href="/user/login">Login</a></li>
                             <li class="nav-item"><a class="nav-link" href="/user/register">Create account</a></li>
                         <?php 
                         }
                         ?>
                    </ul>
                    <?php if($dbConnection->getUsersDatabase()->getAuth()->isLoggedIn()){ ?>
                         Current user: <?php echo $dbConnection->getUsersDatabase()->getAuth()->getEmail() ?>
                    <?php } ?>
                    <form action="/search" method="GET">
                         <input type="text" name="q" placeholder="Search" class="form-control">
                      </form>   
                </div>
                <form class="d-flex">
                    <a href="/cart" class="position-relative btn btn-outline-dark" type="submit">
                        <i class="bi-bag-fill me-1"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
                            <?php echo $cart->getItemsCount(); ?>
                        </span>
                    </a>
                </form>
            </div>
        </nav>
    <?php
    }
?>