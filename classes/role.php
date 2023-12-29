<?php

class Role
{
    function  getRolesList($db)
    {
        $query = "SELECT * FROM `roles`";
        $response = $db->query($query);
        $result = $response->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function getRoleName($db, $id)
    {
        $query = "SELECT `name` FROM `roles` WHERE `id` = '{$id}'";
        $response = $db->query($query);
        $result = $response->fetch_assoc();

        return $result['name'];
    }
}
