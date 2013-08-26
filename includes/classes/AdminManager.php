<?php
namespace  includes\classes;

class AdminManager
{
    //put your code here
    public function login($email, $password)
    {
        $link = getConnection();
        $loginResult = false;
        $password = md5($password);

        $query = " select admin_id,
                        email,
                        active
                from    admin
                where   active =   'Y'
                and     email =       '" . $email . "'
                and     password =   '" . $password . "'";


        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        $num_rows = mysql_num_rows($result); // Find no. of rows retrieved from DB

        if ($num_rows == 1) {
            $loginResult = true; // login successful
        } else {
            $loginResult = false; // login failure
        }
        return $loginResult;
    }

    public function getAdminList($is_active = "Y")
    {
        $adminList = array();
        $link = getConnection();

        $query = "select admin_id,
                        email,
                        active
                from    admin
                where   active =   '".$is_active."'";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $admin = new Admin();
            $admin->set_admin_id($newArray['admin_id']);
            $admin->set_admin_email($newArray['email']);
            $admin->setActive($newArray['active']);
            array_push($adminList, $admin);
        }
        return $adminList;
    }


    public function getAdminTableDataSource($is_active = "Y")
    {
        $adminList = $this->getAdminList($is_active);
        $dataSource = array();
        if (sizeof($adminList) > 0) {
            foreach ($adminList as $admin) {
                array_push($dataSource, array(
                    "id" => $admin->get_admin_id(),
                    "email" => $admin->get_admin_email(),
                    "is_active" => $admin->getActive(),
                    "action" => ""
                ));
            }
        }
        return $dataSource;
    }
}
?>
