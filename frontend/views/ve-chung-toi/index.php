<?php

    use frontend\assets\AboutAsset;
    AboutAsset::register($this);


?>
    <div id="about">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="section-title col-sm-12">
                    <h2>Về <span>Chúng tôi</span></h2>
                    <h4>Ai Và tại sao</h4>
                    <span class="divide"></span>
                    <span class="section_description">Là Một trong nhữn đơn vị tiên phong cung cấp dịch vụ quản lý, đặt sân bóng trực tuyến, Với nhiều năm kinh nghiệm trong lĩnh vực trực tuyến thể thao, chúng tôi luôn luôn cung cấp những dịch vụ tốt nhất - đem lại những tiện ích tốt nhất cho người dùng với nhưng công nghệ mới nhất.</span>
                </div>
            </div>
            <div class="row about-content">
                <div class="col-sm-12">
                    <div class="about-row">
                        <h5>Kinh nghiệm</h5>
                        <p>là một trong những đơn vị đi đầu về dịch vụ thể thao online với nhiều năm kinh nghiệm, đội ngũ nhân viên nhiều năm kinh nghiệm, tự tin sử lý tất cả các trường hợp và áp dụng, cập nhận công nghệ một cách nhanh nhất.</p>
                    </div>
                    <div class="about-row">
                        <h5>Hoạt động</h5>
                        <p>hoạt động chủ yếu lĩnh vực cũng cấp dịch vụ website quản lý và đặt sân bóng khu vực miềm bắc, hướng phát triện quy mô cả nước</p>
                    </div>
                    <div class="about-row">
                        <h5>ĐỘ TIN CẬY</h5>
                        <p>tất cả hệ thông quản lý, đặt sân đều được chú trọng đến tính năng bảo mật cũng như có nhưng gói bảo hành tốt nhất cho khách hàng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="team" class="container">
        <div class="row">
            <div class="section-title col-sm-12">
                <h2>Đội Ngũ <span>Phát Triển</span></h2>
                <h4>Chúng tôi là ai</h4>
                <span class="divide"></span>
                <span class="section_description">Luôn đồng hành cùng quý khách trong suốt chặng đường xây dựng và phát triển website của quý khách là đội ngũ nhân sự  giàu kinh nghiệm, năng động, luôn sẵn lòng phục vụ khách hàng chu đáo</span>
            </div>
        </div>

        <div class="row">
            <div class="member col-sm-4">
                <div class="bt">
                    <img src="<?= Yii::getAlias('@web')?>/img/avatar-long.jpg" alt="">
                    <div class="member-name">
                        <a href="#">Vũ Long</a>
                    </div>
                    <small class="member-role">developer</small>


                </div>
            </div>
            <div class="member col-sm-4">
                <div class="bt">
                    <img src="<?= Yii::getAlias('@web')?>/img/avatar-hoa.jpg" alt="">
                    <div class="member-name">
                        <a href="#">Nguyễn Hóa</a>
                    </div>
                    <small class="member-role">developer</small>


                </div>
            </div>
            <div class="member col-sm-4">
                <div class="bt">
                    <img src="<?= Yii::getAlias('@web')?>/img/avatar-quan.jpg" alt="" width="370" height="370">
                    <div class="member-name">
                        <a href="#">Hồng Quân</a>
                    </div>
                    <small class="member-role">Designer</small>
                </div>
            </div>
        </div>
    </div>