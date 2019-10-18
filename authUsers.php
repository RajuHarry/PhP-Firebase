<?php
require 'includes/vendor/autoload.php';
include("includes/db.php");
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

$apiKey = 'AIzaSyAvMxsiSoT1O84Eowr158422FN3tkHF94I';

$client = new Client([
    'http_errors' => false,
]);

$headers = ['Content-Type' => 'application/json'];

$signUpRequest = static function ($email, $password) use ($apiKey, $headers): Request {
    $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signUp?key='.$apiKey;
    $body = json_encode(['email' => $email, 'password' => $password, 'returnSecureToken' => true]);

    return new Request('POST', $url, $headers, $body);
};

$signInRequest = static function ($email, $password) use ($apiKey, $headers): Request {
    $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key='.$apiKey;
    $body = json_encode(['email' => $email, 'password' => $password, 'returnSecureToken' => true]);

    return new Request('POST', $url, $headers, $body);
};

$printResponseData = static function (ResponseInterface $response)
{
    echo json_encode(json_decode((string) $response->getBody(), true), JSON_PRETTY_PRINT);
};

$getIdTokenFromResponse = static function (ResponseInterface $response): string
{
    return json_decode((string) $response->getBody(), true)['idToken'];
};

//$email = 'php@firebase.com';
//$password = 'firebase@php';
$email = $_POST['emailSignin'];
$password = $_POST['passSignin'];

// Signing up only works the first time
// $printResponseData($client->send($signUpRequest($email, $password)));

echo $user = $getIdTokenFromResponse($client->send($signInRequest($email, $password)));
if($user){
        session_start();
        $_SESSION['user'] = true;
        header("Location:home.php");
    }
	else{
		header("Location:index.php");		
	}
?>