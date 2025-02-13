<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Exception\RequestException;

class ChatGptService{

    public function getSubscriptionCount($userName)
    {
        $user = User::where('name', $userName)->first();

        if (!$user) {
            return "User not found.";
        }

        return $user->subscriptions()->count();
    }

    public function handleChatGptResponse($response)
    {
        dd($response);
        if (str_contains($response, 'how many subscriptions does')) {
            $userName = $this->extractUserName($response);
            return $this->getSubscriptionCount($userName);
        }

        // Handle other types of responses...
    }

    protected function extractUserName($response)
    {
        // Basic parsing logic to extract the user's name from the response
        // This is just an example and might need to be adapted
        $parts = explode(' ', $response);
        $userNameIndex = array_search('does', $parts) + 1;
        return $parts[$userNameIndex];
    }


    public function askChatGPT($question)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('POST', 'https://api.openai.com/v1/engines/davinci-codex/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'prompt' => $question,
                    'max_tokens' => 150,
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            return $responseBody;

        } catch (RequestException $e) {
            // Handle the exception...
            return ['error' => $e->getMessage()];
        }
    }
}
