<?php


namespace App\Services\Google;


use Google\Service\AndroidPublisher;
use Google\Service\FirebaseCloudMessaging;
use Google_Client;
use Google_Service_AndroidPublisher;
use Illuminate\Support\Facades\Log;

class GoogleService
{
    public function getSubscriptionDetail(string $packageName, string $subscriptionId, string $purchaseToken): mixed
    {
        $configFile = __DIR__ . '/digital-dealership-64af9-97ba515c638b.json';

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $configFile);

        $client = new Google_Client();
        $client->addScope(AndroidPublisher::ANDROIDPUBLISHER);
        $client->useApplicationDefaultCredentials();
        $client->fetchAccessTokenWithAssertion();

        $authorization  = 'Authorization: Bearer ' . $client->getAccessToken()['access_token'];

        $url            = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/$packageName/purchases/subscriptions/$subscriptionId/tokens/$purchaseToken";
        $ch             = curl_init();
        curl_setopt($ch, CURLOPT_URL,           $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }
    public function getOneTimeProductPurchaseDetail(string $packageName, string $productId, string $purchaseToken): mixed
    {
        $configFile = __DIR__ . '/story-mii-415107-629a5eab64fb.json';

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $configFile);

        $client = new Google_Client();
        $client->addScope(AndroidPublisher::ANDROIDPUBLISHER);
        $client->useApplicationDefaultCredentials();
        $client->fetchAccessTokenWithAssertion();

        $authorization  = 'Authorization: Bearer ' . $client->getAccessToken()['access_token'];

        $url            = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/$packageName/purchases/products/$productId/tokens/$purchaseToken";

        $ch             = curl_init();
        curl_setopt($ch, CURLOPT_URL,           $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }
    public function v3(): void
    {
        $client_id = '';    //Your client id
        $service_account_name = '';  //Your service account email
        $key_file_location = ''; //Your p12 file (key.p12)

        $client = new Google_Client();
        $client->setApplicationName(""); //This is the name of the linked application
        $service = new Google_Service_AndroidPublisher($client);

        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials(
            $service_account_name,
            array('https://www.googleapis.com/auth/androidpublisher'),
            $key
        );
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $apiKey = ""; //Your API key
        $client->setDeveloperKey($apiKey);

        $package_name = ""; //Your package name (com.example...)
        $subscriptionId = "";   //SKU of your subscription item

        //Token returned to the app after the purchase
        $token = "";

        $service = new Google_Service_AndroidPublisher($client);
        $results = $service->purchases_subscriptions->get($package_name, $subscriptionId, $token, array());

        print_r($results); //This object has all the data about the subscription
        echo "expiration: " . $results->expiryTimeMillis;
    }

    public function getAccessToken()
    {
        $configFile = __DIR__.'/story-mii-1d033c76af49.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$configFile);
        $client = new Google_Client();
        $client->addScope(FirebaseCloudMessaging::FIREBASE_MESSAGING);
        $client->useApplicationDefaultCredentials();
        $client->fetchAccessTokenWithAssertion();
        //Log::info($client->);
        if(!isset($client->getAccessToken()['access_token'])){
            throw new \Exception('Unable to get access token from google cloud');
        }
        return $client->getAccessToken()['access_token'];

    }
}
