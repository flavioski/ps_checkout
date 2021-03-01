<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\PrestashopCheckout\Handler;

use Exception;
use Raven_Client;

class ExceptionHandler
{
    /**
     * @var Raven_Client
     */
    protected $client;

    public function __construct(\Ps_checkout $module)
    {
        $this->client = new Raven_Client(
            $_ENV['PS_CHECKOUT_SENTRY_DSN_MODULE'],
            [
                'level' => 'warning',
                'tags' => [
                    'php_version' => phpversion(),
                    'ps_checkout_version' => $module->version,
                    'prestashop_version' => _PS_VERSION_,
                ],
            ]
        );
    }

    /**
     * @param Exception $error
     * @param bool $throw
     *
     * @return void
     *
     * @throws Exception
     */
    public function handle(Exception $error, $throw = true)
    {
        $this->client->captureException($error);

        if ($throw) {
            throw $error;
        }
    }
}