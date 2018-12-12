<?
include_once('Conn.php');
require_once('EmbedYoutubeLiveStreaming.php');
require_once('Configs.php');

Class Announcement {
    private $tbl;
    public function __construct() {
        $this->tbl = "users";
    }
    public function homepage($params) {
        $conn = new Conn();

        $YouTubeLive = new EmbedYoutubeLiveStreaming(Configs::CHANNEL_ID,Configs::YOUTUBE_API_KEY);
        $result['code'] = 200;
        $result['data']['announcement'] = [];
        $result['data']['streaming'] = [];
        $events = $conn->getArrays(['segs'=>['events'], 'queries'=>['sort'=> '&sort%5B0%5D%5Bfield%5D=event_id&sort%5B0%5D%5Bdirection%5D=desc']]);
        $events = json_decode($events, true);
        if (isset($events['data']) && count($events['data']) > 0) {
            $result['data']['announcement'] = $events['data'];
        }

        if ($YouTubeLive->isLive) {
            $streaming['title'] = $YouTubeLive->live_video_title;
            $streaming['desc'] = $YouTubeLive->live_video_description;
            $streaming['video_id'] = $YouTubeLive->live_video_id;
            $streaming['published_at'] = $YouTubeLive->live_video_published_at;
            $streaming['channel_title'] = $YouTubeLive->channel_title;
            $streaming['video_id'] = $YouTubeLive->live_video_id;
            $result['data']['streaming'] = $streaming;
        }

        return json_encode($result);
    }
}
