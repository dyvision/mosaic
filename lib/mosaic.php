<?php

namespace mosaic {

    use Exception;

    class auth //done
    {
        function __construct()
        {
            return;
        }
        //Function to authorize users
        function authorize()
        {

            //set the parameters for what we're authorizing
            $params = [
                'client_id=8ef01039251f4b9a8a213ae17ef0e570',
                'response_type=code',
                'redirect_uri=https://dev.plumeware.com/mosaic/create.php?confirm',
                'scope=playlist-read-private%20playlist-read-collaborative%20user-top-read'
            ];

            //make it a string
            $authparams = implode('&', $params);

            //redirect url
            $url = "https://accounts.spotify.com/authorize?$authparams";

            //return the redirect action
            header("Location: $url");
        }
        //Function to get bearer token for users
        public static function authenticate($code, $type)
        {
            //set the url to the authenticate api
            $url = 'https://accounts.spotify.com/api/token';

            //set the parameters for what we're authorizing
            if ($type == 'authorization_code') {
                $params = [
                    "code=$code",
                    "grant_type=$type",
                    'redirect_uri=https://mosaic.paos.io/create.php'
                ];
            } else {
                $params = [
                    "refresh_token=$code",
                    "grant_type=$type",
                    'redirect_uri=https://mosaic.paos.io/create.php'
                ];
            }

            //make it a string
            $body = implode('&', $params);

            //get secret
            $secret = json_decode(file_get_contents('creds.json'), true);

            //build credentials for the actual system to authenticate with spotify
            $sysauth = base64_encode('8ef01039251f4b9a8a213ae17ef0e570' . ':' . $secret['secret']);

            //build authorization header
            $header = array(
                "Authorization: Basic $sysauth",
                'Content-Type: application/x-www-form-urlencoded'
            );

            //send the post request

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
        }
        //Function to see if the user actually exists
        function login($token, $refreshtoken)
        {

            //create auth header
            $context = stream_context_create([
                "http" => [
                    "header" => "Authorization: Bearer $token"
                ]
            ]);

            //return user info
            $user = json_decode(file_get_contents('https://api.spotify.com/v1/me', false, $context), true);

            setcookie('username', $user['id'],3600,'/');
            setcookie('refresh', $refreshtoken,3600,'/');
        }
        function verify($token)
        {

            //create auth header
            $context = stream_context_create([
                "http" => [
                    "header" => "Authorization: Bearer $token"
                ]
            ]);

            //return user info
            return file_get_contents('https://api.spotify.com/v1/me', false, $context);
        }
    }
    class playlist
    {
        function __construct()
        {
            return;
        }
        //Function that gets all collaborative playlists related to a person's account
        function get($token)
        {
        }
        //Function that will create a playlist for the new year, arguments should probably include how many songs to include from a playlist. For example: "top 5 songs from each list"
        function create($token)
        {
        }
    }
    class user //done
    {
        function __construct()
        {
            return;
        }
        //Function to pull all user tokens from our text database to use for interacting with spotify under their name
        function get()
        {
            return file_get_contents('/var/www/html/mosaic/tokens.json');
        }
        //Function to append a new user to that text database
        function create($id, $refreshtoken)
        {
            $found = 'no';
            $obj = [];
            $obj['username'] = $id;
            $obj['token'] = $refreshtoken;

            //open json array of tokens
            try {
                $tokens = json_decode(file_get_contents('tokens.json'), true);
                foreach ($tokens as $token) {
                    if ($token['username'] == $obj['username']) {
                        $found = 'yes';
                    } else {
                        
                    }
                }
                if ($found == 'yes') {
                } else {
                    array_push($tokens,$obj);
                    $file = fopen('tokens.json', 'w');
                    fwrite($file, json_encode($tokens));
                    fclose($file);
                    $result['message'] = 'Successfully added user';
                }
            } catch (Exception $e) {
                $obj = json_encode($obj);
                $file = fopen('tokens.json', 'w');
                fwrite($file, "['$obj']");
                fclose($file);
                $result['message'] = 'Create token file and added user';
                $result['error'] = $e->getMessage();
            }
            return json_encode($result);
        }
    }
    class top
    {
        function __construct()
        {
            return;
        }
        //Function that gets all collaborative playlists related to a person's account
        function get($token)
        {
            $result = array();

            //create auth header
            $context = stream_context_create([
                "http" => [
                    "header" => "Authorization: Bearer $token"
                ]
            ]);

            //start parsing for collabs
            $playlists = json_decode(file_get_contents('https://api.spotify.com/v1/me/top/tracks?time_range=short_term', false, $context), true);



            foreach ($playlists['items'] as $playlist) {
                $track['name'] = $playlist['name'];
                $track['link'] = $playlist['external_urls']['spotify'];
                array_push($result, $track);
            }
            return json_encode($result);
        }
    }
}
