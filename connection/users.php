<?
include_once('Crypt.php');
include_once('Conn.php');

Class Users {
    private $tbl;
    public function __construct() {
        $this->tbl = "users";
    }

    public function login($params) {
        $conn = new Conn();
        $queries = $params['queries'];
        $users = $conn->getArrays(['segs'=>['users']]);
        $users = json_decode($users, true);
        $result = ['code'=>404, 'msg'=>'Login fail'];

        // TODO: search for specific user
        foreach ($users['records'] as $u) {
            if ($u['fields']['account'] === $queries['account'] && $u['fields']['password'] === $queries['password']) {
                $user = $u;
                break;
            }
        }
        if(isset($user)) {
            $sess = $this->genSess($user['id'], $user['fields']['account']);
            $result = ['code'=>200, 'data'=>['sess'=>$sess,
                                             'username'=>$user['fields']['username'],
                                             'id'=>$user['id']]];
        }
        return json_encode($result);
    }

    public function checkUserSess($sess) {
        $content = $this->decodeSess($sess);
    }

    public function genSess($item_id, $username) {
        $this->crypt = new Crypt();
        $date = date("Y-m-d", time());
        $day = date("Y-m-d", strtotime("$date + 1 day"));
        $encrypt = $this->crypt->encrypt(implode('@@', [$item_id, $day, $username]));
        return $encrypt;
    }

    public function decodeSess($sess) {
        $this->crypt = new Crypt();
        $arr_crypet = explode("@@", $this->crypt->decrypt($sess));

        $info = [
            'id' => $arr_crypet[0],
            'expire_date' => $arr_crypet[1],
            'username' => $arr_crypet[2]
        ];
        return $info;
    }
}
