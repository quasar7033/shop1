<?php


class Product
{
    /*
     * show products if quantity is not set
     */
    const SHOW_BY_DEFAULT = 6;

    /*
     * get latest visible products
     */

    public static function getLatestProducts($amount = self::SHOW_BY_DEFAULT){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product WHERE status = "1" ORDER BY id DESC LIMIT :amount';
        $result = $db->prepare($sql);
        $result->bindParam('amount',$amount,PDO::PARAM_INT);
        //$result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $i =0;
        $productsList = array();
        while ($row = $result->fetch()){
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    /*
     * get products with flag recomended in database for slider in the main page
     */

    public static function getRecommendedProducts(){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product WHERE is_recommended = "1" ORDER BY id DESC';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $i =0;
        $productsList = array();
        while ($row = $result->fetch()){
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    /*
     * get products in current category
     */

    public static function getProductsByCategory($category_id, $page = 1){
        $limit = Product::SHOW_BY_DEFAULT;
        $offset = ($page -1) * self::SHOW_BY_DEFAULT;
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product WHERE status = 1 AND category_id = :category_id ORDER BY id ASC LIMIT :limit OFFSET :offset';
        $result = $db->prepare($sql);
        $result->bindParam('category_id',$category_id,PDO::PARAM_INT);
        $result->bindParam('limit',$limit,PDO::PARAM_INT);
        $result->bindParam('offset',$offset,PDO::PARAM_INT);
        $result->execute();

        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $products;
    }

    /*
     * amount of all products in category
     */

    public static function getTotalProductsInCategory($category_id){
        $db = Db::getConnection();
        $sql = 'SELECT count(id) AS count FROM product WHERE status="1" AND category_id = :category_id';
        $result = $db->prepare($sql);
        $result->bindParam('category_id',$category_id,PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        return $row['count'];
    }

    /*
     * return current product
     */

    public static function getProductByID($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    /*
     * return current products
     */

    public static function getProductsByProductIds($productsIds){
        $productsIds = implode(',',$productsIds);
        $db = Db::getConnection();
        $sql = "SELECT * FROM product WHERE status = 1 AND id IN ($productsIds)";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    /*
     * return all products
     */

    public static function getAllProducts(){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product ORDER BY id ASC';
        $result = $db->prepare($sql);
        $result->execute();

        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    /*
     * create new product
     */

    public static function createProduct($options){
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO product (name, code, price, category_id, brand, availability, description, is_new, is_recommended, status) VALUES (:name, :code, :price, :category_id, :brand, :availability, :description, :is_new, :is_recommended, :status)';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    /*
     * Update current product
     */

    public static function updateProductById($id, $options){
        $db = Db::getConnection();
        $sql = "UPDATE product SET  name = :name, code = :code, price = :price,  category_id = :category_id, brand = :brand,  availability = :availability, description = :description, is_new = :is_new, is_recommended = :is_recommended, status = :status WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }

    /*
     * Delete current product
     */

    public static function deleteProductById($id){
        $db = Db::getConnection();
        $sql = 'DELETE FROM product WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }


    /*
     * path to image of the products
     */
    public static function getImage($productId){
        $noImage = 'no-image.jpg';
        $path = '/upload/images/products/';
        $parhToProductsImage = $path.$productId.'.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$parhToProductsImage)){
            return $parhToProductsImage;
        }

        return $path . $noImage;
    }

    /*
     * View alaviability of the products for admin
     */
    public static function getAvailabilityText($avalibility){
        switch ($avalibility){
            case '1':
                return 'В наличии';
                break;
            case '0':
                return 'Под заказ';
                break;
        }
    }
}