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
import { BaseComponent } from '../../core/dependency-injection/base.component';
import { ExpressCheckoutButtonComponent } from '../common/express-checkout-button.component';

export class ExpressButtonCartComponent extends BaseComponent {
  static Inject = {
    htmlElementService: 'HTMLElementService',
    psCheckoutApi: 'PsCheckoutApi',
    $: '$'
  };

  created() {
    this.buttonContainer = this.htmlElementService.getCheckoutExpressCartButtonContainer(
      true
    );
  }

  render() {
    if (!this.buttonContainer) return;

    this.checkoutExpressButton = document.createElement('div');
    this.checkoutExpressButton.id = 'ps-checkout-express-button';

    const separatorText = document.createElement('div');
    separatorText.classList.add('ps-checkout-express-separator');
    separatorText.innerText = this.$('express-button.cart.separator');

    this.buttonContainer.append(separatorText);
    this.buttonContainer.append(this.checkoutExpressButton);

    this.children.expressCheckoutButton = new ExpressCheckoutButtonComponent(
      this.app,
      {
        // TODO: Move this to constant when ExpressCheckoutButton component is created
        querySelector: '#ps-checkout-express-button',
        createOrder: (data) =>
          this.psCheckoutApi.postCreateOrder({
            ...data,
            fundingSource: 'paypal',
            isExpressCheckout: true
          })
      }
    ).render();
    return this;
  }
}
