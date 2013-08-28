<?php
namespace includes\classes;

class Client
{
    private $client_id;

    private $email;
    private $password;

    private $firstname;
    private $lastname;

    private $telephone;
    private $mobile;
    private $address_1;
    private $address_2;
    private $postcode;
    private $city;
    private $country;

    private $currency;
    private $balance;
    private $margin;

    private $active;

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
    }

    public function getAddress1()
    {
        return $this->address_1;
    }

    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
    }

    public function getAddress2()
    {
        return $this->address_2;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getFullName(){
        return $this->getFirstname() . " " .$this->getLastname();
    }

    public function setMargin($margin)
    {
        $this->margin = $margin;
    }

    public function getMargin()
    {
        return $this->margin;
    }

    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function loadByID($id)
    {
        $link = getConnection();
        $query = " select    client_id,
                              email,
                              firstname,
                              lastname,
                              password,
                              telephone,
                              mobile,
                              add_1,
                              add_2,
                              postcode,
                              city,
                              country,
                              currency,
                              balance,
                              margin,
                              active
                    from    client
                    where   client_id =  '" . $id. "'";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $this->setClientId($newArray['client_id']);
            $this->setEmail($newArray['email']);
            $this->setFirstname($newArray['firstname']);
            $this->setLastname($newArray['lastname']);
            $this->setPassword($newArray['password']);
            $this->setTelephone($newArray['telephone']);
            $this->setMobile($newArray['mobile']);
            $this->setAddress1($newArray['add_1']);
            $this->setAddress2($newArray['add_2']);
            $this->setPostcode($newArray['postcode']);
            $this->setCity($newArray['city']);
            $this->setCountry($newArray['country']);
            $this->setCurrency($newArray['currency']);
            $this->setBalance($newArray['balance']);
            $this->setMargin($newArray['margin']);
            $this->setActive($newArray['active']);
        }
    }

    public function loadByEmail($email)
    {
        $link = getConnection();
        $query = " select    client_id,
                              email,
                              firstname,
                              lastname,
                              password,
                              telephone,
                              mobile,
                              add_1,
                              add_2,
                              postcode,
                              city,
                              country,
                              currency,
                              balance,
                              margin,
                              active
                    from    client
                    where   email =  '" . $email."'";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $this->setClientId($newArray['client_id']);
            $this->setEmail($newArray['email']);
            $this->setFirstname($newArray['firstname']);
            $this->setLastname($newArray['lastname']);
            $this->setPassword($newArray['password']);
            $this->setTelephone($newArray['telephone']);
            $this->setMobile($newArray['mobile']);
            $this->setAddress1($newArray['add_1']);
            $this->setAddress2($newArray['add_2']);
            $this->setPostcode($newArray['postcode']);
            $this->setCity($newArray['city']);
            $this->setCountry($newArray['country']);
            $this->setCurrency($newArray['currency']);
            $this->setBalance($newArray['balance']);
            $this->setMargin($newArray['margin']);
            $this->setActive($newArray['active']);
        }
    }

    public function insert()
    {
        $link = getConnection();

        $query = "INSERT INTO client
                            (client_id,
                             email,
                             firstname,
                             lastname,
                             password,
                             telephone,
                             mobile,
                             add_1,
                             add_2,
                             postcode,
                             city,
                             country,
                             currency,
                             margin,
                             active)
                        VALUES ('" . $this->getClientId() . "',
                                '" . $this->getEmail() . "',
                                '" . $this->getFirstname() . "',
                                '" . $this->getLastname() . "',
                                '" . $this->getPassword() . "',
                                '" . $this->getTelephone() . "',
                                '" . $this->getMobile() . "',
                                '" . $this->getAddress1() . "',
                                '" . $this->getAddress2() . "',
                                '" . $this->getPostcode() . "',
                                '" . $this->getCity() . "',
                                '" . $this->getCountry() . "',
                                '" . $this->getCurrency() . "',
                                " . $this->getMargin() . ",
                                'Y')";

        executeUpdateQuery($link, $query);

        $client_id = mysql_insert_id($link);
        $this->setClientId($client_id);
        closeConnection($link);
    }

    public function updatePassword($new_password)
    {
        $link = getConnection();
        $query = " UPDATE client
               SET    password = '" . $new_password . "'
               WHERE  client_id = '" . $this->getClientId()."'";

        $result = executeUpdateQuery($link, $query);
        closeConnection($link);
        return $result;
    }

    public function updateStatus($is_active = "N")
    {
        $link = getConnection();
        $query = " UPDATE client
                   SET    active = '" . $is_active . "'
                   WHERE  client_id = '" . $this->getClientId()."'";
        executeUpdateQuery($link, $query);
        closeConnection($link);
    }

    public function updateMargin($margin)
    {
        $link = getConnection();
        $query = " UPDATE client
                   SET    margin = " . $margin . "
                   WHERE  client_id = '" . $this->getClientId()."'";
        executeUpdateQuery($link, $query);
        closeConnection($link);
    }

    public function updateBalance(){
        $charge = 0.0;
        $payment_amount = 0.0;
        $balance = 0.0;
        $link = getConnection();

        // get the total charge
        $query1 = " SELECT SUM(charge) as charge FROM call_log WHERE call_log.client_id = '" . $this->getClientId()."'";
        $result = executeNonUpdateQuery($link, $query1);
        $newArray = mysql_fetch_array($result);
        $charge =   floatval($newArray["charge"]);

        //get the total payment amount
        $query2 = " SELECT SUM(amount) as payment_amount FROM payment WHERE payment.client_id = '" . $this->getClientId()."'";
        $result = executeNonUpdateQuery($link, $query2);
        $newArray = mysql_fetch_array($result);
        $payment_amount =   floatval($newArray["payment_amount"]);

        // now you have the balance
        $balance = $payment_amount - $charge;

        //finally, update the database
        $query3 = " UPDATE client SET balance = ".$balance." WHERE client_id = '" . $this->getClientId()."'";
        executeUpdateQuery($link, $query3);
        closeConnection($link);
    }

    public function updateClientDetail(){
        $link = getConnection();
        $query = " UPDATE client
                   SET   email = '".$this->getEmail()."',
                         firstname = '".$this->getFirstname()."',
                         lastname = '".$this->getLastname()."',
                         telephone = '".$this->getTelephone()."',
                         mobile = '".$this->getMobile()."',
                         add_1 = '".$this->getAddress1()."',
                         add_2 = '".$this->getAddress2()."',
                         postcode = '".$this->getPostcode()."',
                         city = '".$this->getCity()."',
                         country = '".$this->getCountry()."',
                         currency = '".$this->getCurrency()."',
                         active = '" . $this->getActive() . "',
                         margin = " . $this->getMargin() . "
                   WHERE  client_id = '" . $this->getClientId()."'";
        executeUpdateQuery($link, $query);
        closeConnection($link);
    }


}