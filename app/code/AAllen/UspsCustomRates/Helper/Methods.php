<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/7/2016
 * Time: 4:44 PM
 */

namespace AAllen\UspsCustomRates\Helper;


use Magento\Usps\Model\Source\MethodFactory;

class Methods
{
    private $methodFactory;

    /**
     * @var array
     */
    private $methods;

    public function __construct(MethodFactory $methodFactory)
    {
        $this->methodFactory = $methodFactory;
    }

    /**
     * Returns methods array
     *
     * @return array
     */
    public function getMethods()
    {
        if (!$this->methods) {
            $this->methods = $this->methodFactory->create()->toOptionArray(false);
        }
        return $this->methods;
    }
}