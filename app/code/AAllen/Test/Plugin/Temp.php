<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 4/26/2017
 * Time: 1:19 AM
 */

namespace AAllen\Test\Plugin;


class Temp
{

    public function afterExecute($subject, \Magento\Framework\View\Result\Page $resultPage)
    {
        $resultPage
            ->getLayout()
            ->getChildBlock('content', 'thabox')
            ->setTemplate('AAllen_Test::test.phtml');

        return $resultPage;
    }
}