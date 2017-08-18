<?php

namespace Robin\Banner\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            // Lấy ra tên cột hiển thị (ở đây là cột image)
            $fieldName = $this->getData('name');

            // Sửa lại giá trị của data source
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';
                if ($item[$fieldName] != '') {
                    // Lấy đường dẫn của ảnh
                    $url = $this->storeManager->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . 'banner/images/' . $item[$fieldName];
                }

                /*
                * Truyền vào các giá trị cần thiết
                * $fieldName . '_src' - Đường dẫn của ảnh trong bảng
                * $fieldName . '_alt' - Giá trị thuộc tính alt của ảnh
                * $fieldName . '_link' - Link khi bấm vào ảnh (trỏ sang trang edit)
                * $fieldName . '_orig_src' - Đường dẫn ảnh khi phóng to
                */
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item[$fieldName];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'banner/index/edit',
                    ['id' => $item['id']]
                );
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}