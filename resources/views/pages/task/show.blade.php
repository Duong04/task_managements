@extends('layouts.master-layout', ['title' => 'Admin - Chi tiết công việc'])
@section('css')
    <style>
        .btn-comment {
            max-width: 250px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 20px;
            background-color: #3858F6;
            color: #fff;
            border: 2px solid #3858F6;
            border-radius: 28px;
            cursor: pointer;
            transition: all ease 0.5s;
        }

        .btn-comment:hover {
            background-color: #fff;
            color: #3858F6;
        }

        .post-content img {
            width: 100%;
            border-radius: 1rem;
        }

        #emoji-picker,
        .emoji-picker {
            display: none;
            position: absolute;
            right: 0;
            z-index: 1000;
        }

        #emoji-button,
        .emoji-button {
            cursor: pointer;
            position: absolute;
            top: 10%;
            right: 10px;
        }

        #emoji-picker.above {
            bottom: 100%;
            margin-bottom: 5px;
        }

        #emoji-picker.below {
            top: 100%;
            margin-top: 5px;
        }

        .form-comment {
            width: 100%;
            height: 80px;
        }

        .form-comment textarea {
            width: 100%;
            height: 100%;
            transition: all ease 0.4s;
        }

        .form-comment textarea:focus {
            box-shadow: none;
            border: 1px solid #3858F6;
        }

        .form-comment button {
            border: none;
            color: #3858F6;
            background-color: transparent;
            font-size: 1.2rem;
            position: absolute;
            right: 10px;
            bottom: 10%;
        }

        .form-comment button:disabled {
            opacity: 0.7;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editTaskBtn');
            if (editButton) {
                editButton.addEventListener('click', function() {
                    toggleEdit(true);
                });
            }

            window.toggleEdit = function(enable) {
                document.getElementById('status-view').classList.toggle('d-none', enable);
                document.getElementById('status-edit').classList.toggle('d-none', !enable);
                document.getElementById('progress-view').classList.toggle('d-none', enable);
                document.getElementById('progress-edit').classList.toggle('d-none', !enable);
                document.getElementById('edit-buttons').classList.toggle('d-none', !enable);
            };
        });
    </script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script type="module" src="/js/comment.js"></script>
@endsection
@section('content')
    @php
        $status = [
            'not_started' => 'Chưa bắt đầu',
            'in_progress' => 'Đang thực hiện',
            'completed' => 'Hoàn thành',
        ];

        $priorities = [
            'low' => 'Thấp',
            'medium' => 'Trung bình',
            'high' => 'Cao',
        ];

        $status_color = [
            'not_started' => 'badge-gray',
            'in_progress' => 'badge-blue',
            'completed' => 'badge-green',
        ];

        $priority_color = [
            'low' => 'badge-green',
            'medium' => 'badge-yellow',
            'high' => 'badge-red',
        ];
    @endphp
    <div class="container">
        <div class="page-inner">
            <div class="page-header justify-content-between">
                <h3 class="fw-bold mb-3"><a href="{{ route('tasks.index') }}" class="me-1"><i
                            class="fas fa-arrow-left"></i></a> Chi tiết công việc</h3>
                <div class="col-8 d-flex justify-content-end align-items-start mb-3" style="gap: 10px;">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-outline-primary">✏️ Chỉnh sửa</a>
                    <form action="{{ route('tasks.delete', $task->id) }}" id="delete-form-{{ $task->id }}"
                        method="POST" class="d-inline" id="delete-form-{{ $task->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger delete">🗑️ Xóa</button>
                    </form>
                </div>
            </div>
            <div class="row pb-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="border rounded p-4 bg-white shadow-sm">
                            <div class="row">
                                <div class="col-md-6 mb-4"><span>Tên công việc:</span> <br>
                                    <strong>{{ $task->name ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-4"><span>Người giao việc:</span> <br>
                                    <strong>{{ $task->createdBy->name ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-4"><span>Người thực hiện:</span> <br>
                                    <strong>{{ $task->assignedTo->name ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-4"><span>Hạn hoàn thành:</span><br>
                                    <strong>{{ format_date($task->due_date) }}</strong>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <span>Mức độ ưu tiên:</span>
                                    <br>
                                    <strong
                                        class="badge-custom {{ $priority_color[$task->priority] }}">{{ $priorities[$task->priority] }}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span>Mô tả công việc:</span>
                                <div class="mt-1">{!! $task->description !!}</div>
                            </div>

                            <div>
                                <strong>Tệp đính kèm:</strong>
                                <div class="row mt-1">
                                    @foreach ($task->attachments as $file)
                                        <div class="col-4 mb-3">
                                            <div
                                                class="py-3 px-2 rounded border d-flex justify-content-between align-items-center">
                                                <a href="{{ $file->file_path }}" target="_blank"
                                                    class="d-inline-block text-truncate"
                                                    title="Xem tệp">{{ $file->file_path }}</a>
                                                <a href="{{ $file->file_path }}" target="_blank" download
                                                    class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        {{-- Bình luận --}}
                        <div class="border rounded p-4 bg-white shadow-sm mt-4">
                            <h6 class="mb-3">Thảo luận</h6>
                            <div id="comments">


                            </div>

                            <div>
                                <div class="position-relative form-comment">
                                    <textarea id="comment" data-type="task" data-id="{{ $task->id }}" class="form-control comment" name="comment"
                                        placeholder="Chia sẻ ý kiến của bạn tại đây"></textarea>
                                    <div id="emoji-button">
                                        <i class="fas fa-smile"></i>
                                        <div id="emoji-picker">
                                            <emoji-picker></emoji-picker>
                                        </div>
                                    </div>
                                    <button disabled id="btn-comment" class="btn-comment-2"><i
                                            class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-4 bg-white shadow-sm">
                            <h6 class="mb-3 d-flex justify-content-between align-items-center">
                                Tiến độ công việc
                                <button id="editTaskBtn" class="btn btn-sm text-success" data-bs-toggle="tooltip"
                                    title="Sửa"><i class="fa fa-edit"></i></button>
                            </h6>

                            <form id="updateTaskForm"
                                action="{{ route('tasks.update', ['id' => $task->id, 'redirect' => 'back']) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-2"><strong>Trạng thái:</strong>
                                    <span id="status-view"
                                        class="badge {{ $status_color[$task->status] }} text-dark">{{ $status[$task->status] }}</span>

                                    <select name="status" id="status-edit" class="form-select form-select-sm d-none mt-2">
                                        @foreach ($status as $key => $label)
                                            <option value="{{ $key }}" @selected($key == $task->status)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Tiến độ --}}
                                <div class="mb-2"><strong>Tiến độ hiện tại:</strong></div>
                                <div id="progress-view" class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>

                                </div>
                                <div class="text-end mt-1 small">{{ $task->progress }}%</div>

                                <div id="progress-edit" class="d-none">
                                    <input type="range" name="progress" class="form-range mt-2" min="0"
                                        max="100" value="{{ $task->progress }}"
                                        oninput="document.getElementById('progress-value').innerText = this.value + '%'">
                                    <div class="text-end small"><span id="progress-value">{{ $task->progress }}%</span>
                                    </div>
                                </div>

                                {{-- Nút hành động --}}
                                <div id="edit-buttons" class="d-none mt-3 text-end">
                                    <button type="button" class="btn btn-sm btn-secondary me-2"
                                        onclick="toggleEdit(false)">Hủy</button>
                                    <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
