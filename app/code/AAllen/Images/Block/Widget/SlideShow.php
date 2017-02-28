<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/5/2017
 * Time: 10:55 PM
 */

namespace AAllen\Images\Block\Widget;


use AAllen\Images\Api\ImageRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class SlideShow extends Template implements BlockInterface
{
    protected $_images;

    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;

    protected $_template = 'AAllen_Images::image/widget/slideshow.phtml';

    public function __construct(Template\Context $context, ImageRepositoryInterface $imageRepository, array $data = [])
    {
        $this->imageRepository = $imageRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get an array of urls for all slide images
     *
     * @return array
     */
    public function getImages()
    {
        if (!isset($this->_images)) {
            $this->_images = [];
            for ($i=1; $i<=6; $i++) {
                if ($data = $this->getData('image' . $i)) {
                    $image = $this->imageRepository->getById($data);
                    if ($image->isActive()) {
                        $this->_images[] = $image->getUrl();
                    }
                }
            }
        }
        return $this->_images;
    }

    public function getDuration()
    {
        return $this->getData('duration');
    }
}