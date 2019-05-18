<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.10.2018
 * Time: 21:32
 */
class Category
{
    /*
     * return all visible categories
     */
    public static function getAllCategories(){
        $db = DB::getConnection();
        $sql = 'SELECT * FROM category WHERE status = "1" ORDER BY sort_order, name ASC ';
        $result = $db->prepare($sql);
        $result->execute();
        $i =0;
        $categoryeslist = array();
        while ($row = $result->fetch()){
            $categoryeslist[$i]['id'] = $row['id'];
            $categoryeslist[$i]['name'] = $row['name'];
            $categoryeslist[$i]['sort_order'] = $row['sort_order'];
            $i++;
        }
        return $categoryeslist;
    }

    /*
     * return all categories for admin
     */

    public static function getAllCategoriesForAdmin(){
        $db = DB::getConnection();
        $sql = 'SELECT * FROM category ORDER BY sort_order, name ASC ';
        $result = $db->prepare($sql);
        $result->execute();
        $i =0;
        $categoryeslist = array();
        while ($row = $result->fetch()){
            $categoryeslist[$i]['id'] = $row['id'];
            $categoryeslist[$i]['name'] = $row['name'];
            $categoryeslist[$i]['sort_order'] = $row['sort_order'];
            $categoryeslist[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoryeslist;
    }

    /*
     * Create new category
     */

    public static function createCategory($options){
        $db = Db::getConnection();
        $sql = 'INSERT INTO category (name, sort_order, status) VALUES (:name, :sort_order, :status)';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':sort_order', $options['sort_order'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);

        return $result->execute();
    }

    /*
     * return current category
     */

    public static function getCategoryById($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM category WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    /*
     * Update current vategory
     */

    public static function updateCategoryById($params){
        $db = Db::getConnection();
        $sql = "UPDATE category SET name = :name, sort_order = :sort_order,  status = :status WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam('name',$params['name'],PDO::PARAM_STR);
        $result->bindParam('sort_order',$params['sort_order'],PDO::PARAM_STR);
        $result->bindParam('status',$params['status'],PDO::PARAM_STR);
        $result->bindParam('id',$params['id'],PDO::PARAM_STR);
        return $result->execute();
    }

    /*
     * Delete current category
     */

    public static function deleteCategoryById($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM category WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /*
     * View for category status
     */

    public static function getStatusText($status){
        switch ($status){
            case 0:
                return 'не отображается';
                break;
            case 1:
                return 'отображается';
                break;
        }
    }

}