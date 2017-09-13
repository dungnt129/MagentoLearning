- Sửa lại file app\code\Cowell\Search\view\frontend\layout\default.xml
    Đặt lại tên container "content.top.search" theo container layout định nghĩa

    <referenceContainer name="content.top.search" htmlTag="div" htmlClass="pc2015-upper">
        <block class="Cowell\Search\Block\Search"  name="search.by.category" as="searchByCategory" template="Cowell_Search::form.mini.phtml" />
    </referenceContainer>

- Content => Widgets => Add Widget => Type: Top keyword, Design Theme: Cowell ibis
 - Storefront Properties: sử dụng để config title, store mà ta muốn hiển thị widget, sort order, layout update.
 Trong layout update ta cần chọn các pages cần hiển thị, Container chính là label "pc2015 center search top keyword" trong phần layout/default.xml