1. Sửa lại file app\code\Cowell\Delivery\Block\DeliveryInformation.php
	- protected function _beforeToHtml() : hàm này dùng để chuẩn bị dữ liệu trước khi generate HTML. Trong đó cần chú ý 
		+ Đoạn code set biến dùng ở file deliveryinfo.phtml đặt ở đây

			$this->setData('month_current',$monthCurrent);  
 			$this->setData('day_current',$dayCurrent);
 			$this->setData('last_day',$nextDay);
 			$this->setData('last_month',$nextMonth);
 			$this->setData('arr_status',$arrStatus); 
 			
2. Sửa lại file app\code\Cowell\Delivery\view\frontend\layout\default.xml
	- Đối với vị trí bên trái trang:  Đặt lại tên container "sidebar.additional" theo container layout định nghĩa
		<referenceContainer name="sidebar.additional">
            <block class="Cowell\Delivery\Block\DeliveryInformation" name="DeliveryInformation" after="-" template="Cowell_Delivery::deliveryinfo.phtml"></block>
        </referenceContainer>
    - Đối với vị trí top : add thêm thêm đoạn code để chèn Block theo layout định nghĩa. Đổi name="top.links" thành tên tương ứng ở layout
    	<referenceBlock name="top.links">
            <block class="Cowell\Delivery\Block\DeliveryInformation" name="DeliveryInformation" after="-" template="Cowell_Delivery::deliveryinfo.phtml"></block>
        </referenceBlock>
    - Nếu cần thêm file css, jss thì thêm bvào thư mục tương ứng ở app\code\Cowell\Delivery\view\frontend\web