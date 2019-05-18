<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.10.2018
 * Time: 16:10
 */
class CatalogController
{
    /*
     * Action for view all catalogs
     */

    public function actionIndex(){
        $categories = Category::getAllCategories();
        $categoryProducts = Product::getLatestProducts(12);

        require_once ROOT.'/views/catalog/index.php';
        return true;
    }

    /*
     * Action for view single catalog
     */

    public function actionCategory($categoryparams){
        $categoryId= array_shift($categoryparams);
        $page= array_shift($categoryparams);
        if (!isset($page)){
            $page =1;
        }
        $categories = Category::getAllCategories();
        $categoryProducts = Product::getProductsByCategory($categoryId,$page);
        $total = Product::getTotalProductsInCategory($categoryId);
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once ROOT.'/views/catalog/category.php';
        return true;
    }

}