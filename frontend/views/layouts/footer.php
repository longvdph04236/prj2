<?php
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="footer-col-heading">
                    <h4>Về chúng tôi</h4>
                </div>
                <div class="footer-col-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut distinctio earum eligendi fuga hic illum libero, magnam nobis porro provident quaerat quibusdam quos sed similique voluptatem? Ducimus ex nisi rerum?</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-col-heading">
                    <h4>Danh mục</h4>
                </div>
                <div class="footer-col-content">
                    <ul class="ul-flex-item">
                        <li><a href="<?= Url::toRoute('home/') ?>">Trang chủ</a></li>
                        <li><a href="#">Danh sách sân</a></li>
                        <li><a href="#">Tìm đối thủ</a></li>
                        <li><a href="<?= Url::toRoute('home/#by-id') ?>">Tra cứu mã đặt sân</a></li>
                        <li><a href="<?= Url::toRoute('user/dang-ky') ?>">Đăng ký</a></li>
                        <li><a href="<?= Url::toRoute('user/dang-nhap') ?>">Đăng nhập</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-col-heading">
                    <h4>Liên hệ</h4>
                </div>
                <div class="footer-col-content contact-col">
                    <p><i class="fa fa-envelope" aria-hidden="true"></i> contact@yeubongda.com</p>
                    <p><i class="fa fa-phone" aria-hidden="true"></i> 0987 654 321</p>
                    <p><i class="fa fa-globe" aria-hidden="true"></i> www.yeubongda.com</p>
                    <p>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-google-plus"></i></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                Copyright © www.yeubongda.com. All rights reserved.
            </div>
        </div>
    </div>
</footer>
<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Đăng nhập</h4>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <div class="fb-login-button" data-width="300" data-scope="email, public_profile" onlogin="checkLoginState();" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>
                    <span>hoặc</span>
                    <div class="login-form-2" data-content="<?= Url::toRoute('user/dang-nhap',true)?>">

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>