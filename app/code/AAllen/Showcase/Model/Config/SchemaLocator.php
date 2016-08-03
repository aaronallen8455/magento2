<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/3/2016
 * Time: 1:48 AM
 */

namespace AAllen\Showcase\Model\Config;


use Magento\Framework\Module\Dir;

class SchemaLocator extends \Magento\Widget\Model\Config\SchemaLocator
{

    public function __construct(\Magento\Framework\Module\Dir\Reader $moduleReader)
    {
        parent::__construct($moduleReader);
        $etcDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'AAllen_Showcase');
        $this->_schema = $etcDir . '/widget.xsd';
        $this->_perFileSchema = $etcDir . '/widget_file.xsd';
    }
}