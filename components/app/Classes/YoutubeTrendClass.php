<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;

class YoutubeTrendClass {

	public function get_data($lang, $country, $result)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $client = new Client();

                $client->setDeveloperKey($api_key->google_api_key);

                $youtube = new YouTube($client);

                $value = $youtube->videos->listVideos(['snippet', 'statistics'], array(
                    'chart'      => 'mostPopular',
                    'maxResults' => $result,
                    'regionCode' => $country,
                    'hl'         => $lang
                ));


                if( count($value['items']) != 0 ) {

                    $data = array();

                    for( $i = 0; $i < count($value['items']); $i++ ){  
                        $snippet = $value['items'][$i]['snippet'] ?? [];
                        $statistics = $value['items'][$i]['statistics'] ?? [];
                        $thumbs = $snippet['thumbnails'] ?? [];

                        // Prefer sharp medium or high thumbnail over blurry default (120x90)
                        $thumbnail = $thumbs['high']['url'] ?? $thumbs['medium']['url'] ?? $thumbs['standard']['url'] ?? $thumbs['default']['url'] ?? '';

                        $data[$i]['thumbnail']    = $thumbnail;
                        $data[$i]['title']        = $snippet['title'] ?? '';
                        $data[$i]['link']         = 'https://youtu.be/' . ($value['items'][$i]['id'] ?? '');
                        $data[$i]['channelTitle'] = $snippet['channelTitle'] ?? '';
                        $data[$i]['publishedAt']  = $snippet['publishedAt'] ?? '';
                        $data[$i]['viewCount']    = isset($statistics['viewCount']) ? (int) $statistics['viewCount'] : null;
                        $data[$i]['likeCount']    = isset($statistics['likeCount']) ? (int) $statistics['likeCount'] : null;

                        $data[$i]['tags'] = array();
                        array_push($data[$i]['tags'], $snippet['tags'] ?? []);
                    }
                    return $data;
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }

                return $data;
                
            } catch (\Exception $e) {

                session()->flash('status', 'error');
                session()->flash('message', __($e->getMessage()));
                return;
            }

        } else{

            session()->flash('status', 'error');
            session()->flash('message', 'Invalid API Keys!');
            return;
        }
	}
    //

}