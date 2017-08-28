<?php
namespace Trymsunsoan\Hello\Model;
//use Magento\Catalog\Model\ResourceModel\Product\Collection;
//use Magento\Catalog\Api\ProductRepositoryInterface;
use Trymsunsoan\Hello\Api\HelloInterface;

class Hello implements HelloInterface
{
    protected  $productCollectionFactory;
    protected  $productRepository;
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository

    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productRepository  = $productRepository;
    }

    public function name( $name ){
        return "Helo ".$name;

    }

    private function getProductById( $id )
    {
        return $this->productRepository->getById( $id );
    }


    public function getProduct(){
        $tablevarchar = 'catalog_product_entity_varchar';
        $tableprice   = 'catalog_product_index_price';
        $collection = $this->productCollectionFactory->create();


        $collection->getSelect()->join(
            ['title' => $tablevarchar],
            "e.entity_id = title.entity_id"
        )->join(
            ['price' => $tableprice ],
            "e.entity_id = price.entity_id"
        )->where( 'e.entity_id = 1' );
//        return json_encode( $collection->getData() );
        return $collection->getData();
    }


    public function sum( $nums )
    {
        if( isset( $nums ) ){
            $result = 0;
            foreach ( $nums as $numb )
            {
                $result += $numb;
            }
            return $result;
        }else{
            return 0;
        }
    }
}
