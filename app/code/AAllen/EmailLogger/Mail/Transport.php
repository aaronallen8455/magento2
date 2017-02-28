<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/17/2017
 * Time: 5:34 PM
 */

namespace AAllen\EmailLogger\Mail;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\Mail\MessageInterface;
use Zend_Mail_Transport_Abstract;

class Transport extends \Magento\Framework\Mail\Transport
{
    protected $logger;

    protected $filesystem;

    public function __construct(MessageInterface $message, Monolog $logger, Filesystem $filesystem)
    {
        $this->logger = $logger;
        $this->filesystem = $filesystem;

        parent::__construct($message, null);
    }

    public function sendMessage()
    {
        // create html file from the email template
        $dir = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $fileName = 'email.html';
        $dir->writeFile($fileName, $this->_message->getBodyHtml()->getRawContent());

        parent::sendMessage();
    }
}