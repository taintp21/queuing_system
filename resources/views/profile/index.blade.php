@extends('layouts.app')
@section('web-title') {{ $profile->name }} | Tài khoản cá nhân @stop
@section('breadcrumbs', 'Thông tin cá nhân')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('dropzone/dropzone.min.css') }}" type="text/css" />
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-6 col-md-12 profile-image">
                            <div class="mb-3 text-center" id="dropzone">
                                <form method="POST" action="{{ route('dropzone', ['id'=>$profile->id]) }}" enctype="multipart/form-data" class="dropzone" id="file-upload">
                                    @csrf
                                </form>
                                <h4 class="fw-bold">{{ $profile->name }}</h4>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-6 col-md-12 position-relative">
                            <div class="row vertical-center">
                                <div class="col-lg-6 col-md-6 mb-4">
                                    <label for="name">Tên người dùng</label>
                                    <input type="text" class="form-control" id="name" disabled value="{{ $profile->name }}">
                                </div>
                                <div class="col-lg-6 col-md-6 mb-4">
                                    <label for="username">Tên đăng nhập</label>
                                    <input type="text" class="form-control" id="username" disabled value="{{ $profile->username }}">
                                </div>
                                <div class="col-lg-6 col-md-6 mb-4">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="number" class="form-control" id="phone" disabled value="{{ $profile->phone }}">
                                </div>
                                <div class="col-lg-6 col-md-6 mb-4">
                                    <label for="password">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" disabled value="{{ $profile->password }}">
                                </div>
                                <div class="col-lg-6 col-md-6 mb-4">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="password" disabled value="{{ $profile->email }}">
                                </div>
                                <div class="col-lg-6 col-md-6 mb-4">
                                    <label for="role">Vai trò</label>
                                    <input type="text" class="form-control" id="role" disabled value="{{ DB::table('roles')->select('role_name')->where('id',$profile->roles_id)->first()->role_name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts')
<script src="{{ asset('dropzone/dropzone.min.js') }}"></script>
    <script>
        Dropzone.options.fileUpload = {
            maxFilesize:10,
            autoProcessQueue: true,
            filesizeBase: 1500,
            maxFiles: 1,
            acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp",
            thumbnailWidth: 300,
            thumbnailHeight: 300,
            clickable: "#dropzone",
            init: function() {
                let myDropzone = this;

                myDropzone.on('addedfile', function(file) {
                    while ( this.files.length > this.options.maxFiles ) this.removeFile(this.files[0]);
                });
                myDropzone.on("thumbnail", function(file, dataUrl) {
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
                });
                @if ($profile->avatar != null)
                    // If the thumbnail is already in the right size on your server:
                    let mockFile = { name: "{{ $profile->avatar }}"};
                    let callback = null; // Optional callback when it's done
                    let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
                    let resizeThumbnail = true; // Tells Dropzone whether it should resize the image first
                    myDropzone.displayExistingFile(mockFile, "/storage/images/avatar/{{ $profile->avatar }}", callback, crossOrigin, resizeThumbnail);
                    myDropzone.options.thumbnail.call(this, mockFile, mockFile.url);
                    myDropzone.files = [mockFile];
                    this.on('success', function(file, message) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
                @endif
            },
        }
    </script>
@stop
