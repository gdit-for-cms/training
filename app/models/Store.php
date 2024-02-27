<?php

namespace App\Models;

use Core\Model;
use DateTime;
use DOMDocument;
use Exception;
use Core\QueryBuilder;

class Store extends Model {

    use QueryBuilder;

    private $_table = 'store';

    public function checkStore($url) {
        $pdo = parent::getDB();
        $sql = "SELECT id FROM store WHERE link = :url";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':url', $url);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if (!$id) {
            return 0;
        }
        return $id;
    }

    function createStore($restaurant_name, $url, $img_store) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO store (name, link, update_date, image, deleted) VALUES (?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $currentDateTime = new DateTime();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        $stmt->bindParam(1, $restaurant_name);
        $stmt->bindParam(2, $url);
        $stmt->bindParam(3, $currentDateTimeString);
        $stmt->bindParam(4, $img_store);
        $result = $stmt->execute();
        return $result;
    }

    function updateStore($id, $name_list_crawl, $price_list_crawl, $img_list_crawl, $status_list_crawl) {
        $food = new Food();
        $food_list = $food->getFoodFromStore($id);
        $db_length = count($food_list);
        $crawl_length = count($name_list_crawl);

        for ($i = 0; $i < $crawl_length; $i++) {
            $flag = false;
            for ($j = 0; $j < count($food_list); $j++) {
                if ($food_list[$j]->name === $name_list_crawl[$i]) {
                    if ($food_list[$j]->price === $price_list_crawl[$i] && $food_list[$j]->image === $img_list_crawl[$i] && $food_list[$j]->is_over == $status_list_crawl[$i]) {
                        //nothing happens
                    } else {

                        $food->updateFood($food_list[$j]->id, $price_list_crawl[$i], $img_list_crawl[$i], $status_list_crawl[$i]);
                    }
                    array_splice($food_list, $j, 1);
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                $food->createFood($id, $name_list_crawl[$i], $price_list_crawl[$i], $img_list_crawl[$i], $status_list_crawl[$i]);
            }
        }
        //delete food if dont have at shopee
        for ($j = 0; $j < count($food_list); $j++) {
            $food->deleteFood($food_list[$j]->id);
        }
    }

    function checkLink($url) {

        if (!strpos($url, "shopeefood")) {
            return -1;
        }

        $store = new Store();
        $pageSource = getHTMLPage($url);
        $id = $store->checkStore($url);

        $options = LIBXML_NOERROR | LIBXML_NOWARNING;
        $dom = new DOMDocument();

        try {
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $pageSource, $options);
        } catch (Exception $e) {
            return -1;
        }

        $food = new Food();
        $name_list = getNameFromHTML($dom);
        $price_list = getPriceFromHTML($dom);
        $img_list = getImageFromHTML($dom);
        $restaurant_name = getNameStoreFromHTML($dom);
        $img_store = getImageStoreFromHTML($dom);
        $status_list = getStatusFoodFromHTML($dom);

        if (count($name_list) === 0) {
            return -1;
        }

        if (count($name_list) != count($price_list) || count($name_list) != count($img_list) || count($name_list) != count($status_list)) {
            return -1;
        }


        if ($id === 0) {
            $store->createStore($restaurant_name, $url, $img_store);
            $id = $store->checkStore($url);
            $food->createListFood($id, $name_list, $price_list, $img_list, $status_list);
        } else {
            $this->updateStore($id, $name_list, $price_list, $img_list, $status_list);
        }
        return $id;
    }

    // Query Builder setup:
    public function createStoreQB($name, $link, $updateDate, $image) {
        $data = [
            'name' => $name,
            'link' => $link,
            'update_date' => $updateDate,
            'image' => $image,
            'deleted' => 0 // Initially, the store is not deleted
        ];

        return $this->insert($data);
    }

    public function updateStoreQB($storeId, $data) {
        $conditions = "id = $storeId";
        return $this->update($data, $conditions);
    }

    public function getStoreById($storeId) {
        return $this->where('deleted', '=', 0)
            ->find($storeId);
    }

    public function getAllStores() {
        return $this->where('deleted', '=', 0)
            ->all();
    }

    public function deleteStore($storeId) {
        // Soft delete the store by setting 'deleted' to 1
        $data = ['deleted' => 1];
        $conditions = "id = $storeId";
        return $this->update($data, $conditions);
    }

    public function restoreStore($storeId) {
        // Restore the store by setting 'deleted' to 0
        $data = ['deleted' => 0];
        $conditions = "id = $storeId";
        return $this->update($data, $conditions);
    }

    public function getStoreWithFoods($storeId) {
        $this->table($this->_table)
            ->join('food', 'store.id = food.store_id')
            ->where('store.id', '=', $storeId)
            ->where('store.deleted', '=', 0)
            ->where('food.deleted', '=', 0);

        $selectColumns = 'store.id, store.name as store_name, store.link, store.update_date, store.image as store_image, '
            . 'food.id as food_id, food.name as food_name, food.price, food.image as food_image';

        return $this->select($selectColumns)->get();
    }
}
