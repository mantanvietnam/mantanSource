<?php


function getListPermissionAdvanced()
{
    return array(  
                    'editCollectionBill'=>'Sửa thông tin phiếu thu',
                    'deleteCollectionBill'=>'Xóa phiếu thu',
                    'editBill'=>'Sửa thông tin phiếu chi',
                    'deleteBill'=>'Xóa phiếu chi',
                );
}
function getMenuSidebarLeftManager() {
    global $urlHomes;
    return array(
        array('icon' => 'fa-bed', 'name' => 'Quản lý căn hộ cho thuê', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Sơ đồ căn hộ', 'link' => $urlHomes . 'managerHotelDiagram', 'permission' => 'managerHotelDiagram'),
                array('icon' => '', 'name' => 'Danh sách tầng', 'link' => $urlHomes . 'managerListFloor', 'permission' => 'managerListFloor'),
                array('icon' => '', 'name' => 'Danh sách loại phòng', 'link' => $urlHomes . 'managerListTypeRoom', 'permission' => 'managerListTypeRoom'),
                array('icon' => '', 'name' => 'Thêm phòng', 'link' => $urlHomes . 'managerAddRoom', 'permission' => 'managerAddRoom'),
                array('icon' => '', 'name' => 'Danh sách Ngày lễ', 'link' => $urlHomes . 'managerListHoliday', 'permission' => 'managerListHoliday'),
                
            )
        ),
        array('icon' => 'fa-calendar-plus-o', 'name' => 'Chăm sóc khách hàng', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách sinh nhật', 'link' => $urlHomes . 'managerListBirthday', 'permission' => 'managerListBirthday'),
                array('icon' => '', 'name' => 'Danh sách đến hạn thu tiền', 'link' => $urlHomes . 'managerListDeadlinePay', 'permission' => 'managerListDeadlinePay'),
                array('icon' => '', 'name' => 'Danh sách đến hạn trả phòng', 'link' => $urlHomes . 'managerListDeadlineCheckout', 'permission' => 'managerListDeadlineCheckout'),
                array('icon' => '', 'name' => 'Danh sách báo hỏng', 'link' => $urlHomes . 'managerListReportRoom', 'permission' => 'managerListReportRoom'),
                array('icon' => '', 'name' => 'Danh sách yêu cầu dịch vụ', 'link' => $urlHomes . 'managerListNotification', 'permission' => 'managerListNotification'),
                array('icon' => '', 'name' => 'Danh sách thông báo cho khách hàng', 'link' => $urlHomes . 'managerListNotificationCustomer', 'permission' => 'managerListNotificationCustomer'),
                array('icon' => '', 'name' => 'Danh sách đối tác', 'link' => $urlHomes . 'managerListPartner', 'permission' => 'managerListPartner'),
                array('icon' => '', 'name' => 'Lịch sử bảo hành', 'link' => $urlHomes . 'managerListWarranty', 'permission' => 'managerListWarranty'),
            )
        ),
        
        array('icon' => 'fa-video-camera', 'name' => 'Xem camera', 'link' => $urlHomes . 'managerHotelCamera', 'permission' => 'managerHotelCamera'),
        array('icon' => 'fa-sitemap', 'name' => 'Danh sách cơ sở lưu trú', 'link' => $urlHomes . 'managerListHotel', 'permission' => 'managerListHotel'),
        array('icon' => 'fa-calendar', 'name' => 'Người dùng đặt phòng', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Tất cả đơn hàng', 'link' => $urlHomes . 'managerListOrder', 'permission' => 'managerListOrder'),
                array('icon' => '', 'name' => 'Chưa xử lý', 'link' => $urlHomes . 'managerListOrderPending', 'permission' => 'managerListOrderPending'),
                array('icon' => '', 'name' => 'Đã xếp phòng', 'link' => $urlHomes . 'managerListOrderProcess', 'permission' => 'managerListOrderProcess')
            )
        ),
        array('icon' => 'fa-question-circle', 'name' => 'Khách yêu cầu báo giá', 'link' => $urlHomes . 'managerListRequest', 'permission' => 'managerListRequest'),
        array('icon' => 'fa-book', 'name' => 'Khuyến mại', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách khuyến mại', 'link' => $urlHomes . 'managerListPromotion', 'permission' => 'managerListPromotion'),
                array('icon' => '', 'name' => 'Thêm khuyến mại', 'link' => $urlHomes . 'managerAddPromotion', 'permission' => 'managerAddPromotion')
            )
        ),
        array('icon' => 'fa-suitcase', 'name' => 'Hàng hóa - Dịch vụ', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerListMerchandise', 'permission' => 'managerListMerchandise'),
                array('icon' => '', 'name' => 'Thêm hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerAddMerchandise', 'permission' => 'managerAddMerchandise'),
                array('icon' => '', 'name' => 'Thêm số lượng hàng hóa', 'link' => $urlHomes . 'managerAddNumberMerchandise', 'permission' => 'managerAddNumberMerchandise'),
                array('icon' => '', 'name' => 'Bán lẻ hàng hóa', 'link' => $urlHomes . 'managerSellMerchandise', 'permission' => 'managerSellMerchandise'),
                array('icon' => '', 'name' => 'Nhóm hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerListMerchandiseGroup', 'permission' => 'managerListMerchandiseGroup'),
                array('icon' => '', 'name' => 'Thêm nhóm hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerAddMerchandiseGroup', 'permission' => 'managerAddMerchandiseGroup')
            )
        ),
        
        array('icon' => 'fa-users', 'name' => 'Nhân viên', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách nhân viên', 'link' => $urlHomes . 'managerListStaff', 'permission' => 'managerListStaff'),
                array('icon' => '', 'name' => 'Thêm nhân viên', 'link' => $urlHomes . 'managerAddStaff', 'permission' => 'managerAddStaff'),
                array('icon' => '', 'name' => 'Nhóm phân quyền', 'link' => $urlHomes . 'managerListPermission', 'permission' => 'managerListPermission'),
                array('icon' => '', 'name' => 'Thêm nhóm phân quyền', 'link' => $urlHomes . 'managerAddPermission', 'permission' => 'managerAddPermission')
            )
        ),
        array('icon' => 'fa-money', 'name' => 'Quản lý thu chi', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách phiếu thu', 'link' => $urlHomes . 'managerListCollectionBill', 'permission' => 'managerListCollectionBill'),
                array('icon' => '', 'name' => 'Thêm phiếu thu', 'link' => $urlHomes . 'managerAddCollectionBill', 'permission' => 'managerAddCollectionBill'),
                array('icon' => '', 'name' => 'Danh sách phiếu chi', 'link' => $urlHomes . 'managerListBill', 'permission' => 'managerListBill'),
                array('icon' => '', 'name' => 'Thêm phiếu chi', 'link' => $urlHomes . 'managerAddBill', 'permission' => 'managerAddBill')
            )
        ),
        array('icon' => 'fa-fax', 'name' => 'Quản lý công nợ', 'link' => '',
            'sub' => array(
            	array('icon' => '', 'name' => 'Công nợ thu', 'link' => $urlHomes . 'managerLiabilitie', 'permission' => 'managerLiabilitie'),
                array('icon' => '', 'name' => 'Công nợ chi', 'link' => $urlHomes . 'managerLiabilitieBill', 'permission' => 'managerLiabilitieBill'),
                //array('icon' => '', 'name' => 'Công nợ bar', 'link' => $urlHomes . 'managerLiabilitieBar', 'permission' => 'managerLiabilitieBar'),
            )
        ),
        array('icon' => 'fa-credit-card', 'name' => 'Quản lý doanh thu', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Doanh thu phòng', 'link' => $urlHomes . 'managerRevenue', 'permission' => 'managerRevenue'),
                array('icon' => '', 'name' => 'Doanh thu hàng hóa', 'link' => $urlHomes . 'managerRevenueMerchandise', 'permission' => 'managerRevenueMerchandise'),
                //array('icon' => '', 'name' => 'Doanh thu bar', 'link' => $urlHomes . 'managerRevenueBar', 'permission' => 'managerRevenueBar'),
                //array('icon' => '', 'name' => 'Doanh thu nhà hàng', 'link' => $urlHomes . 'managerRevenueRestaurant', 'permission' => 'managerRevenueRestaurant'),
                array('icon' => '', 'name' => 'Doanh thu đại lý', 'link' => $urlHomes . 'managerRevenueAgency', 'permission' => 'managerRevenueAgency'),
            )
        ),
    );
}

?>