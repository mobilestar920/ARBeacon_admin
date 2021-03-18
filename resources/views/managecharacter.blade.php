@extends('layouts.master')

@section('head')
<script src="{{ asset('js/managecharacter.js') }}"></script>
@endsection

@section('content')
<div>
    <div class="sidebar">
        <div class="sidebar-inner">
            <!-- ### $Sidebar Header ### -->
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="index.html">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img src="assets/static/images/logo.png" alt="">
                                    </div>
                                </div>
                                <div class="peer peer-greed">
                                    <h5 class="lh-1 mB-0 logo-text">Admin</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ### $Sidebar Menu ### -->
            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 actived">
                    <a class="sidebar-link" href="{{ url('/beacon') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-mobile"></i>
                        </span>
                        <span class="title">비콘관리</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/character') }}">
                        <span class="icon-holder">
                            <i class="c-brown-500 ti-shift-right"></i>
                        </span>
                        <span class="title">캐랙관리</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/logout') }}">
                        <span class="icon-holder">
                            <i class="c-deep-red-500 ti-export"></i>
                        </span>
                        <span class="title">로그아웃</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                <ul class="nav-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                            <div class="peer mR-10">
                                <img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                            </div>
                            <div class="peer">
                                <span class="fsz-sm c-grey-900">{{ Auth::user()->user_id }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu fsz-sm">
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                    <i class="ti-power-off mR-10"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <main class='main-content bgc-grey-100'>
            <div id='mainContent'>
                <div class="container-fluid">
                    <h4 class="c-grey-900 mT-10 mB-30">캐랙터목록</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <form style="display: flex">
                                    <h4 class="c-grey-900 mB-20" style="flex: 1 1 auto;"></h4>
                                    <button class="btn btn-danger" type="button" style="margin-bottom: 20px !important;" id="btn_new_resource">추가</button>
                                </form>
                                <table id="dataTable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>이름</th>
                                            <th>크기(배수)</th>
                                            <th>이동반경(m)</th>
                                            <th>현시높이(m)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($characters as $i=>$character)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $character['name'] }}</td>
                                            <td>{{ $character['size'] }} </td>
                                            <td>{{ $character['radius'] }}</td>
                                            <td>{{ $character['altitude']}}</td>
                                            <td>
                                                <div class="peers mR-15">
                                                    <div class="peer">
                                                        <span id="edit_character" class="td-n c-blue-400 cH-grey-400 fsz-def p-5" data-id="{{ $character['id'] }}" data-name="{{ $character['name'] }}"  data-size="{{ $character['size'] }}"  data-radius="{{ $character['radius'] }}"  data-altitude="{{ $character['altitude'] }}">
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                        <span id="delete_character" class="td-n c-grey-400 cH-blue-400 fsz-def p-5" data-id="{{ $character['id'] }}">
                                                            <i class="fa fa-trash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="modal" id="modal_edit_character">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="bd p-15">
                        <h5 class="m-0">캐랙변경</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('edit_character') }}" enctype="multipart/form-data">
                            @csrf
                            <h5 class="mt-1 mb-2" id="modalProfileLabel"></h5>
                            <div class="form-group" style="visibility: hidden; max-height: 0px;">
                                <label class="fw-500">Id</label>
                                <input type="text" class="form-control" id="character_id" name="character_id" placeholder="App ID">
                            </div>
                            <div class="form-group">
                                <label for="app_name">이름</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="이름을 입력하시요">
                            </div>
                            <div class="form-group">
                                <label for="app_name">크기</label>
                                <input type="text" class="form-control" id="size" name="size" placeholder="배수를 입력하시오">
                            </div>
                            <div class="form-group">
                                <label for="app_name">이동반경</label>
                                <input type="text" class="form-control" id="radius" name="radius" placeholder="최대 30m">
                            </div>
                            <div class="form-group">
                                <label for="app_name">현시높이</label>
                                <input type="text" class="form-control" id="altitude" name="altitude" placeholder="높이를 입력하시오.">
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary cur-p" id="btn_update" type="submit">저장</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="new_character">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="bd p-15">
                        <h5 class="m-0">캐랙등록</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('add_character') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="visibility: hidden; max-height: 0px;">
                                <label class="fw-500">Id</label>
                                <input type="text" class="form-control" id="character_id" name="character_id" placeholder="App ID">
                            </div>
                            <h5 class="mt-1 mb-2" id="modalProfileLabel"></h5><div class="form-group">
                                <label for="app_name">이름</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="이름을 입력하시요">
                            </div>
                            <div class="form-group">
                                <label for="app_name">크기(배수)</label>
                                <input type="text" class="form-control" id="size" name="size" placeholder="배수를 입력하시오">
                            </div>
                            <div class="form-group">
                                <label for="app_name">이동반경(m)</label>
                                <input type="text" class="form-control" id="radius" name="radius" placeholder="최대 30m">
                            </div>
                            <div class="form-group">
                                <label for="app_name">현시높이(m)</label>
                                <input type="text" class="form-control" id="altitude" name="altitude" placeholder="높이를 입력하시오.">
                            </div>
                            <div class="form-group">
                                <label for="file">화일</label>
                                <input type="file" class="form-control" style="border: 1px solid #00000000; padding: 0.375rem 0" id="file" name="file" />
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary cur-p" id="btn_update" type="submit">저장</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection