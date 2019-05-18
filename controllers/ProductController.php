<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.10.2018
 * Time: 16:53
 */
class ProductController
{
    /*
     * Action for view details of the product
     */

    public function actionView($param){
        $productId = array_shift($param);
        $categories = Category::getAllCategories();
        $product = Product::getProductByID($productId);

        require_once ROOT.'/views/product/view.php';
        return true;
    }

}