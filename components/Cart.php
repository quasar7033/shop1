<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.10.2018
 * Time: 21:22
 */
class Cart
{
    /*
     * Quantity of the products in the cart
     * @return count items in cart
     */
    public static function countItems()
    {
        if (isset($_SESSION['products'])){
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity){
                $count += $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }
    /*
     * Get all products from session
     */
    public static function getProducts(){
        if (isset($_SESSION['products'])){
            return $_SESSION['products'];
        }
    }

    /*
     * Get  total price for all products in the cart
     */

    public static function getTotalPrise($products){
        $productsInCart = self::getProducts();
        $total = 0;
        if ($productsInCart){
            foreach ($products as $item){
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }

    /*
     * Delete all products from cart
     */

    public static function clear(){
        if (isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }

    /*
     * Add product in cart
     */
    public static function addProduct($productId){
        $productsInCart = array();
        if (isset($_SESSION['products'])){
            $productsInCart = $_SESSION['products'];
        }
        if (array_key_exists($productId,$productsInCart)){
            $productsInCart[$productId] ++;
        } else{
            $productsInCart[$productId] = 1;
        }
        $_SESSION['products'] = $productsInCart;
        return self::countItems();
    }

    /*
     * Delete product from cart
     */
    public static function deleteProductByProductId($productId){
        $productsInCart = array();
        if (isset($_SESSION['products'])){
            $productsInCart = $_SESSION['products'];
            unset($productsInCart[$productId]);
            $_SESSION['products'] = $productsInCart;
        }

    }

}