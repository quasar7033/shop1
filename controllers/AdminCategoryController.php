<?php


class AdminCategoryController extends AdminBase
{
    /*
     * Action for admin category cabinet
     */
    public function actionindex(){
        self::checkAdmin();
        $categoriesList = Category::getAllCategoriesForAdmin();

        require_once ROOT.'/views/admin_category/index.php';
        return true;
    }

    /*
     * Create new category
     */

    public function actionCreate(){
        self::checkAdmin();
        $options['name'] = false;
        $options['sort_order'] = false;
        $options['status'] = 1;

        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['sort_order'] = $_POST['sort_order'];
            $options['status'] = $_POST['status'];

            $errors[] = false;
            $errors[] = User::checkName($options['name']);
            $errors = array_filter($errors);

            if ($errors == false) {
               Category::createCategory($options);

                header("Location: /admin/category");
            }
        }
        require_once(ROOT . '/views/admin_category/create.php');
        return true;
    }

    /*
     * Update current category
     */

    public function actionUpdate($params){
        $id = array_shift($params);
        self::checkAdmin();
        $category = Category::getCategoryById($id);

        if (isset($_POST['submit'])) {
            $params['name'] = $_POST['name'];
            $params['sort_order'] = $_POST['sort_order'];
            $params['status'] = $_POST['status'];
            $params['id'] = $id;

            Category::updateCategoryById($params);
            header("Location: /admin/category");
        }
        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }

    /*
     * Delete category
     */

    public function actionDelete($params){
        $id = array_shift($params);
        self::checkAdmin();
        if (isset($_POST['submit'])) {
            Category::deleteCategoryById($id);
            header("Location: /admin/category");
        }
        require_once(ROOT . '/views/admin_category/delete.php');
        return true;

    }
}