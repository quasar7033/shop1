<?php

class AdminController extends AdminBase
{
    /*
     * Action for view admins base cabinet
     */
    public function actionindex(){
        self::checkAdmin();

        require_once ROOT.'/views/admin/index.php';
        return true;
    }

}