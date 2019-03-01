<?php
/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

namespace PrestaShop\Module\PrestashopPayment\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Maasland
{
    private $paypalApi = 'https://api.sandbox.paypal.com';
    private $maaslandApi = 'http://172.17.0.1:8000';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client = null) {
        // Client can be provided for tests
        if (null === $client) {
            $client = new Client();
        }
        $this->client = $client;
    }

    /**
     * Generate access token from api
     * 
     * @return bool|string access token or false in case of error.
     */
    public function getAccessToken()
    {
        $route = '/v1/oauth2/token';

        try {
            $response = $this->client->post($this->paypalApi . $route, [
                'headers' =>
                [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => 'grant_type=client_credentials',
                'auth' => ['<user>', '<password>', 'basic']
            ]);
        }
        catch (ClientException $e) {
            // TODO: Log the error ? Return an error message ?
            return false;
        }

        $data = json_decode($response->getBody(), true);

        return isset($data['access_token']) ? $data['access_token'] : false;
    }

    /**
     * Generate client token in order to display hosted fields and payment by paypal. (needed by paypal sdk)
     * 
     * @return bool|string client token or false if error occured
     */
    public function getClientToken()
    {
        $route = '/v1/identity/generate-token';

        $accessToken = $this->getAccessToken();
        if ($accessToken === false) {
            return false;
        }

        try {
            $response = $this->client->post($this->paypalApi . $route, [
                'headers' =>
                [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ],
            ]);
        }
        catch (ClientException $e) {
            // TODO: Log the error ? Return an error message ?
            return false;
        }

        $data = json_decode($response->getBody(), true);

        return isset($data['client_token']) ? $data['client_token'] : false;
    }

    /**
     * Create order to paypal api
     * 
     * @param array Cart details
     * 
     * @return array|bool data with paypal order id or false if error
     */
    public function createOrder($payload = array())
    {
        $route = '/payments/order/create';

        try {
            $response = $this->client->post($this->maaslandApi . $route, [
                'headers' =>
                [
                    'Content-Type' => 'application/json',
                ],
                'body' => $payload
            ]);
        }
        catch (ClientException $e) {
            // TODO: Log the error ? Return an error message ?
            return false;
        }

        $data = json_decode($response->getBody(), true);

        return $data;
    }
}
