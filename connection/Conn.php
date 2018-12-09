<?php
include('Configs.php');
class Conn
{
    private $ATkey;
    private $ATId;
    public function __construct()
    {
        $this->ATkey = Configs::AIR_TABLE_KEY;
        $this->ATId  = Configs::AIR_TABLE_APP_ID;
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

        return $result;
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
        return json_encode($response);
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
        return $result;
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
        $res = json_decode($file_contents, true);
        if (isset($res['offset'])) {
            return json_encode(['code'=>200, 'data'=>$res['records'], 'offset'=>$res['offset']]);
        } else {
            return json_encode(['code'=>200, 'data'=>$res['records']]);
        }
    }

    public function getUrl($params) {
        $segs = $params['segs'];
        if (count($segs)>1) {
            $url = "https://api.airtable.com/v0/".$this->ATId."/".$params['segs'][0]."/".$params['segs'][1];
        } else {
            $url = "https://api.airtable.com/v0/".$this->ATId."/".$params['segs'][0];
        }
        $url = $url."?api_key=".$this->ATkey;

        $queries = $params['queries'];
        if (isset($queries) && count($queries) >= 0) {
            foreach ($queries as $k => $v) {
                if ($k == 'sort') continue;
                $url.=('&'.$k.'='.$v);
            }
        }
        if(isset($queries['sort'])) {
            $url.=$queries['sort'];
        }
        return $url;
    }
}

new Conn();
 ?>
