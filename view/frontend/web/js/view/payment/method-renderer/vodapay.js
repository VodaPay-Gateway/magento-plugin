define(
  ['jquery',
    'Magento_Checkout/js/view/payment/default',
    'mage/url'
  ],
  function ($, Component, url) {
    'use strict'

    return Component.extend(
      {
        defaults: {
          template: 'VodaPay_VodaPay/payment/vodapay',
          redirectAfterPlaceOrder: false
        },
        afterPlaceOrder: function () {
          $('#vodapay_redirect_msg').show()
          window.location.replace(url.build('vodapay/vodapay/redirect'))
        }
      }
    )
  }
)
