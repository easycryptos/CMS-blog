<?php

namespace YuzuruS\Rss;

use Embed\Embed;

/**
 * Feed
 *
 * @author Yuzuru Suzuki <navitima@gmail.com>
 * @license MIT
 */
class Feed
{
    public static $timezone = 'America/New_York';

    /**
     * Loads RSS or Atom feed
     * @param $url
     * @param null $ua
     * @param null $user
     * @param null $pass
     * @return array
     */
    public static function load($url, $ua = NULL, $getImg = false, $user = NULL, $pass = NULL)
    {
        $data = [];
        try {
            $rss = self::loadXml($url, $ua, $user, $pass);
        } catch (\Exception $e) {
            error_log($e->getMessage() . "\n");
            return [];
        }

        // set channel
        if (isset($rss->channel->title)) {
            $data['channel'] = [
                'title' => (string)$rss->channel->title,
                'link' => (string)$rss->channel->link,
            ];
        } else {
            $data['channel'] = [
                'title' => (string)$rss->title,
                'link' => (string)$rss->link['href'],
            ];
        }

        switch (strtolower($rss->getName())) {
            case 'rdf': // rss1.0
                $data['item'] = self::getItemsFromRdf($rss, $getImg);
                break;
            case 'rss': // rss2.0
                $data['item'] = self::getItemsFromRss($rss, $getImg);
                break;
            case 'feed': // atom
                $data['item'] = self::getItemsFromAtom($rss, $getImg);
                break;
        }
        return $data;
    }

    /**
     * Get items from rdf
     * @param $rss
     * @return array
     */
    private static function getItemsFromRdf($rss, $getImg)
    {
        $data = [];
        foreach ($rss->item as $item) {
            // title
            $tmp['title'] = mb_convert_encoding((string)$item->title, 'UTF-8', 'auto');

            // link
            $tmp['link'] = (string)($item->link);

            // date
            $date = (string)$item->children('http://purl.org/dc/elements/1.1/')->date;
            $dt = new \DateTime($date);
            $dt->setTimeZone(new \DateTimeZone(self::$timezone));
            $tmp['date'] = $dt->format('Y-m-d H:i:s');

            // description
            $tmp['description'] = mb_convert_encoding((string)$item->description, 'UTF-8', 'auto');

            // image
            if ($getImg === true) {
                $content = (string)$item->children('http://purl.org/rss/1.0/modules/content/')->encoded;
                if ($image = self::getImgs($tmp['link'], $content)) {
                    $tmp['image'] = $image;
                }
            }
            $data[] = $tmp;
        }
        return $data;
    }

    /**
     * Get items from rss
     * @param $rss
     * @return array
     */
    private static function getItemsFromRss($rss, $getImg)
    {
        $data = [];

        foreach ($rss->channel->item as $item) {
            // title
            $tmp['title'] = mb_convert_encoding((string)$item->title, 'UTF-8', 'auto');

            // link
            $tmp['link'] = (string)$item->link;

            // date
            $date = (string)$item->pubDate;
            $dt = new \DateTime($date);
            $dt->setTimeZone(new \DateTimeZone(self::$timezone));
            $tmp['date'] = $dt->format('Y-m-d H:i:s');

            // description
            $tmp['description'] = mb_convert_encoding((string)$item->description, 'UTF-8', 'auto');
            $tmp['content'] = mb_convert_encoding((string)$item->content, 'UTF-8', 'auto');
            if (empty($tmp['content'])) {
                $tmp['content'] = $tmp['description'];
                $tmp['description'] = "";
            }

            $data[] = $tmp;
        }


        return $data;
    }


    /**
     * Get items from atom
     * @param $rss
     * @return array
     */
    private static function getItemsFromAtom($rss, $getImg)
    {
        $data = [];
        foreach ($rss->entry as $entry) {
            // title
            $tmp['title'] = mb_convert_encoding((string)$entry->title, 'UTF-8', 'auto');

            // link
            $tmp['link'] = (string)$entry->link['href'];

            //image
            $tmp['image'] = @$item->enclosure->attributes()->url;

            // date
            if (isset($entry->issued)) {
                $date = (string)$entry->issued;
            } else {
                $date = (string)$entry->published;
            }
            $dt = new \DateTime($date);
            $dt->setTimeZone(new \DateTimeZone(self::$timezone));
            $tmp['date'] = $dt->format('Y-m-d H:i:s');

            // description
            $tmp['description'] = mb_convert_encoding((string)$entry->summary, 'UTF-8', 'auto');
            $tmp['content'] = mb_convert_encoding((string)$entry->content, 'UTF-8', 'auto');
            $data[] = $tmp;
        }
        return $data;
    }

    /**
     * Get images from url or text
     * @param $url
     * @param string $text
     * @return bool
     */
    private static function getImgs($url, $text = '')
    {
        $img = [];
        //get a image from og:img
        if ($imgUrl = self::getImgFromOg($url)) {
            $img['ogimg'] = $imgUrl;
        }

        // get images from description text
        if ($imgUrls = self::getImgFromText($text)) {
            $img['img'] = $imgUrls;
        }
        return $img;
    }

    /**
     * Get a image from og:img
     * @param $url
     * @return array|bool
     */
    public static function getImgFromOg($url)
    {
        $info = Embed::create($url);
        if (!empty($info)) {
            return $info->image;
        }

    }

    /**
     * Get images from text
     * @param $text
     * @return array|bool
     */
    public static function getImgFromText($text)
    {
        preg_match_all('/<img.*?src=(["\'])(.+?)\1.*?>/i', $text, $res);
        if (empty($res[2][0])) {
            return false;
        }
        return $res[2];
    }

    /**
     * @param $url
     * @param $ua
     * @param $user
     * @param $pass
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    private static function loadXml($url, $ua, $user, $pass)
    {
        $data = trim(self::httpRequest($url, $ua, $user, $pass));

        if (empty($data)) {
            $ci =& get_instance();
            $ci->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_added"));
            redirect($ci->agent->referrer());
        } else {
            return new \SimpleXMLElement($data, LIBXML_NOWARNING | LIBXML_NOERROR);
        }

    }

    /**
     * Process HTTP request.
     * @param  string
     * @param  string
     * @param  string
     * @param  string
     * @return string|FALSE
     * @throws \Exception
     */
    public static function httpRequest($url, $ua, $user, $pass)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($user !== NULL || $pass !== NULL) {
            curl_setopt($curl, CURLOPT_USERPWD, "$user:$pass");
        }
        if ($ua !== NULL) {
            curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        }
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); // no echo, just return result
        if (!ini_get('open_basedir')) {
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); // sometime is useful :)
        }
        $result = curl_exec($curl);
        return curl_errno($curl) === 0 && curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200
            ? $result
            : FALSE;
    }
}
