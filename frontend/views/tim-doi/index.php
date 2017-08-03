<?php

    use frontend\assets\TimDoiAsset;
    TimDoiAsset::register($this);

    $this->params['breadcrumbs'][] = ['label'=>'Tìm Đối', 'url'=>'index'];

?>

    <div class="row">
        <div id="tim-doi">
            <div class="col-sx-12 col-sm-3 col-s">
                <div class="sidebar-filter-container list-menu over">
                    <ul class="ul  list-left-select">
                        <li> <strong><i class="fa fa-map-marker" aria-hidden="true"></i>Tỉnh/Thành phố</strong> </li>
                    </ul>
                    <ul>
                        <li>
                            <select id="filter-select">
                                <option value="1">Hà Nội</option>
                                <option value="2">Hưng Yên</option>
                                <option value="3">Thái Bình</option>
                                <option value="4">Hà Nam</option>
                                <option value="5">Hải Dương</option>
                                <option value="6">Nam Định</option>
                            </select>
                        </li>
                    </ul>
                    <ul class="ul list-left-select" >
                        <li><strong>Quận/Huyện</strong></li>
                    </ul>
                    <ul>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Thanh Xuân
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>

                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Ba Đình
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Hai Bà Trưng
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false">Bắc Từ Liêm
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Thanh Xu&#226;n
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Nam Từ Liêm
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Đống Đa
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>
                        <li class="qhCheck">
                            <div class="checkbox">
                                <label>
                                    <input name="qh" type="checkbox" class="qh" value="6"><input type="hidden" value="false"> Cầu Giấy
                                    <span class="pull-right filter-count"></span>
                                </label>
                            </div>
                        </li>

                        <li class="clear-checkbox">
                            <button class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Xóa lựa chọn</button>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-9 col-s">
                <div class="show-itemx">
                    <h1 id="a" class="title-intent title-pages"><i class="fa fa-futbol-o" aria-hidden="true"></i>Tìm đối đá bóng <span style="float: right"><a href="/quan-ly-tim-doi-thu"> Đăng tin</a></span></h1>
                    <div class="CompetitorViewCss">
                        <form id="searchCompetitorForm" class="search-form ng-pristine ng-valid row row-s">
                            <div class="col-xs-12 col-md-2 nopaddingleft col-s">
                                <select class="form-control select-has-stadium" name="hasstadium">
                                    <option value="0">Tất cả</option>
                                    <option value="2">Nhận đi khách</option>
                                    <option value="1">Có sân nhà</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-4 col-s">
                                <div class="row row-s">
                                    <div class="col-xs-12 col-sm-7 col-s">
                                        <input type="date" class="form-control date_choise" placeholder="Ngày" id="date" name="date" value="">
                                    </div>
                                    <div class="col-xs-12 col-sm-5 col-s">
                                        <select class="form-control" id="time" name="time">
                                            <option value="">--Thời gian--</option>
                                            <option value="00:00">00:00</option>
                                            <option value="00:30">00:30</option>
                                            <option value="01:00">01:00</option>
                                            <option value="01:30">01:30</option>
                                            <option value="02:00">02:00</option>
                                            <option value="02:30">02:30</option>
                                            <option value="03:00">03:00</option>
                                            <option value="03:30">03:30</option>
                                            <option value="04:00">04:00</option>
                                            <option value="04:30">04:30</option>
                                            <option value="05:00">05:00</option>
                                            <option value="05:30">05:30</option>
                                            <option value="06:00">06:00</option>
                                            <option value="06:30">06:30</option>
                                            <option value="07:00">07:00</option>
                                            <option value="07:30">07:30</option>
                                            <option value="08:00">08:00</option>
                                            <option value="08:30">08:30</option>
                                            <option value="09:00">09:00</option>
                                            <option value="09:30">09:30</option>
                                            <option value="10:00">10:00</option>
                                            <option value="10:30">10:30</option>
                                            <option value="11:00">11:00</option>
                                            <option value="11:30">11:30</option>
                                            <option value="12:00">12:00</option>
                                            <option value="12:30">12:30</option>
                                            <option value="13:00">13:00</option>
                                            <option value="13:30">13:30</option>
                                            <option value="14:00">14:00</option>
                                            <option value="14:30">14:30</option>
                                            <option value="15:00">15:00</option>
                                            <option value="15:30">15:30</option>
                                            <option value="16:00">16:00</option>
                                            <option value="16:30">16:30</option>
                                            <option value="17:00">17:00</option>
                                            <option value="17:30">17:30</option>
                                            <option value="18:00">18:00</option>
                                            <option value="18:30">18:30</option>
                                            <option value="19:00">19:00</option>
                                            <option value="19:30">19:30</option>
                                            <option value="20:00">20:00</option>
                                            <option value="20:30">20:30</option>
                                            <option value="21:00">21:00</option>
                                            <option value="21:30">21:30</option>
                                            <option value="22:00">22:00</option>
                                            <option value="22:30">22:30</option>
                                            <option value="23:00">23:00</option>
                                            <option value="23:30">23:30</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-s">
                                <input type="text" class="form-control" name="keyword" placeholder="Tên sân / đội bóng / khu vực...">
                            </div>
                            <div class="col-xs-12 col-md-2 col-s">
                                <button class="btn bg" type="submit" id="btnSearch" style="height: 34px;padding: 0"><i class="fa fa-search" aria-hidden="true"></i>Tìm</button>



                            </div>
                        </form>
                    </div>
                    <div class="link-w">
                        <a class="dateChoiceCss" href="#">Hôm nay <span class="colorCss">(32)</span></a>
                        <a class="dateChoiceCss" href="#">Ngày mai <span class="colorCss">(17)</span></a>
                        <a class="dateChoiceCss" href="#">05/08/2017 <span class="colorCss">(4)</span></a>
                        <a class="dateChoiceCss" href="#">06/08/2017 <span class="colorCss">(3)</span></a>
                        <a class="dateChoiceCss" href="#">07/08/2017 <span class="colorCss">(0)</span></a>
                    </div>

                </div>
                <div class="show-itemx">
                    <div class="news-list" id="page-new">
                        <ul id="Top" class="list-item-san ul">
                            <li class="item-card match-finding-item">
                                <div class="row">
                                    <div class="col-md-2 item-preview-image">
                                        <a href="#" title="FC  "><img class="img-responsive" src="#" align="thumbnail" alt="FC  "></a>
                                    </div>
                                    <div class="col-md-10 right-item-san right-item-doi">
                                        <div class="header-item-doi over">
                                            <h2>
                                                <a href="#">
                                                    <span>FC  </span> <span class="label label-success">Cần đi khách</span>
                                                </a>

                                            </h2>
                                            <div class="btn-doi-top pull-right">
                                                <button class="btn  bg btn-sm pull-right btn-invite-team-match btn-doi">
                                                    <i class="fa fa fa-gavel" aria-hidden="true"></i> Bắt đối ngay
                                                </button>
                                            </div>
                                        </div>
                                        <div class="divp">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="tim-doi-time">

                                                            <strong> 17h30 Thứ 5 Ngày 03/08/2017 </strong>
                                                        </p>

                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <p class="guest-stadium-list">
                                                            <strong>Khu vực: </strong>
                                                            <a href="#" target="_blank" class="label label-success">
                                                                Hai Bà Trưng
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p class="quost-doi">
                                                            Tìm đối tác t5 ngày 3/8 17h30 bóng lăn sân nguyễn phong sắc đại la.đội trung bình cam kết ko ebola.lh 0987511990
                                                        </p>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </li>
                            <!----=-----------------------end item ----------------------------->
                            <li class="item-card match-finding-item">
                                <div class="row">
                                    <div class="col-md-2 item-preview-image">
                                        <a href="#" title="FC  "><img class="img-responsive" src="#" align="thumbnail" alt="FC  "></a>
                                    </div>
                                    <div class="col-md-10 right-item-san right-item-doi">
                                        <div class="header-item-doi over">
                                            <h2>
                                                <a href="#">
                                                    <span>FC  </span> <span class="label label-success">Cần đi khách</span>
                                                </a>

                                            </h2>
                                            <div class="btn-doi-top pull-right">
                                                <button class="btn  bg btn-sm pull-right btn-invite-team-match btn-doi">
                                                    <i class="fa fa fa-gavel" aria-hidden="true"></i> Bắt đối ngay
                                                </button>
                                            </div>
                                        </div>
                                        <div class="divp">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="tim-doi-time">

                                                            <strong> 17h30 Thứ 5 Ngày 03/08/2017 </strong>
                                                        </p>

                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <p class="guest-stadium-list">
                                                            <strong>Khu vực: </strong>
                                                            <a href="#" target="_blank" class="label label-success">
                                                                Hai Bà Trưng
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p class="quost-doi">
                                                            Tìm đối tác t5 ngày 3/8 17h30 bóng lăn sân nguyễn phong sắc đại la.đội trung bình cam kết ko ebola.lh 0987511990
                                                        </p>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </li>
                            <!----=-----------------------end item ----------------------------->
                            <li class="item-card match-finding-item">
                                <div class="row">
                                    <div class="col-md-2 item-preview-image">
                                        <a href="#" title="FC  "><img class="img-responsive" src="#" align="thumbnail" alt="FC  "></a>
                                    </div>
                                    <div class="col-md-10 right-item-san right-item-doi">
                                        <div class="header-item-doi over">
                                            <h2>
                                                <a href="#">
                                                    <span>FC  </span> <span class="label label-success">Cần đi khách</span>
                                                </a>

                                            </h2>
                                            <div class="btn-doi-top pull-right">
                                                <button class="btn  bg btn-sm pull-right btn-invite-team-match btn-doi">
                                                    <i class="fa fa fa-gavel" aria-hidden="true"></i> Bắt đối ngay
                                                </button>
                                            </div>
                                        </div>
                                        <div class="divp">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="tim-doi-time">

                                                            <strong> 17h30 Thứ 5 Ngày 03/08/2017 </strong>
                                                        </p>

                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <p class="guest-stadium-list">
                                                            <strong>Khu vực: </strong>
                                                            <a href="#" target="_blank" class="label label-success">
                                                                Hai Bà Trưng
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p class="quost-doi">
                                                            Tìm đối tác t5 ngày 3/8 17h30 bóng lăn sân nguyễn phong sắc đại la.đội trung bình cam kết ko ebola.lh 0987511990
                                                        </p>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </li>
                            <!----=-----------------------end item ----------------------------->
                            <li class="item-card match-finding-item">
                                <div class="row">
                                    <div class="col-md-2 item-preview-image">
                                        <a href="#" title="FC  "><img class="img-responsive" src="#" align="thumbnail" alt="FC  "></a>
                                    </div>
                                    <div class="col-md-10 right-item-san right-item-doi">
                                        <div class="header-item-doi over">
                                            <h2>
                                                <a href="#">
                                                    <span>FC  </span> <span class="label label-success">Cần đi khách</span>
                                                </a>

                                            </h2>
                                            <div class="btn-doi-top pull-right">
                                                <button class="btn  bg btn-sm pull-right btn-invite-team-match btn-doi">
                                                    <i class="fa fa fa-gavel" aria-hidden="true"></i> Bắt đối ngay
                                                </button>
                                            </div>
                                        </div>
                                        <div class="divp">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="tim-doi-time">

                                                            <strong> 17h30 Thứ 5 Ngày 03/08/2017 </strong>
                                                        </p>

                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <p class="guest-stadium-list">
                                                            <strong>Khu vực: </strong>
                                                            <a href="#" target="_blank" class="label label-success">
                                                                Hai Bà Trưng
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p class="quost-doi">
                                                            Tìm đối tác t5 ngày 3/8 17h30 bóng lăn sân nguyễn phong sắc đại la.đội trung bình cam kết ko ebola.lh 0987511990
                                                        </p>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </li>
                            <!----=-----------------------end item ----------------------------->
                            <li class="item-card match-finding-item">
                                <div class="row">
                                    <div class="col-md-2 item-preview-image">
                                        <a href="#" title="FC  "><img class="img-responsive" src="#" align="thumbnail" alt="FC  "></a>
                                    </div>
                                    <div class="col-md-10 right-item-san right-item-doi">
                                        <div class="header-item-doi over">
                                            <h2>
                                                <a href="#">
                                                    <span>FC  </span> <span class="label label-success">Cần đi khách</span>
                                                </a>

                                            </h2>
                                            <div class="btn-doi-top pull-right">
                                                <button class="btn  bg btn-sm pull-right btn-invite-team-match btn-doi">
                                                    <i class="fa fa fa-gavel" aria-hidden="true"></i> Bắt đối ngay
                                                </button>
                                            </div>
                                        </div>
                                        <div class="divp">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="tim-doi-time">

                                                            <strong> 17h30 Thứ 5 Ngày 03/08/2017 </strong>
                                                        </p>

                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <p class="guest-stadium-list">
                                                            <strong>Khu vực: </strong>
                                                            <a href="#" target="_blank" class="label label-success">
                                                                Hai Bà Trưng
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p class="quost-doi">
                                                            Tìm đối tác t5 ngày 3/8 17h30 bóng lăn sân nguyễn phong sắc đại la.đội trung bình cam kết ko ebola.lh 0987511990
                                                        </p>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </li>
                            <!----=-----------------------end item ----------------------------->
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
