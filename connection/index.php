<?
include_once('Conn.php');
include_once('users.php');

$r = serializeURL();

if ($_SERVER['REQUEST_METHOD'] === "POST" || $_SERVER['REQUEST_METHOD'] === "PUT") {
    $r['params'] = extractParameters();
}

// Check session
$user = new Users();
if ($r['segs'][0] == 'users' && $r['segs'][1] == 'login') {
    echo $user->login($r);
    return;
} else {
    $decode = $user->decodeSess($r['queries']['sess']);
    if (!isset($decode)) {
        echo json_encode(['code'=>500, 'msg'=>'Missing session or expired.']);
        return;
    } else {
        $today = date("Y-m-d", time());
        $today = date("Y-m-d", strtotime("$today + 1 day"));
        $sess_date = date("Y-m-d", strtotime($decode['expire_date']));
        if ($today != $sess_date) {
            echo json_encode(['code'=>500, 'msg'=>'Missing session or expired.', 'debug'=>[$sess_date, $today]]);
            return;
        }
    }
}

$conn = new Conn();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo $conn->getArrays($r);
        // echo $conn->getUrl($r);
        break;
    case 'PUT':
        echo $conn->updateItem($r);
        break;
    case 'POST':
        echo $conn->postItem($r);
        break;
    case 'DELETE':
        echo $conn->deleteItem($r);
        break;
    default:
        echo 'cannot handle this kind of request!';
        break;
}

function serializeURL() {
    $url = $_SERVER['REQUEST_URI'];
    $idx = strpos($url, "index.php");
    $str = substr($url, $idx + 10);
    $t = explode('?',$str);
    $segs = explode('/', $t[0]);
    parse_str($t[1], $params);
    return ['queries'=>$params, 'segs'=>$segs];
}

function extractParameters() {
    $target = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target = $_POST;
    } else {
        parse_str(file_get_contents("php://input"),$target);
    }
    foreach ($target as $key => $value) {
        $res[$key] = $value;
    }
    return $res;
}
