<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 31.10.2018
 * Time: 14:45
 */
class CartController
{
    /*
     * Action for submit order
     */

    public function actionCheckout(){
        $productsInCart = Cart::getProducts();
        if ($productsInCart == false){
            header("Location: /");
        }
        $categories = Category::getAllCategories();
        $productIds = array_keys($productsInCart);
        $products = Product::getProductsByProductIds($productIds);
        $totalPrice = Cart::getTotalPrise($products);
        $totalQuantity = Cart::countItems();

        $userName = false;
        $userPhone = false;
        $userComment  = false;
        $result = false;

        if (!User::isGuest()){
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else{
            $userId = false;
        }

        if (isset($_POST['submit'])){
            $userName = htmlspecialchars($_POST['userName']);
            $userPhone =htmlspecialchars ($_POST['userPhone']);
            $userComment = htmlspecialchars($_POST['userComment']);
            $errors = false;
            $errors[] = User::checkName($userName);
            $errors[] = User::checkPhone($userPhone);
            $errors = array_filter($errors);
            if ($errors == false){
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);
                Cart::clear();

            }

        }
        require_once(ROOT . '/views/cart/checkout.php');
        return true;


    }

    /*
     * Action for view products in the cart
     */

    public function actionIndex(){
        $productsInCart = Cart::getProducts();
        $categories = Category::getAllCategories();

        if ($productsInCart){
            $productIds = array_keys($productsInCart);
            $products = Product::getProductsByProductIds($productIds);
            $totalPrice = Cart::getTotalPrise($products);
        }
        require_once(ROOT . '/views/cart/index.php');
        return true;
    }

    public function actionAdd($params){
        $productId= array_shift($params);
        Cart::addProduct($productId);
        $refferrer = $_SERVER['HTTP_REFERER'];
        header("Location: $refferrer");
    }

    public function actionDelete($params){
        $productId = array_shift($params);
        Cart::deleteProductByProductId($productId);
        $refferrer = $_SERVER['HTTP_REFERER'];
        header("Location: $refferrer");
    }

}