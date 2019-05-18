<?php


class Order
{
    /*
     * Save users order to database
     */

    public static function save($userName, $userPhone, $userComment, $userId, $productsInCart){
        $db = Db::getConnection();
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';
        $productsInCart = json_encode($productsInCart);
        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $productsInCart, PDO::PARAM_STR);

        return $result->execute();
    }

    /*
     * return all orders
     */

    public static function getAllOrders(){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product_order ORDER BY id DESC';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }

        return $ordersList;
    }

    /*
     * return current order
     */

    public static function getOrderById($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product_order WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    /*
     * update current order
     */

    public static function updateOrderById($params){
        $db = Db::getConnection();
        $sql = "UPDATE product_order SET user_name = :user_name, user_phone = :user_phone, user_comment = :user_comment, date = :date, status = :status  WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $params['id'], PDO::PARAM_INT);
        $result->bindParam(':user_name', $params['user_name'], PDO::PARAM_STR);
        $result->bindParam(':user_phone', $params['user_phone'], PDO::PARAM_STR);
        $result->bindParam(':user_comment', $params['user_comment'], PDO::PARAM_STR);
        $result->bindParam(':date', $params['date'], PDO::PARAM_STR);
        $result->bindParam(':status', $params['status'], PDO::PARAM_INT);

        return $result->execute();
    }

    /*
     * Delete current order
     */

    public static function deleteOrderById($id){
        $db = Db::getConnection();
        $sql = 'DELETE FROM product_order WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /*
     * View orders status for admin
     */

    public static function getStatusText($orderStatus){
        switch ($orderStatus) {
            case '1':
                return 'Новый заказ';
                break;
            case '2':
                return 'В обработке';
                break;
            case '3':
                return 'Доставляется';
                break;
            case '4':
                return 'Закрыт';
                break;
        }
    }

}