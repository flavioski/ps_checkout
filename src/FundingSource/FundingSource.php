<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

namespace PrestaShop\Module\PrestashopCheckout\FundingSource;

class FundingSource
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $label;

    /**
     * @var int
     */
    public $position;

    /**
     * @var array
     */
    public $countries;

    /**
     * @var bool
     */
    public $isEnabled;

    /**
     * @var bool
     */
    public $isToggleable;

    /**
     * @param string $name
     * @param string $label
     * @param int $position
     * @param array $countries
     * @param bool $isEnabled
     * @param bool $isToggleable
     */
    public function __construct($name, $label, $position, $countries, $isEnabled, $isToggleable)
    {
        $this->name = $name;
        $this->label = $label;
        $this->position = $position;
        $this->countries = $countries;
        $this->isEnabled = $isEnabled;
        $this->isToggleable = $isToggleable;
    }
}
