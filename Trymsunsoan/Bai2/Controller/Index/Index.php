<?php
namespace Trymsunsoan\Bai2\Controller\Index;
class Index extends \Magento\Framework\App\Action\Action {
    public function execute()
    {
        /* Insert data
         * Ta can truyen vao tham so la namspace cua Banner
         * */

        $banner = $this->_objectManager->create( 'Trymsunsoan\Bai2\Model\Banner' );
        /*        $banner->addData([
                    'link' => 'banner_link',
                    'image' => 'avatar.png',
                    'sort_order' => 1,
                    'status' => true
                ])->save();
                for( $i = 0; $i < 100; $i++ ){
                    $banner->addData([
                        'link' => 'banner_link'.$i,
                        'image' => 'avatar'.$i.'.png',
                        'sort_order' => $i,
                        'status' => true
                    ])->save()->unsetData();
                }*/
        /*        $data = $banner->load(1)->getData();//get banner co id=1
                print_r( $data );*/


        //UPDATE DATA
        /*        try{
                    $data = $banner->load(1);
                    $data->setImage(  'trymsunsoan.png' )->save();
                }catch (\Exception $e){
                    echo $e;
                }*/

        //DELETE DATA
        $data = $banner->load(1);
        $data->delete();
    }
}