<?
include_once('Conn.php');

Class Announcement {
    private $tbl;
    public function __construct() {
        $this->tbl = "users";
    }
    public function homepage($params) {
        $conn = new Conn();
        $events = $conn->getArrays(['segs'=>['events']]);

        $events = json_decode($events, true);
        return $event;
        // $result = ['code'=>404, 'msg'=>'Login failed'];
        //
        // foreach ($users['data'] as $u) {
        //     if ($u['fields']['account'] === $queries['account'] && $u['fields']['password'] === $queries['password']) {
        //         $user = $u;
        //         break;
        //     }
        // }
    }
}
