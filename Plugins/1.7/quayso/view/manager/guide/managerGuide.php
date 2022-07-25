<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>
<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/"><i class="fa fa-home"></i> Trang chủ</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Hướng dẫn sử dụng</li>
    </ul>
    
    <div class="panel-body"> 
        <p><b>Link API:</b> <a href="javascript:void(0);">https://quayso.xyz/addUserAPI</a></p><br/><br/>

        <p><b>Tham số truyền đi:</b> fullName, phone, campaign, email, idMessUser</p>
        <p>fullName: họ tên người chơi</p>
        <p>phone: số điện thoại người chơi</p>
        <p>email: email người chơi</p>
        <p>idMessUser: ID messenger người chơi</p>
        <p>avatar: link ảnh đại diện của người chơi</p>
        <p>campaign: ID chiến dịch</p>
        <p>hiddenMessages: nếu bạn không muốn nhận tin nhắn mặc định trả về thì truyền lên giá trị là 1</p>
        <p>autoCheckin: nếu bạn muốn người tham gia tự động checkin luôn thì truyền lên giá trị là 1</p>
        <p>job: công việc hiện tại (trường không bắt buộc)</p>
        <p>note: ghi chú (trường không bắt buộc)</p>
        <br/><br/>

        <p><b>Tham số nhận về:</b> code, messages, codeQT, linkQRCheckin</p>
        <p>code: mã xác nhận lưu dữ liệu và tạo mã dự thưởng, 1 là thành công, 0 là thất bại</p>
        <p>messages: tin nhắn mặc định trả về của hệ thống, nếu không muốn nhận tin nhắn này thì truyền lên tham số hiddenMessages với giá trị là 1</p>
        <p>codeQT: mã dự thưởng của người chơi</p>
        <p>linkQRCheckin: link ảnh QR để người chơi thực hiện checkin tự động</p><br/><br/>

        <img src="/app/Plugin/quayso/view/manager/img/Huong-dan-cau-hinh-quay-thuong.png" width="100%">
    </div>
</section>

<!-- end: page -->
</section>


<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>