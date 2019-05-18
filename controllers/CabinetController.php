<?php

class CabinetController
{

    /*
     * Action for users cabinet
     */

    public function actionIndex(){
        $userid = User::checkLogged();
        $user = User::getUserById($userid);


        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    /*
     * Action for edit data about user
     */

    public function actionEdit(){
        $userid = User::checkLogged();
        $user = User::getUserById($userid);
        $result = false;
        $name = $user['name'];
        $password = $user['password'];

        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
            $errors = false;

            $errors[] = User::checkName($name);
            $errors[] = User::checkPassword($password);
            $errors = array_filter($errors);
            if ($errors == false) {
                $result = User::edit($userid, $name, $password);
            }
        }
        require_once ROOT . '/views/cabinet/edit.php';
        return true;
    }

}