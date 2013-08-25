<?php
namespace  includes\classes;

class Admin
{
    private $admin_id;
    private $admin_email;
    private $admin_password;
    private $active;

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function get_admin_id()
    {
        return $this->admin_id;
    }

    public function set_admin_id($_admin_id)
    {
        $this->admin_id = $_admin_id;
    }

    public function get_admin_email()
    {
        return $this->admin_email;
    }

    public function set_admin_email($_admin_email)
    {
        $this->admin_email = $_admin_email;
    }

    public function get_admin_password()
    {
        return $this->admin_password;
    }

    public function set_admin_password($_admin_password)
    {
        $this->admin_password = $_admin_password;
    }

    public function loadByEmail($email)
    {
        $link = getConnection();

        $query = " select 	admin_id,
                        email,
                        active
                from    admin
                where   active =   'Y'
                and     email =       '" . $email . "'";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $this->set_admin_id($newArray['admin_id']);
            $this->set_admin_email($newArray['email']);
            $this->setActive($newArray['active']);
        }
    }

    public function loadByID($id)
    {
        $link = getConnection();
        $query = " select admin_id,
                        email,
                        active
                from    admin
                where   active =   'Y'
                and     admin_id =  " . $id;

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $this->set_admin_id($newArray['admin_id']);
            $this->set_admin_email($newArray['email']);
            $this->setActive($newArray['active']);
        }
    }

    public function insert()
    {
        $link = getConnection();

        $query = "  INSERT
                    INTO   admin
                           (
                                  email           ,
                                  password
                           )
                           VALUES
                           (
                                  '" . $this->get_admin_email() . "'           ,
                                  '" . $this->get_admin_password() . "'
                           )";

        executeUpdateQuery($link, $query);

        $admin_id = mysql_insert_id($link);
        $this->set_admin_id($admin_id);
        closeConnection($link);

    }

    public function updatePassword($new_password)
    {
        $link = getConnection();
        $query = " UPDATE admin
               SET    password = '" . $new_password . "'
               WHERE  admin_id = " . $this->get_admin_id();

        $result = executeUpdateQuery($link, $query);
        closeConnection($link);
        return $result;
    }

    public function delete()
    {
        //delete admin account
        $link = getConnection();
        $query = " UPDATE admin
                   SET    active = 'N'
                   WHERE  admin_id = " . $this->get_admin_id();
        executeUpdateQuery($link, $query);
        closeConnection($link);
    }

}
?>
