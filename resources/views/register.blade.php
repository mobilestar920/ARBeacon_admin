@extends('layouts.app')

@section('head')

<style type="text/css">
	.container {
        max-width: 450px;
    }
</style>
<script src="{{ asset('js/login.js') }}"></script>

@endsection

@section('content')
<div>
    <form name="frm" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="card card-login">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="form-header info-color">
                            <h3 class="mt-2">
                                <b>登録</b>
                            </h3>
                        </div>
                        <div class="md-form">
                            <input type="text" id="name" name="name" class="form-control" placeholder="ユーザー名">
                        </div>
                        <div class="md-form">
                            <input type="text" id="email" name="email" class="form-control" placeholder="メール">
                        </div>
                        <div class="md-form">
                            <input type="password" id="password" name="password" class="form-control" placeholder="パスワード">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-info waves-effect waves-light" type="submit" style="color: #17a2b8 !important; background-color: white;">登録</button>
                        </div>
                        <div class="text-center" style="color: #ffffff;">
                            --------
                        </div>
                        <div class="text-center">
                            <a style="color: #17a2b8 !important;" href="{{ route('login') }}">ログイン</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection