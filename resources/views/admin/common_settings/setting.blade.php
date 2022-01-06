@extends('common.template')
@section('style')
    <style>
        .normal-item {
            width: 7rem;
        }

        .normal-btn {
            margin-left: 2rem;
        }

        .cruosel {
            display: table;
            margin-left: 8.8rem;
            margin-top: 1rem;
        }

        .urlInput {
            width: 12.9rem;
        }

    </style>
@endsection

@section('content')

    <div class="layui-container">
        <div class="layuimini-main">
            <form class="layui-form" action="" onsubmit="return false">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px; border-color: grey;">
                    <legend>前台：顶部图片上传</legend>
                </fieldset>
                <br>
                <div class="layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">首页logo</label>
                        <div class="layui-upload-drag" id="logo">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台左边logo</p>
                            <input type='hidden' id="logoData" name="logo" value="{{ $logo['logo'] ?? '' }}">
                            <div class="layui-hide" id='uploadView'>
                                <hr>
                                <img src="{{ $logo['logo'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">首页右上方图片</label>
                        <div class="layui-upload-drag" id="searchBtn">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="searchBtnData" name="searchBtn"
                                value="{{ $logo['searchBtn'] ?? '' }}">
                            <div class="layui-hide" id='searchBtnView'>
                                <hr>
                                <img src="{{ $logo['searchBtn'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                </div>

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px; border-color: grey;">
                    <legend>前台：轮播图上传</legend>
                </fieldset>
                <br>
                <div class="layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">第一张轮播图</label>
                        <div class="layui-input-inline urlInput">
                            <input type="text" name="1Url" placeholder="图片跳转路径" value="{{ $logo['1Url'] ?? '' }}"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-upload-drag cruosel" id="1Wall">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="1WallData" name="1Wall" value="{{ $logo['1Wall'] ?? '' }}">
                            <div class="layui-hide" id='1View'>
                                <hr>
                                <img src="{{ $logo['1Wall'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">第二张轮播图</label>
                        <div class="layui-input-inline urlInput">
                            <input type="text" name="2Url" placeholder="图片跳转路径" value="{{ $logo['2Url'] ?? '' }}"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-upload-drag cruosel" id="2Wall">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="2WallData" name="2Wall" value="{{ $logo['2Wall'] ?? '' }}">
                            <div class="layui-hide" id='2View'>
                                <hr>
                                <img src="{{ $logo['2Wall'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">第三张轮播图</label>
                        <div class="layui-input-inline urlInput">
                            <input type="text" name="3Url" placeholder="图片跳转路径" value="{{ $logo['3Url'] ?? '' }}"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-upload-drag cruosel" id="3Wall">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="3WallData" name="3Wall" value="{{ $logo['3Wall'] ?? '' }}">
                            <div class="layui-hide" id='3View'>
                                <hr>
                                <img src="{{ $logo['3Wall'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">第四张轮播图</label>
                        <div class="layui-input-inline urlInput">
                            <input type="text" name="4Url" placeholder="图片跳转路径" value="{{ $logo['4Url'] ?? '' }}"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-upload-drag cruosel " id="4Wall">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="4WallData" name="4Wall" value="{{ $logo['4Wall'] ?? '' }}">
                            <div class="layui-hide" id='4View'>
                                <hr>
                                <img src="{{ $logo['4Wall'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">第五张轮播图</label>
                        <div class="layui-input-inline urlInput">
                            <input type="text" name="5Url" placeholder="图片跳转路径" value="{{ $logo['5Url'] ?? '' }}"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-upload-drag cruosel" id="5Wall">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="5WallData" name="5Wall" value="{{ $logo['5Wall'] ?? '' }}">
                            <div class="layui-hide" id='5View'>
                                <hr>
                                <img src="{{ $logo['5Wall'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label required normal-item">第六张轮播图</label>
                        <div class="layui-input-inline urlInput">
                            <input type="text" name="6Url" placeholder="图片跳转路径" value="{{ $logo['6Url'] ?? '' }}"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-upload-drag cruosel" id="6Wall">
                            <i class="layui-icon"></i>
                            <p>点击上传, 前台右边图标</p>
                            <input type='hidden' id="6WallData" name="6Wall" value="{{ $logo['6Wall'] ?? '' }}">
                            <div class="layui-hide" id='6View'>
                                <hr>
                                <img src="{{ $logo['6Wall'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        @if (checkAuth('event_add'))
                            <button class="layui-btn layui-btn-normal normal-btn" lay-submit
                                lay-filter="saveBtn">提交</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('static/upload/upload.js') }}" charset="utf-8"></script>
    <script>
        var logo = "{{ $logo['logo'] ?? '' }}";
        var searchBtn = "{{ $logo['searchBtn'] ?? '' }}";
        var fWall = "{{ $logo['1Wall'] ?? '' }}";
        var sWall = "{{ $logo['2Wall'] ?? '' }}";
        var tWall = "{{ $logo['3Wall'] ?? '' }}";
        var foWall = "{{ $logo['4Wall'] ?? '' }}";
        var fifWall = "{{ $logo['5Wall'] ?? '' }}";
        var sixWall = "{{ $logo['6Wall'] ?? '' }}";
        if ("" !== logo) {
            layui.$('#uploadView').removeClass('layui-hide');
        }
        if ("" !== searchBtn) {
            layui.$('#searchBtnView').removeClass('layui-hide');
        }
        if ("" !== fWall) {
            layui.$('#1View').removeClass('layui-hide');
        }
        if ("" !== sWall) {
            layui.$('#2View').removeClass('layui-hide');
        }
        if ("" !== tWall) {
            layui.$('#3View').removeClass('layui-hide');
        }
        if ("" !== foWall) {
            layui.$('#4View').removeClass('layui-hide');
        }
        if ("" !== fifWall) {
            layui.$('#5View').removeClass('layui-hide');
        }
        if ("" !== sixWall) {
            layui.$('#6View').removeClass('layui-hide');
        }
  
        var uploader = "{{ route('admin_logo_upload') }}";
        var searchBtn = "{{ route('admin_btn_confirm') }}";
        var cruosel = "{{ route('admin_cruosel_confirm') }}";
        var save = "{{ route('admin_index_confirm') }}";
    </script>
@endsection
