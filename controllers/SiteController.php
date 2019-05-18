<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.10.2018
 * Time: 21:09
 */
class SiteController
{
    /*
     * Action for main page
     */

    public function actionIndex(){
        $categories = Category::getAllCategories();
        $latestProducts = Product::getLatestProducts(6);
        $sliderProducts = Product::getRecommendedProducts();

        require_once ROOT.'/views/site/index.php';
        return true;
    }

    /*
     * Action for contacts
     */

    public function actionContact(){
        $result = false;
        $userEmail = false;
        $userText = false;

        if (isset($_POST['submit'])){
            $userEmail = htmlspecialchars($_POST['userEmail']);
            $userText = htmlspecialchars($_POST['userText']);
            $errors = false;
            $errors[] = User::checkEmail($userEmail);
            $errors = array_filter($errors);
            if ($errors == false) {
                $adminEmail = 'admin@mail.ruu';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                mail($adminEmail, $subject, $message);
                $result = true;
            }
        }
        require_once ROOT.'/views/site/contact.php';
        return true;
    }

    /*
     * Action for about
     */

    public function actionAbout(){
        require_once ROOT.'/views/site/about.php';
        return true;
    }

}