<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.10.2018
 * Time: 17:16
 */
class UserController
{
    /*
     * Action for registration new user
     */

    public function actionRegister(){
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        if (isset($_POST['submit'])){
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $errors = false;

            $errors[] = User::checkName($name);
            $errors[] = User::checkEmail($email);
            $errors[] = User::checkPassword($password);
            $errors[] = User::checkEmailExist($email);
            $errors = array_filter($errors);
            if ($errors == false) {
                $result = User::register($name,$email,$password);
            }
        }

        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    /*
     * Action for users cabinet
     */

    public function actionLogin(){
        $email = false;
        $password = false;
        if (isset($_POST['submit'])){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $errors = false;

            $errors[] = User::checkEmail($email);
            $errors[] = User::checkPassword($password);
            $errors = array_filter($errors);
            if ($errors == false) {
                $userId = User::checkUserData($email,$password);
                if ($userId == false){
                    $errors[] = 'Неправильные данные для входа на сайт';
                } else{
                    User::auth($userId);
                    header("Location: /cabinet");
                }
            }
        }
        require_once(ROOT . '/views/user/login.php');
        return true;
    }
    public function actionLogout(){
        unset($_SESSION['user']);
        header("Location: /");
    }

}