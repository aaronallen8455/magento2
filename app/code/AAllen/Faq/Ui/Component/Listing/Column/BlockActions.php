<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/22/2016
 * Time: 12:07 AM
 */

namespace AAllen\Faq\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class BlockActions extends Column
{
    /** Url Path */
    const FAQ_URL_PATH_EDIT = 'faq/question/edit';
    const FAQ_URL_PATH_DELETE = 'faq/question/delete';

    /** @var UrlInterface */
    protected $urlBuilder;

    /** @var string */
    private $editUrl;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, UrlInterface $urlBuilder, array $components, array $data, $editUrl = self::FAQ_URL_PATH_EDIT)
    {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['faq_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, [
                            'faq_id' => $item['faq_id']
                        ]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::FAQ_URL_PATH_DELETE, ['faq_id' => $item['faq_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.name }"'),
                            'message' => __('Are you sure you want to delete a "${ $.$data.name }" record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}