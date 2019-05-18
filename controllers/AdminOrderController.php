<?php

class AdminOrderController extends AdminBase
{
    /*
     * View all orders
     */
    public function actionIndex(){
        self::checkAdmin();
        $ordersList = Order::getAllOrders();

        require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    /*
     * Action for update current order
     */
    public function actionUpdate($params){
        $id = array_shift($params);
        self::checkAdmin();
        $order = Order::getOrderById($id);
        if (isset($_POST['submit'])) {
            $params['user_name'] = $_POST['userName'];
            $params['user_phone'] = $_POST['userPhone'];
            $params['user_comment'] = $_POST['userComment'];
            $params['date'] = $_POST['date'];
            $params['status'] = $_POST['status'];
            $params['id'] = $id;

            Order::updateOrderById($params);
            header("Location: /admin/order/view/$id");
        }
        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }
    /*
     * Action for view current order
     */

    public function actionView($params){
        $id = array_shift($params);
        self::checkAdmin();
        $order = Order::getOrderById($id);
        $productsQuantity = json_decode($order['products'], true);
        $productsIds = array_keys($productsQuantity);
        $products = Product::getProductsByProductIds($productsIds);
        require_once(ROOT . '/views/admin_order/view.php');
        return true;
    }

    /*
     * Action for delete current order
     */

    public function actionDelete($params){
        $id = array_shift($params);
        self::checkAdmin();
        if (isset($_POST['submit'])) {
            Order::deleteOrderById($id);
            header("Location: /admin/order");
        }
        require_once(ROOT . '/views/admin_order/delete.php');
        return true;
    }
}