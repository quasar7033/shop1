<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.10.2018
 * Time: 21:27
 */
class User
{

    /*
     * Check user guest or register
     */

    public static function isGuest(){
        if (isset($_SESSION['user'])){
            return false;
        }
        return true;
    }

    /*
     * Check user or guest
     * if guest then return to main page
     */

    public static function checkLogged(){
        if (isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        header("Location: /user/login");
    }

    /*
     * return current user
     */

    public static function getUserById($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    /*
     * Add new user in database
     */

    public static function register($name,$email,$password){
        $db = Db::getConnection();
        $sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';
        $result = $db->prepare($sql);
        $result->bindParam('name', $name, PDO::PARAM_STR);
        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /*
     * Edit information about user
     */

    public static function edit($id, $name, $password){
        $db = Db::getConnection();
        $sql = "UPDATE user  SET name = :name, password = :password WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /*
     * check users email and password in database
     */

    public static function checkUserData($email, $password){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam('email', $email, PDO::PARAM_INT);
        $result->bindParam('password', $password, PDO::PARAM_INT);
        $result->execute();
        $user = $result->fetch();
        if ($user){
            return $user['id'];
        }
        return false;
    }

    /*
     * login user
     */

    public static function auth($userId){
        $_SESSION['user'] = $userId;
    }

    /*
     * Validate for user
     * @return message
     */

    public static function checkEmail($userEmail){
        if (filter_var($userEmail,FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return 'Неправильный email';
    }
    public static function checkName($userName){
        if (strlen($userName) >= 3 ){
            return false;
        }
        return 'Имя не должно быть короче 3-х символов';
    }
    public static function checkPassword($userPassword){
        if (strlen($userPassword) >= 6){
            return false;
        }
        return 'Пароль не должен быть короче 6-ти символов';
    }
    public static function checkPhone($userPhone){
        if (strlen($userPhone) <= 7){
            return 'Телефон не должен быть короче 8 цифр';
        }
        if (!ctype_digit(strval($userPhone))){
            return 'Телефон должен состоять только из цифр';

        }
        return false;
    }

    /*
     * Check users email in registration
     */

    public static function checkEmailExist($email){
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn()){
            return 'Такой email уже используется';
        }
        return false;
    }

}