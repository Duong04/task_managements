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
                <form class="row col-12" action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên công việc</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" id="name" name="name"
                            placeholder="Tên công việc" />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('project') ? ' has-error' : '' }}">
                        <label for="project">Chọn dự án</label>
                        <select class="form-control" name="project" id="project">
                            <option value="">-- Chọn dự án --</option>
                            @foreach ($projects as $item)
                                <option {{ old('project') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                    {{ $item->name }} ({{ $status_projects[$item->status] }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('project'))
                            <span class="text-danger fs-7">{{ $errors->first('project') }}</span>
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
                        <textarea name="description" class="form-control" placeholder="Mô tả" id="description" cols="30" rows="10">{{ old('value') }}</textarea>
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4">
                        <label>Tệp đính kèm</label>
                        <div id="attachment-wrapper">
                            <div class="row d-flex flex-column mb-2 attachment-item py-2">
                                <div class="col-md-12 d-flex align-items-center">
                                    <div class="text-danger">
                                        <i class="fas fa-trash btn-remove"></i>
                                    </div>
                                    <div class="text-primary ms-2">
                                        <i class="fas fa-plus btn-plus add-attachment"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="text" name="attachments[0][description]" class="form-control"
                                        placeholder="Mô tả tệp" />
                                </div>
                                <div class="col-md-12">
                                    <label class="upload-box w-100 text-center">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-purple"></i><br>
                                        <span class="text-purple">Upload File</span>
                                        <input type="file" name="attachments[0][file]" class="form-control upload-input"
                                            hidden />
                                    </label>
                                </div>
                            </div>
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
        let attachmentIndex = 1;

        // Hàm tạo HTML cho 1 item mới
        function createAttachmentItem(index) {
            const newItem = document.createElement('div');
            newItem.classList.add('row', 'd-flex', 'flex-column', 'mb-2', 'attachment-item', 'py-2');
            newItem.innerHTML = `
                <div class="col-md-12 d-flex align-items-center">
                    <div class="text-danger">
                        <i class="fas fa-trash btn-remove" style="cursor:pointer;"></i>
                    </div>
                    <div class="text-primary ms-2">
                        <i class="fas fa-plus btn-plus add-attachment" style="cursor:pointer;"></i>
                    </div>
                </div>
                <div class="col-md-12 my-2">
                    <input type="text" name="attachments[${index}][description]" class="form-control" placeholder="Mô tả tệp" />
                </div>
                <div class="col-md-12">
                    <label class="upload-box w-100 text-center">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-purple"></i><br>
                        <span class="text-purple">Upload File</span>
                        <input type="file" name="attachments[${index}][file]" class="form-control upload-input" hidden />
                    </label>
                </div>
            `;
                    return newItem;
        }

        // Ủy quyền sự kiện click trên toàn bộ wrapper
        document.getElementById('attachment-wrapper').addEventListener('click', function(e) {
            const target = e.target;

            // Nếu là nút xóa
            if (target.classList.contains('btn-remove')) {
                target.closest('.attachment-item').remove();
            }

            // Nếu là nút thêm
            if (target.classList.contains('add-attachment')) {
                const wrapper = document.getElementById('attachment-wrapper');
                const newItem = createAttachmentItem(attachmentIndex++);
                wrapper.appendChild(newItem);
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.attachment-item').remove();
            }
        });
    </script>
@endsection
