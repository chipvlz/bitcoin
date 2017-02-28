@extends('layouts.master') @section('content')
<div id="content-container">
    <div class="block-deal">
        
        <!--<div id="banner-2">
            <div class="container-position">
                <div class="container">
                    <div class="row display-table">
                        <div class="table-cell">
                            <div class="content-text">
                                <h2>
                                    <span class="style-font">UY TÍN - TRÁCH NHIỆM - BẢO MẬT</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#banner-3" class="link link-style"></a>
        </div>-->
        <div id="banner-3">
            <div class="container-position">
                <div class="container">
                    <div class="row display-table">
                        <div ng-controller="buyBitCtrl as bb" class="table-cell col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            
                            <form ng-submit="bb.onSubmit()" name="bb.form" novalidate>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h1>GIÁ CHÚNG TÔI MUA:</h1><span id="weBuyPrice" >@{{$root.buyPriceDis}}</span>
                                    </div>
                                    <div class="panel-body">
                                        <formly-form model="bb.model" fields="bb.fields" options="bb.options" form="bb.form">

                                        </formly-form>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-primary submit-button" ng-disabled="bb.form.$invalid">BÁN</button>                                    
                                    </div>
                                </div>

                            </form>
                            <div class="table-cell col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <table>
                                    <tr>
                                        <td><img src="data:image/png;base64, @{{qr_code_add}}"/></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @{{address}}
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div ng-controller="sellBitCtrl as ss" class="table-cell col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <form ng-submit="ss.onSubmit()" name="ss.form" novalidate>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h1>GIÁ CHÚNG TÔI BÁN:</h1><span id="weSellPrice">@{{$root.sellPriceDis}}</span>
                                    </div>
                                    <div class="panel-body">
                                        <formly-form model="ss.model" fields="ss.fields" options="ss.options" form="ss.form">

                                        </formly-form>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-primary submit-button" ng-disabled="ss.form.$invalid">MUA</button>                                    
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#banner-4" class="link"></a>
        </div>
        <div id="banner-4">
            <div class="container-position">
                <div class="container">
                    <div class="content-text text-center">
                        <h2>
                            <span class="style-font-banner4">QUY TRÌNH MUA BÁN</span></h2>
                    </div>
                    <div class="row display-table">
                        <div class="table-cell col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="content-text">
                                <div class="text-center">
                                    <h3>
                                        BÁN BITCOIN</h3>
                                    <p>
                                        Xác nhận - Chuyển Bitcoin - Nhận tiền</p>
                                    <p>
                                        Bước 1: Liên hệ với Thành Bitcoin 0975 063 023</p>
                                    </br>
                                    <p>
                                        Bước 2: Chuyển Bitcoin vào địa chỉ ví sau đây (Đây là ví duy nhất mình dùng để giao
                                        dịch)</p>
                                    
                                    <p>
                                        1HznyzbeLJz3cQVf7Bo7Vi52vCQfJUQee4
                                    </p>
                                    </br>
                                    <p>
                                        Bước 3: Nhận tiền</p>
                                </div>
                            </div>
                        </div>
                        <div class="table-cell col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <img src="{{URL::asset('public/img/images/banner-4-2.png')}}" alt="">
                        </div>
                        <div class="table-cell col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="content-text">
                                <div class="text-center">
                                    <h3>
                                        MUA BITCOIN</h3>
                                    <p>
                                        Xác nhận - Chuyển tiền - Nhận Bitcoin</p>
                                    <p>
                                        Bước 1: Liên hệ với Thành Bitcoin 0975 063 023</p>
                                    </br>
                                    <p>
                                        Bước 2: Chuyển khoản theo nội dung: Tên - SDT vào STK bên dưới</p>
                                    </br>
                                    <img src="{{URL::asset('public/img/images/banner-4-3.png')}}" alt="">
                                    <p>
                                        0041000241991</p>
                                    <p>
                                        Hồ Văn Thành - VCB CN Ngũ Hành Sơn - Đà Nẵng</p>
                                    </br>
                                    <p>
                                        Bước 3: Nhận Bitcoin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#banner-5" class="link link-style"></a>
        </div>
        <div id="banner-5">
            <div class="container-position">
                <div class="container">
                    <div class="row display-table">
                        <div class="table-cell">
                            <div class="content-text text-center">
                                <h2>
                                    <span class="style-font-banner5">KẾT BẠN VỚI TÔI</span></h2>
                                <p>
                                    Để giao dịch an toàn, khách hàng chỉ liên hệ qua các kênh sau</p>
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <ul>
                                            <li><a href="https://www.facebook.com/thanhbitcoin" target="_blank">
                                                    <img src="{{URL::asset('public/img/images/facebook.png')}}" alt="facebook">
                                                    <span>Thành Bitcoin</span> </a></li>
                                            <li><a href="https://telegram.me/thanhbitcoin" target="_blank">
                                                    <img src="{{URL::asset('public/img/images/telegram.png')}} " alt="telegram">
                                                    <span>https://telegram.me/thanhbitcoin</span> </a></li>
                                            <li><a href="tel:0975063023">
                                                    <img src="{{URL::asset('public/img/images/phone.png')}} " alt="phone">
                                                    <span>0975 063 023</span> </a></li>
                                            <li><a href="tel:0975063023">
                                                    <img src="{{URL::asset('public/img/images/zalo.png')}}" alt="zalo">
                                                    <span>0975 063 023</span> </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection