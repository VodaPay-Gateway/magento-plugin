define(
  [
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
  ],
  function (Component, rendererList) {
    'use strict'

    rendererList.push(
      {
        type: 'vodapay',
        component: 'VodaPay_VodaPay/js/view/payment/method-renderer/vodapay'
      }
    )

    /**
     * Add view logic here if needed
     */
    return Component.extend({})
  }
)
