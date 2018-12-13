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
        $data['fields'] = $params['queries'];
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
            'Content-Length: ' . strlen($data_string)
        /*'Authorization: The document shows the api key show be set in header, but it seems not work'*/)
        );
        $result = curl_exec($ch);
        if($result) {
            $res = ['code'=>200, 'data'=>json_decode($result)];
        }
        return json_encode($res);
    }

    public function postItem($params) {
        $url = $this->getUrl($params);
        $queries = $params['queries'];
        $data['fields'] = $queries;
        $data['typecast'] = true;
        // return json_encode($params);
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
        if($result) {
            $res = ['code'=>200, 'data'=>json_decode($result)];
        }

        if ($params['segs'][0] == 'subscribers') {
            $this->sendMail(array($queries['subscriber_email'] => $queries['subscriber_name']));
        }
        return json_encode($res);
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
        } else {
            $url = $url."&sort%5B0%5D%5Bfield%5D=".substr($segs[0], 0, -1)."_id&sort%5B0%5D%5Bdirection%5D=desc";
        }
        return $url;
    }

    public function sendMail($to) {
        require_once './vendor/autoload.php';

        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', '465', 'ssl')
            ->setUsername(Configs::SERVER_MAIL_ACCOUNT)
            ->setPassword(Configs::SERVER_MAIL_PASSWORD);

            $mailer = Swift_Mailer::newInstance($transport);

            $content = file_get_contents("./e-mail.html");
            // $msg = str_replace('%USERLOGIN%', $message, $content);

            $message_code = Swift_Message::newInstance("Thanks for subscribing open-lab", '', 'text/html', 'base64')
            ->setFrom(array(Configs::SERVER_MAIL_FROM => Configs::SERVER_MAIL_FROM_NAME))
            ->setSender(Configs::SERVER_MAIL_SEND, Configs::SERVER_MAIL_SEND_NAME)
            ->setTo($to)
            ->setCharset("utf-8")
            ->setBody($content, 'text/html')
            ->setReplyTo(Configs::SERVER_MAIL_REPLYTO, Configs::SERVER_MAIL_REPLYTO_NAME);

            $result =  $mailer->send($message_code);
    }
}

new Conn();
 ?>
