<?php
include('Configs.php');
class Conn
{
    private $ATkey;
    private $ATId;
    public function __construct()
    {
        $this->ATkey = Configs::AIR_TABLE_KEY;
        $this->ATId = Configs::AIR_TABLE_APP_ID;
        // $this->getArrays(['model'=>'Voyager.com']);
        //postItem
        // $this->postItem(['model'=>'Voyager.com']);
        // updateItem
        // $this->updateItem(['id'=> 'recY6WuZuOcPTT2IW',
        //                    'model'=>'Voyager.com',
        //                    'queries'=>["fields"=>
        //                         ["Headline"=> "Voyager test"]]
        //                       ]);
        // deleteItem
        // $this->deleteItem(['model'=>'Voyager.com', 'id'=>'recY6WuZuOcPTT2IW']);
    }

    public function deleteItem($params) {
        $url = $this->getUrl($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        echo $result;
    }

    public function updateItem($params) {
        $data = $params['queries'];
        $id = $params['id'];
        unset($queries['id']);
        $data_string = json_encode($data);
        $url = $this->getUrl($params);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        /*'Authorization: The document shows the api key show be set in header, but it seems not work'*/)
        );

        $response = curl_exec($ch);
        if(!$response) {
            return false;
        }
        echo json_encode($response);
    }

    public function postItem($params) {
        $url = $this->getUrl($params);
        $queries = $params['queries'];
        $data['fields'] = $queries;
        $data['typecast'] = true;
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        echo $result;
    }

    public function getArrays($params) {
        $url = $this->getUrl($params);
        $ch = curl_init ();
        $timeout = 100; // set to zero for no timeout
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        $file_contents = curl_exec ( $ch );
        if (curl_errno ( $ch )) {
            echo curl_error ( $ch );
            curl_close ( $ch );
            exit ();
        }
        curl_close ( $ch );
        echo $file_contents;
    }

    public function getUrl($params) {
        if (isset($params['id'])) {
            $url = "https://api.airtable.com/v0/".$this->ATId."/".$params['model']."/".$params['id'];
        } else {
            $url = "https://api.airtable.com/v0/".$this->ATId."/".$params['model'];
        }
        $url = $url."?api_key=".$this->ATkey;
        return $url;
    }
}

new Conn();
 ?>
