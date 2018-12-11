<?
include_once('Conn.php');
require_once('Configs.php');

Class Subscribers {

    public function newUser($params) {
        $conn = new Conn();
        $newSubscriber = $conn->postItem($params);
        return $newSubscriber;
        // $this->sendMail(array("eden.sung25@gmail.com" => "Sung"));
        // return "newUser";
    }

}
