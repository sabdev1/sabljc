<?php

/** 
 * SHow info
 * name
 * bio
 * website
 * followers
 * following
 * profile_pic
 * instagram page
*/
function crInstShowInfo( $data, $args=array(), $width="150" ) {
	
    $infos = '<div class="instagram-autor">';

	# Author photo
    if ($args['profile_pic'] == true && isset($data['data']['profile_picture']) && !empty($data['data']['profile_picture'])):
        $infos .=
			'<a href="http://instagram.com/'.$data['data']['username'].'/">'.
				'<img src="' . $data['data']['profile_picture'] . '" alt="" />'.
			'</a>';
    endif;
	
	# Stat Info
    $infos .= '<div class="instagram-stat">';

    if ($args['media'] == true):
        $infos .= '<span class="inst-photos"><span class="numb">' . $data['data']['counts']['media'] . '</span><span class="diopinfo">' . __('photos', 'crum') . '</span></span>';
    endif;

    if ($args['followers'] == true):
        $infos .= '<span class="inst-follower"><span class="numb">' . $data['data']['counts']['followed_by'] . '</span><span class="diopinfo">' . __('followers', 'crum') . '</span></span>';
    endif;

    if ($args['following'] == true):
        $infos .= '<span class="inst-follow"><span class="numb">' . $data['data']['counts']['follows'] . '</span><span class="diopinfo">' . __('follows', 'crum') . '</span></span>';
    endif;

    $infos .= '</div>';

//    if( $args['name'] == true ):
//        $infos .= '<span class="box-name">' . $data['data']['full_name'] . '</span>'; 
//    endif;

//    if( $args['bio'] == true ):
//        $infos .= '<span class="diopinfo">' . $data['data']['bio'] . '</span>';
//    endif;

    $infos .= '</div>';

	echo $infos;
}

/**
* Get self feed
*/
function crInstGetSelfFeed( $access_token )
{
	$apiurl = "https://api.instagram.com/v1/users/self/feed?access_token=" . $access_token ;
	
	if(function_exists('curl_exec') && function_exists('curl_init')):
	
          	$curl = curl_init();               
                curl_setopt($curl, CURLOPT_URL, $apiurl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);               
                $response = curl_exec($curl);               
                curl_close($curl);
               
                $data = json_decode( $response, true );
        else:
                $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
		        $data = json_decode( $response['body'], true );
        endif;
       	
		if (!file_exists(crum_simple_instagram_plugin_path . 'cache-api')) {
			if (!mkdir(crum_simple_instagram_plugin_path . 'cache-api'))
				return $data;
		}
		
       	file_put_contents( crum_simple_instagram_plugin_path . 'cache-api/selffeed.txt', serialize($data) );
	
	return $data;
}

/**
 * Show data in widget form
 */
function crInstShowWidgetData( $data, $data_info, $count=4, $width, $customRel="sIntWidget", $displayCaption="true" ) {
	/**
	 * Determine query return
	 * next query used to avoid
	 * blank return when display value is 
	 * greater than API return
	*/
	
	if (!isset($data['data']))
		return;
	
	if( count( $data['data'] ) > $count ):
		$query = $count;
	else:
		$query = count( $data['data'] );
	endif;

    echo '<div class="intagram-gallery">';

	//$infos .= '<div class="box-name">' .  . '</div>'; 
	$full_name = $data_info['data']['full_name'];
	$username = $data_info['data']['username'];
	$username = '<a href="http://instagram.com/'.$username.'/">@'.$username.'</a>';
	
	$add_image = '';
	if ($query>0) {
		$src = crInstCache( $data['data'][0]['images']['thumbnail']['url'], $width );
		$add_image = '<img class="front-photo" src="'. $src .'" alt="" />';
	}
	echo '<span class="item">'.$add_image.'<span class="item-authorinfo"><span><span>'.$username.''.$full_name.'</span></span></span></span>';
	
 	for ($i = 0; $i < $query; $i++) {

		$output = '<div class="item"><a href="' . $data['data'][$i]['images']['standard_resolution']['url'] . '" data-rel="' . $customRel . '[instagram]" title="' . htmlspecialchars( $data['data'][$i]['caption']['text'], ENT_QUOTES ). '">';

		$output .= '<div class="si-content" style=" display: none; margin: 10px; "><div class="clear"></div>';

		/**
		 * Option to display caption.
		 * Page often breaks when caption is to long
		 * because prettyPhot can't handle it.
		 */
		if($displayCaption == "true") {
			$output .= htmlspecialchars( $data['data'][$i]['caption']['text'], ENT_QUOTES ). '<div class="clear"></div>';
		}

		if (isset($data['data'][$i]['caption']['from']['profile_picture']) && !empty($data['data'][$i]['caption']['from']['profile_picture'])) {
			$img_profile_pic = '<img class="front-photo" src="' . $data['data'][$i]['caption']['from']['profile_picture'] . '" width="15" height="15" alt=""/>';
		} else {
			$img_profile_pic = '';
		}
		
		$output .= '<div class="content-info">'. $img_profile_pic . $data['data'][$i]['caption']['from']['username'] . '</div>';
		//$output .= '<div class="content-info"><img src="' . plugins_url('/crum-instagram/images/instagram-like.png') . '" width="19" height="19" style="vertical-align: middle;" alt="" /> ' . $data['data'][$i]['likes']['count'] . '</div>';
		//$output .= '<div class="content-info"><img src="' . plugins_url('/crum-instagram/images/instagram-comment.png') . '" width="19" height="19" style="vertical-align: middle;" alt="" /> ' . $data['data'][$i]['comments']['count'] . '</div>';
		$output .= '<div class="clear"></div></div>';

		$output .= '<img class="front-photo" src="' . crInstCache( $data['data'][$i]['images']['thumbnail']['url'], $width ) . '" title="' . $data['data'][$i]['caption']['text'] . '" alt="" />';
		$output .= "</a></div>";

        echo $output;
	}
	
    echo '</div>';
}
/**
 * Check if access token exist
 * return null otherwise
 */
