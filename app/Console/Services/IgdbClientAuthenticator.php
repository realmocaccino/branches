<?php
namespace App\Console\Services;

use App\Console\Exceptions\ApiAuthenticationErrorException;

use Exception;

class IgdbClientAuthenticator
{
    private $apiAuthUrl;
	private $apiClientId;
	private $apiClientSecret;

    private $accessToken;
    private $isAuthenticated = false;

    public function __construct()
    {
        $this->apiAuthUrl = config('services.igdb.auth_url');
		$this->apiClientId = config('services.igdb.client_id');
		$this->apiClientSecret = config('services.igdb.client_secret');
    }

    public function authenticate()
    {
        if(!$this->isAuthenticated) {
            try {
                $curl = curl_init($this->apiAuthUrl . '?client_id=' . $this->apiClientId . '&client_secret=' . $this->apiClientSecret . '&grant_type=client_credentials');
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = json_decode(curl_exec($curl));
                curl_close($curl);

                $this->setAccessToken($response->access_token);
                $this->setIsAuthenticatedAsTrue();
            } catch (Exception $e) {
                throw new ApiAuthenticationErrorException('Erro ao se autenticar com IGDB' . PHP_EOL);
            }
        }
	}

    public function getAccessToken()
	{
	    return $this->accessToken;
	}

    private function setAccessToken($token)
	{
	    $this->accessToken = $token;
	}

    private function setIsAuthenticatedAsTrue()
    {
        $this->isAuthenticated = true;
    }
}