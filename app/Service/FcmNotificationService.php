<?php

namespace App\Services;

use App\Services\Google\GoogleService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmNotificationService
{

    private string $title;

    private string $body;

    private string $deviceToken;

    private array $data = [];
    private string $type = '';


   // private string $fcmBaseUrl = 'https://fcm.googleapis.com/v1/projects/story-mii-415107/messages:send';
    private string $fcmBaseUrl = 'https://fcm.googleapis.com/v1/projects/digital-dealership-64af9/messages:send';

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;
        return $this;

    }

    public function to(string $deviceToken): static
    {
        $this->deviceToken = $deviceToken;
        return $this;

    }

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;

    }

    public function send()
    {
        if (empty($this->title) || empty($this->body) || empty($this->deviceToken)) {
            throw new \Exception('Missing required parameters for sending notification');
        }
        $googleService = new GoogleService();
        $payload ['message'] = [
            "token" => $this->deviceToken,
            "notification" => [
                "title" => $this->title,
                "body" => $this->body,
            ]
        ];
        if(!empty($this->data)){
            $payload['message']['data'] = $this->data;
        }

        $response = Http::withBody(
            json_encode($payload)
        )->withHeaders([
                'Authorization' => 'Bearer ' . $googleService->getAccessToken(),
                'Content-Type' => 'application/json',
            ])
        ->post($this->fcmBaseUrl);

        Log::info($response->body());

        return $response->body();
    }


}