function access_token()
{
    global $wpdb;

    $getAccessToken = get_option('si_access_token');
    if( $getAccessToken ):
        return $getAccessToken;
    else:
        return null;
    endif;
}

/**
 * Check if user_is exist
 * return null otherwise
 */
function user_id()
{
    global $wpdb;

    $getUserID = get_option('si_user_id');
    if( $getUserID ):
        return $getUserID;
    else:
        return null;
    endif;
}

/**
 * Get the list of users this user follows.
 */
function crInstGetFollowing( $user_id, $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/" . $user_id . "/follows?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}


/**
 * Get the list of users this user is followed by.
 */
function crInstGetFollowers( $user_id, $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/" . $user_id . "/followed-by?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}

/**
 * See the authenticated user's list of media they've liked.
 * Note that this list is ordered by the order in which the user liked the media.
 * Private media is returned as long as the authenticated user has permission to view that media.
 * Liked media lists are only available for the currently authenticated user.
 */
function crInstGetLikes( $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/self/media/liked?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}

/**
 * Get the most recent media published by a user.
 */
function crInstGetRecentMedia( $user_id, $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/" . $user_id . "/media/recent/?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}

/**
 * See the authenticated user's feed.
 */
function simply_instagram_get_feed( $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/self/feed?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}

/**
 * Get basic information about a user.
 */
function crInstGetInfo( $user_id, $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/" . $user_id . "/?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}

/**
 * most-popular.
 */
function crInstGetMostPopular( $media, $access_token )
{
    $apiurl = "https://api.instagram.com/v1/media/" . $media . "?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;
	
	if (!file_exists(crum_simple_instagram_plugin_path . 'cache-api')) {
		if (!mkdir(crum_simple_instagram_plugin_path . 'cache-api'))
			return $data;
	}

    file_put_contents( simply_instagram_plugin_path . '/cache-api/selffeed.txt', serialize( $response )  );
    return $data;
}

/**
 * Check if already following
 */
function crInstGetFollowingInfo( $user_id, $access_token )
{
    $apiurl = "https://api.instagram.com/v1/users/" . $user_id . "/relationship?access_token=" . $access_token;

    if(function_exists('curl_exec') && function_exists('curl_init')):

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode( $response, true );
    else:
        $response = wp_remote_get( $apiurl, array('timeout' => 20 ) );
        $data = json_decode( $response['body'], true );
    endif;


    return $data;
}


/**
 * Function login to instagram for wp-administrator
 */
function crInstLogin( $return_uri )
{
    $baseURL = "https://api.instagram.com/oauth/authorize/";
    $client_id = "39170cdd8ebf4a159f01fdfd31b989b8";
    $redirect_uri = "http://www.rollybueno.info/plugins/simply-instagram.php";
    $response = "code";
    $scope = "likes+comments+relationships+likes";

    return $baseURL . '?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . $return_uri . '&response_type=' . $response . '&scope=' . $scope ;
}


/** Caching module */
function crInstCache( $image, $width ){
    return $image;
}

/** Clearing cache folder */
function sIntClearCache(){
    $path = simply_instagram_plugin_path . "cache/";

    foreach(glob($path ."*.*") as $file) {
        unlink($file); // Delete each file through the loop
    }
}
