<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/21/2017
 * Time: 6:42 PM
 */

namespace AAllen\TrackingLink\Helper;


class Data extends \Magento\Shipping\Helper\Data
{
    /**
     * Retrieve tracking url with params
     *
     * @param  string $key
     * @param  \Magento\Sales\Model\Order|\Magento\Sales\Model\Order\Shipment|\Magento\Sales\Model\Order\Shipment\Track $model
     * @param  string $method Optional - method of a model to get id
     * @return string
     */
    protected function _getTrackingUrl($key, $model, $method = 'getId')
    {
        $urlPart = "{$key}:{$model->{$method}()}:{$model->getProtectCode()}";
        $params = [
            '_direct' => 'tracking_details/',
            '_query' => ['hash' => $this->urlEncoder->encode($urlPart)]
        ];

        $storeModel = $this->_storeManager->getStore($model->getStoreId());
        return $storeModel->getUrl('', $params);
    }
}