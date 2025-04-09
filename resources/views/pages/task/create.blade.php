@extends('layouts.master-layout')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/ckeditor5-premium-features.css" />
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/",
            "ckeditor5-premium-features": "https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/ckeditor5-premium-features.js",
            "ckeditor5-premium-features/": "https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/"
        }
    }
</script>
<link rel="stylesheet" href="/assets/master/vendor/ckeditor5.css">
<script type="module" src="/assets/master/vendor/ckeditor5.js"></script>
@endsection
@section('content')
    @php
        $status_projects = [
            'not_started' => 'Chưa bắt đầu',
            'in_progress' => 'Đang thực hiện',
            'completed' => 'Đã hoàn thành',
        ];
    @endphp
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Tạo công việc</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="">Quản lý công việc</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Tạo công việc</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <form class="row col-12" action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên công việc</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" id="name" name="name"
                            placeholder="Tên công việc" />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('project_id') ? ' has-error' : '' }}">
                        <label for="project_id">Chọn dự án</label>
                        <select class="form-control" name="project_id" id="project_id">
                            <option value="">-- Chọn dự án --</option>
                            @foreach ($projects as $item)
                                <option {{ old('project_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                    {{ $item->name }} ({{ $status_projects[$item->status] }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('project_id'))
                            <span class="text-danger fs-7">{{ $errors->first('project_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('assigned_to') ? ' has-error' : '' }}">
                        <label for="assigned_to">Người thực hiện</label>
                        <select class="form-control" name="assigned_to" id="assigned_to">
                            <option value="">-- Người thực hiện --</option>
                            @foreach ($users as $item)
                                <option {{ old('assigned_to') == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }} ({{ $item->role->name }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('assigned_to'))
                            <span class="text-danger fs-7">{{ $errors->first('assigned_to') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('priority') ? ' has-error' : '' }}">
                        <label for="priority">Mức độ ưu tiên</label>
                        <select class="form-control" name="priority" id="priority">
                            <option value="">-- Chọn độ ưu tiên --</option>
                            <option {{ old('priority') == 'low' ? 'selected' : '' }} value="low">Thấp</option>
                            <option {{ old('priority') == 'medium' ? 'selected' : '' }} value="medium">Trung bình</option>
                            <option {{ old('priority') == 'high' ? 'selected' : '' }} value="high">Cao</option>
                        </select>
                        @if ($errors->first('priority'))
                            <span class="text-danger fs-7">{{ $errors->first('priority') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('start_date') ? ' has-error' : '' }}">
                        <label for="start_date">Ngày bắt đầu</label>
                        <input value="{{ old('start_date') }}" type="date" class="form-control" id="start_date"
                            name="start_date" />
                        @if ($errors->first('start_date'))
                            <span class="text-danger fs-7">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('end_date') ? ' has-error' : '' }}">
                        <label for="end_date">Ngày kết thúc</label>
                        <input value="{{ old('end_date') }}" type="date" class="form-control" id="end_date"
                            name="end_date" />
                        @if ($errors->first('end_date'))
                            <span class="text-danger fs-7">{{ $errors->first('end_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-8 {{ $errors->first('description') ? ' has-error' : '' }}">
                        <label for="description">Mô tả</label>
                        <textarea name="description" class="form-control" placeholder="Mô tả" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    @php
                        $attachments = old('attachments', [ ['description' => '', 'file' => null] ]);
                    @endphp
                    <div class="form-group col-4">
                        <label>Tệp đính kèm</label>
                        <div id="attachment-wrapper">
                            @foreach ($attachments as $index => $attachment)
                                <div class="row d-flex flex-column mb-2 attachment-item py-2" data-index="{{ $index }}">
                                    <div class="col-md-12 d-flex align-items-center mb-2">
                                        <div class="text-danger me-2 cursor-pointer btn-remove">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <div class="text-primary cursor-pointer btn-plus add-attachment">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-12 my-2">
                                        <input type="text" name="attachments[{{ $index }}][description]" class="form-control"
                                            value="{{ $attachment['description'] }}" placeholder="Mô tả tệp" />
                                        @error("attachments.$index.description")
                                            <span class="text-danger fs-7">{{ $message }}</span>
                                        @enderror
                                    </div>
                    
                                    <div class="col-md-12">
                                        <label class="upload-box w-100 text-center">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-purple"></i><br>
                                            <span class="text-purple">Upload File</span>
                                            <small class="file-name text-muted text-truncate d-block mt-1"></small>
                                            <input type="file" name="attachments[{{ $index }}][file]"
                                                class="form-control upload-input" hidden />
                                        </label>
                                        @error("attachments.$index.file")
                                            <span class="text-danger fs-7">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 form-group">
                        <button class="btn btn-primary">Thêm ngay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let wrapper = document.getElementById("attachment-wrapper");
    
            // Cập nhật index hiện tại dựa theo phần tử cuối
            let index = wrapper.querySelectorAll(".attachment-item").length;
    
            // Thêm file mới
            wrapper.addEventListener("click", function (e) {
                if (e.target.closest(".add-attachment")) {
                    let newItem = document.createElement("div");
                    newItem.classList.add("row", "d-flex", "flex-column", "mb-2", "attachment-item", "py-2");
                    newItem.setAttribute("data-index", index);
    
                    newItem.innerHTML = `
                        <div class="col-md-12 d-flex align-items-center mb-2">
                            <div class="text-danger me-2 cursor-pointer btn-remove">
                                <i class="fas fa-trash"></i>
                            </div>
                            <div class="text-primary cursor-pointer btn-plus add-attachment">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="col-md-12 my-2">
                            <input type="text" name="attachments[${index}][description]" class="form-control" placeholder="Mô tả tệp" />
                        </div>
                        <div class="col-md-12">
                            <label class="upload-box w-100 text-center">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-purple"></i><br>
                                <span class="text-purple">Upload File</span>
                                <small class="file-name text-muted text-truncate d-block mt-1"></small>
                                <input type="file" name="attachments[${index}][file]" class="form-control upload-input" hidden />
                            </label>
                        </div>
                    `;
    
                    wrapper.appendChild(newItem);
                    index++;
                }
            });
    
            // Xoá file
            wrapper.addEventListener("click", function (e) {
                if (e.target.closest(".btn-remove")) {
                    let item = e.target.closest(".attachment-item");
                    if (item) item.remove();
                }
            });
    
            // Hiển thị tên file khi chọn
            wrapper.addEventListener("change", function (e) {
                if (e.target.matches(".upload-input")) {
                    let fileInput = e.target;
                    let fileName = fileInput.files[0]?.name || '';
                    fileInput.closest("label").querySelector(".file-name").textContent = fileName;
                }
            });
        });
    </script>
    
@endsection
