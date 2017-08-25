<?php
namespace Trymsunsoan\Hello\Model;
//use Magento\Catalog\Model\ResourceModel\Product\Collection;
//use Magento\Catalog\Api\ProductRepositoryInterface;
use Trymsunsoan\Hello\Api\HelloInterface;

class Hello implements HelloInterface
{
    protected  $productCollectionFactory;
    protected  $resource;
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\App\ResourceConnection $resource
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->resource = $resource;
    }

    public function name( $name ){
        return "Helo ".$name;
    }

    public function getProduct(){
        $productTable = 'catalog_product_entity';
        $tablevarchar = 'catalog_product_entity_varchar';
        $tableprice   = 'catalog_product_index_price';
        $collection = $this->productCollectionFactory->create();



        $select1 = clone $collection->getSelect()->join(
            ['title' => $tablevarchar],
            "e.entity_id = title.entity_id"
        )->join(
            ['price' => $tableprice ],
            "e.entity_id = price.entity_id"
        )->where( 'e.entity_id = 1' );
//        )->where( 'e.entity_id < 10' );


        return $collection->getData();
    }

    public function sum( $nums )
    {
        if( isset( $nums ) ){
            $result = 0;
        }else{
            return 0;
        }
    }
}
