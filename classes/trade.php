<?php
class Trade
{
    function  getTradesList($db, $search = '')
    {
        $where = '';
        if (isset($search) && !empty($search)) {
            $where = " WHERE `name` LIKE '%{$search}%'";
        }

        $query = "SELECT * FROM `trades` $where";
        $response = $db->query($query);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function deleteTrade($db, $id)
    {
        $sql = "DELETE FROM `trades` WHERE `id` = '{$id}'";

        if (mysqli_query($db, $sql)) {
            return "Trade Deleted Successfully";
        }
    }

    function addNewTrade($db, $data)
    {
        $query = "INSERT INTO `trades` (`name`, `created_at`) 
              VALUES ('{$data['name']}', NOW() )";
        $result = $db->query($query);

        return $result;
    }

    function updateTrade($db, $data)
    {
        $sql = "UPDATE `trades` SET `name` = '{$data['name']}'  WHERE `id` = '{$data['id']}'";

        if ($db->query($sql) === TRUE) {
            return "Trade updated successfully";
        } else {
            return "Error updating record: " . $db->error;
        }
    }
    
    function getTrade($db, $id)
    {
        $query = "SELECT * FROM `trades` WHERE `id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result;
    }
}
