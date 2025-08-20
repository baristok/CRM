@extends('layouts.index')

@section('title', $note->title)

@section('css')

@endsection

@section('content')

    {{-- Hata mesajları --}}
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>{{ session('error') }}</h4><p class="text-muted mx-4 mb-0">{{ session('error_message') }}</p></div></div>',
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{ __('leads.okey') }}",
                    buttonsStyling: false,
                    showCloseButton: true
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>{{ session('success') }}</h4><p class="text-muted mx-4 mb-0">{{ session('success_message') }}</p></div></div>',
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-success w-xs mb-1"
                    },
                    cancelButtonText: "{{ __('leads.okey') }}",
                    buttonsStyling: false,
                    showCloseButton: true
                });
            });
        </script>
    @endif
    {{-- Hata mesajları sonu --}}


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">{{ __('notes.note_details') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('notes.notes') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('notes.note_details') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xxl-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title mb-3 flex-grow-1 text-start">{{ __('notes.time_tracking') }}</h6>
                            <div class="mb-2">
                                <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop"
                                    colors="primary:#8c68cd,secondary:#4788ff" style="width:90px;height:90px"></lord-icon>
                            </div>
                            <h3 class="mb-1" id="elapsed-time">Hesaplanıyor...</h3>
                            <h5 class="fs-14 mb-4">{{ $note->title }}</h5>
                            <div class="hstack gap-2 justify-content-center">
                                <button class="btn btn-secondary btn-sm" disabled><i
                                        class="ri-time-line align-bottom me-1"></i>
                                    {{ __('notes.time_tracking') }}</button>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-4">
                                {{-- <select class="form-control" name="choices-single-default" data-choices data-choices-search-false>
                                <option value="">Select Task board</option>
                                <option value="Unassigned">Unassigned</option>
                                <option value="To Do">To Do</option>
                                <option value="Inprogress">Inprogress</option>
                                <option value="In Reviews" selected>In Reviews</option>
                                <option value="Completed">Completed</option>
                            </select> --}}
                            </div>
                            <div class="table-card">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium">{{ __('notes.note_no') }}</td>
                                            <td>#{{ $noteNo }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">{{ __('notes.note_title') }}</td>
                                            <td>{{ $note->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">{{ __('notes.priority') }}</td>
                                            <td>
                                                @if (auth()->id() === $note->user_id)
                                                    <span class="badge {{ $note->priority_badge_class }}"
                                                        id="priority-badge" style="cursor:pointer;"
                                                        onclick="enablePriorityEdit()">
                                                        {{ $note->priority_label }}
                                                    </span>

                                                    <form id="priority-edit-form"
                                                        action="{{ route('notes.updatePriority', $note->id) }}"
                                                        method="POST" style="display:none; margin-top:5px;">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-light btn-sm">
                                                                {{ $note->priority_label }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split"
                                                                data-bs-toggle="dropdown" aria-expanded="false"></button>

                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <button type="submit" name="priority" value="low"
                                                                        @class(['dropdown-item', 'active' => $note->priority === 'low'])
                                                                        aria-current="{{ $note->priority === 'low' ? 'true' : 'false' }}">
                                                                        {{ __('notes.low') }}
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button type="submit" name="priority" value="medium"
                                                                        @class(['dropdown-item', 'active' => $note->priority === 'medium'])
                                                                        aria-current="{{ $note->priority === 'medium' ? 'true' : 'false' }}">
                                                                        {{ __('notes.medium') }}
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button type="submit" name="priority" value="high"
                                                                        @class(['dropdown-item', 'active' => $note->priority === 'high'])
                                                                        aria-current="{{ $note->priority === 'high' ? 'true' : 'false' }}">
                                                                        {{ __('notes.high') }}
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button type="submit" name="priority" value="critical"
                                                                        @class(['dropdown-item', 'active' => $note->priority === 'critical'])
                                                                        aria-current="{{ $note->priority === 'critical' ? 'true' : 'false' }}">
                                                                        {{ __('notes.critical') }}
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-icon btn-sm waves-effect waves-light"
                                                            onclick="cancelPriorityEdit()"><i
                                                                class="ri-refresh-line"></i></button>
                                                    </form>

                                                    <script>
                                                        function enablePriorityEdit() {
                                                            document.getElementById('priority-badge').style.display = 'none';
                                                            document.getElementById('priority-edit-form').style.display = 'inline-block';
                                                        }

                                                        function cancelPriorityEdit() {
                                                            document.getElementById('priority-edit-form').style.display = 'none';
                                                            document.getElementById('priority-badge').style.display = 'inline-block';
                                                        }
                                                    </script>
                                                @else
                                                    <span class="badge {{ $note->priority_badge_class }}">
                                                        {{ $note->priority_label }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">{{ __('notes.status') }}</td>
                                            @if ($note->progress == 0)
                                                <td><span
                                                        class="badge border border-secondary text-secondary">{{ __('notes.not_started') }}</span>
                                                </td>
                                            @elseif ($note->progress == 100)
                                                1
                                                <td><span
                                                        class="badge border border-success text-success">{{ __('notes.completed') }}</span>
                                                </td>
                                            @else
                                                <td><span
                                                        class="badge border border-warning text-warning">{{ __('notes.in_progress') }}</span>
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">{{ __('notes.due_date') }}</td>
                                            <td>{{ $note->due_date ? $note->due_date->format('d.m.Y') : 'Belirtilmedi' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <h6 class="card-title mb-0 flex-grow-1">{{ __('notes.assigned_to') }}</h6>
                                {{-- <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inviteMembersModal"><i class="ri-share-line me-1 align-bottom"></i> Assigned Member</button>
                            </div> --}}
                            </div>
                            <ul class="list-unstyled vstack gap-3 mb-0">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}" alt=""
                                                class="avatar-xs rounded-circle">
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-1">{{ $note->user->name }}</h6>
                                            <p class="text-muted mb-0">{{ $note->user->email }}</p>
                                        </div>
                                        {{-- <div class="flex-shrink-0">
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill text-muted me-2 align-bottom"></i>View</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-fill text-muted me-2 align-bottom"></i>Favorite</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </div> --}}
                                    </div>
                            </ul>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ __('notes.attachments') }}</h5>
                            <div class="vstack gap-2">
                                @if (!$isPrivate)
                                    <form action="{{ route('notes.storeAttachment') }}" method="POST"
                                        enctype="multipart/form-data" class="mb-2 d-flex align-items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="note_id" value="{{ $note->id }}">
                                        <input type="file" name="file" class="form-control" required>
                                        <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                    </form>

                                    @forelse ($note->attachments as $attachment)
                                        @php
                                            $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                            $icon = 'ri-file-2-line';
                                            if (in_array($ext, ['zip', 'rar', '7z'])) {
                                                $icon = 'ri-folder-zip-line';
                                            } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                                $icon = 'ri-file-ppt-2-line';
                                            } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                                $icon = 'ri-file-excel-2-line';
                                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                                $icon = 'ri-file-word-2-line';
                                            } elseif (in_array($ext, ['pdf'])) {
                                                $icon = 'ri-file-pdf-2-line';
                                            } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                                                $icon = 'ri-image-2-line';
                                            } elseif (in_array($ext, ['mp4', 'mov', 'mkv'])) {
                                                $icon = 'ri-video-line';
                                            } elseif (in_array($ext, ['mp3', 'wav', 'ogg'])) {
                                                $icon = 'ri-music-2-line';
                                            }

                                            $size = (int) $attachment->size;
                                            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                            $factor = $size > 0 ? floor((strlen($size) - 1) / 3) : 0;
                                            $human =
                                                $size > 0
                                                    ? sprintf('%.1f', $size / pow(1024, $factor)) . $units[$factor]
                                                    : '0B';
                                        @endphp

                                        <div class="border rounded border-dashed p-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm">
                                                        <div class="avatar-title bg-light text-primary rounded fs-24">
                                                            <i class="{{ $icon }}"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="fs-13 mb-1">
                                                        <a href="{{ route('notes.downloadAttachment', $attachment->id) }}"
                                                            class="text-body text-truncate d-block" title="Download">
                                                            {{ $attachment->original_name }}
                                                        </a>
                                                    </h5>
                                                    <div>{{ $human }}</div>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('notes.downloadAttachment', $attachment->id) }}"
                                                            class="btn btn-icon text-muted btn-sm fs-18" title="Download">
                                                            <i class="ri-download-2-line"></i>
                                                        </a>
                                                        @if (auth()->user()->id == $note->user_id)
                                                            <form method="POST"
                                                                action="{{ route('notes.deleteAttachment', $attachment->id) }}"
                                                                class="attachment-delete-form d-inline"
                                                                data-name="{{ $attachment->original_name }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-icon text-muted btn-sm fs-18"
                                                                    title="Delete">
                                                                    <i class="ri-delete-bin-fill"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted">Henüz ek dosya yok.</div>
                                    @endforelse
                                @else
                                    <div class="empty-state-placeholder">
                                        <div class="text-center py-5">
                                            <div class="empty-icon mb-3">
                                                <i class="ri-folder-lock-line text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                            <h5 class="text-muted mb-2">Ek Dosyalar Gizli</h5>
                                            <p class="text-muted mb-0">
                                                Bu not private olduğu için ek dosyalar görüntülenemiyor.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!---end col-->
                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-muted">
                                <h6 class="mb-3 fw-semibold text-uppercase">{{ __('notes.note') }}</h6>
                                <p>{{ $note->description }}</p>

                                {{-- <h6 class="mb-3 fw-semibold text-uppercase">Sub-tasks</h6>
                            <ul class="ps-3 list-unstyled vstack gap-2">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="productTask">
                                        <label class="form-check-label" for="productTask">
                                            Product Design, Figma (Software), Prototype
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="dashboardTask" checked>
                                        <label class="form-check-label" for="dashboardTask">
                                            Dashboards : Ecommerce, Analytics, Project,etc.
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="calenderTask">
                                        <label class="form-check-label" for="calenderTask">
                                            Create calendar, chat and email app pages
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="authenticationTask">
                                        <label class="form-check-label" for="authenticationTask">
                                            Add authentication pages
                                        </label>
                                    </div>
                                </li>
                            </ul> --}}

                                <div class="pt-3 border-top border-top-dashed mt-4">
                                    <h6 class="mb-3 fw-semibold text-uppercase">{{ __('notes.note_tags') }}</h6>
                                    <div class="hstack flex-wrap gap-2 fs-15">
                                        @foreach ($note->tags as $tag)
                                            <div class="badge fw-medium bg-primary-subtle text-primary">
                                                {{ $tag->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">

                                    @if (!$isPrivate)
                                        <li class="nav-item">
                                            <a class="nav-link {{ !$isPrivate ? 'active' : '' }}" data-bs-toggle="tab"
                                                href="#home-1" role="tab">
                                                Comments
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab"
                                                id="attachments-tab">
                                                Attachments File
                                            </a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link {{ $isPrivate ? 'active' : '' }}" data-bs-toggle="tab"
                                            href="#profile-1" role="tab">
                                            Activity
                                        </a>
                                    </li>
                                </ul>
                                <!--end nav-->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane {{ $isPrivate ? '' : 'active' }}" id="home-1" role="tabpanel">
                                    <h5 class="card-title mb-4">Comments</h5>
                                    <div data-simplebar style="height: 508px;" class="px-3 mx-n3 mb-2">
                                        @foreach ($note->comments as $comment)
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}"
                                                        alt="" class="avatar-xs rounded-circle" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <h5 class="fs-13 mb-1"><a
                                                                href="pages-profile.html">{{ $comment->user->name }}</a>
                                                            <small
                                                                class="text-muted">{{ $comment->created_at->format('d.m.Y') }}</small>
                                                        </h5>
                                                        @if (auth()->id() === $comment->user_id || auth()->id() === $note->user_id)
                                                            <div class="dropdown">
                                                                <button class="btn btn-icon btn-sm fs-16 text-muted"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <a href="#"
                                                                            class="dropdown-item comment-edit"
                                                                            data-update-url="{{ route('notes.updateComment', $comment->id) }}"
                                                                            data-text="{{ $comment->comment }}">Düzenle</a>
                                                                    </li>
                                                                    <li class="dropdown-divider"></li>
                                                                    <li>
                                                                        <form method="POST"
                                                                            action="{{ route('notes.deleteComment', $comment->id) }}"
                                                                            class="comment-delete-form d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item">Sil</button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <p class="text-muted mb-0">{{ $comment->comment }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <form class="mt-4" id="comment-form" action="{{ route('notes.storeComment') }}"
                                        method="post" data-store-url="{{ route('notes.storeComment') }}">
                                        @csrf
                                        <input type="hidden" name="note_id" value="{{ $note->id }}">
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <label for="exampleFormControlTextarea1" class="form-label">Leave a
                                                    Comments</label>
                                                <textarea class="form-control bg-light border-light" id="comment-textarea" rows="3"
                                                    placeholder="Enter comments" name="comment"></textarea>
                                            </div>
                                            <!--end col-->
                                            <div class="col-12 text-end">
                                                <button type="submit" id="comment-submit-btn"
                                                    class="btn btn-primary">Post Comments</button>
                                                <button type="button" id="cancel-edit-btn"
                                                    class="btn btn-soft-secondary ms-1"
                                                    style="display:none;">İptal</button>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="messages-1" role="tabpanel" id="attachments-tab">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th scope="col">File Name</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Upload Date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($note->attachments as $attachment)
                                                    @php
                                                        $ext = strtolower(
                                                            pathinfo($attachment->file_name, PATHINFO_EXTENSION),
                                                        );
                                                        $icon = 'ri-file-2-line';
                                                        if (in_array($ext, ['zip', 'rar', '7z'])) {
                                                            $icon = 'ri-folder-zip-line';
                                                        } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                                            $icon = 'ri-file-ppt-2-line';
                                                        } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                                            $icon = 'ri-file-excel-2-line';
                                                        } elseif (in_array($ext, ['doc', 'docx'])) {
                                                            $icon = 'ri-file-word-2-line';
                                                        } elseif (in_array($ext, ['pdf'])) {
                                                            $icon = 'ri-file-pdf-2-line';
                                                        } elseif (
                                                            in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])
                                                        ) {
                                                            $icon = 'ri-image-2-line';
                                                        } elseif (in_array($ext, ['mp4', 'mov', 'mkv'])) {
                                                            $icon = 'ri-video-line';
                                                        } elseif (in_array($ext, ['mp3', 'wav', 'ogg'])) {
                                                            $icon = 'ri-music-2-line';
                                                        }

                                                        $size = (int) $attachment->size;
                                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                                        $factor = $size > 0 ? floor((strlen($size) - 1) / 3) : 0;
                                                        $human =
                                                            $size > 0
                                                                ? sprintf('%.1f', $size / pow(1024, $factor)) .
                                                                    $units[$factor]
                                                                : '0B';
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm">
                                                                    <div
                                                                        class="avatar-title bg-danger-subtle text-danger rounded fs-20">
                                                                        <i class="{{ $icon }}"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="ms-3 flex-grow-1">
                                                                    <h6 class="fs-15 mb-0"><a
                                                                            href="{{ route('notes.downloadAttachment', $attachment->id) }}">{{ $attachment->original_name }}</a>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        {{-- Bu satır, dosya yolundan dosya uzantısını alıp büyük harfe çeviriyor ve sonuna " File" ekliyor. Yani örneğin dosya pdf ise "PDF File" olarak gösteriyor. --}}
                                                        <td>{{ strtoupper(pathinfo($attachment->path, PATHINFO_EXTENSION)) }}
                                                            File</td>
                                                        <td>{{ $human }}</td>
                                                        <td>{{ $attachment->created_at->format('d.m.Y') }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-light btn-icon" id="dropdownMenuLink1"
                                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                                    <i class="ri-equalizer-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="dropdownMenuLink1"
                                                                    data-popper-placement="bottom-end"
                                                                    style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('notes.downloadAttachment', $attachment->id) }}"><i
                                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                                    </li>
                                                                    <li class="dropdown-divider"></li>
                                                                    @if (auth()->user()->id == $note->user_id)
                                                                        <form
                                                                            action="{{ route('notes.deleteAttachment', $attachment->id) }}"
                                                                            method="POST"
                                                                            class="attachment-delete-form d-inline"
                                                                            data-name="{{ $attachment->original_name }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <li><button type="submit"
                                                                                    class="dropdown-item"><i
                                                                                        class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</button>
                                                                            </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane {{ $isPrivate ? 'active' : '' }}" id="profile-1" role="tabpanel">
                                    <h6 class="card-title mb-4 pb-2">Activities</h6>
                                    <div class="table-responsive table-card">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th scope="col">Member</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Duration</th>
                                                    <th scope="col">Timer Idle</th>
                                                    <th scope="col">Tasks Title</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="d-flex align-items-center">
                                                            <img src="assets/images/users/avatar-8.jpg" alt=""
                                                                class="rounded-circle avatar-xxs">
                                                            <div class="flex-grow-1 ms-2">
                                                                <a href="pages-profile.html" class="fw-medium">Thomas
                                                                    Taylor</a>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td>02 Jan, 2022</td>
                                                    <td>3 hrs 12 min</td>
                                                    <td>05 min</td>
                                                    <td>Apps Pages</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="assets/images/users/avatar-10.jpg" alt=""
                                                                class="rounded-circle avatar-xxs">
                                                            <div class="flex-grow-1 ms-2">
                                                                <a href="pages-profile.html" class="fw-medium">Tonya
                                                                    Noble</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>28 Dec, 2021</td>
                                                    <td>1 hrs 35 min</td>
                                                    <td>-</td>
                                                    <td>Profile Page Design</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="d-flex align-items-center">
                                                            <img src="assets/images/users/avatar-10.jpg" alt=""
                                                                class="rounded-circle avatar-xxs">
                                                            <div class="flex-grow-1 ms-2">
                                                                <a href="pages-profile.html" class="fw-medium">Tonya
                                                                    Noble</a>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td>27 Dec, 2021</td>
                                                    <td>4 hrs 26 min</td>
                                                    <td>03 min</td>
                                                    <td>Ecommerce Dashboard</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>
                                </div>
                                <!--edn tab-pane-->

                            </div>
                            <!--end tab-content-->
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Not oluşturulma tarihini PHP'den al
            const noteCreatedAt = new Date('{{ $note->created_at }}');
            const elapsedTimeElement = document.getElementById('elapsed-time');

            function updateElapsedTime() {
                const now = new Date();
                const elapsed = now - noteCreatedAt;

                // Milisaniyeyi gün, saat, dakika ve saniyeye çevir
                const years = Math.floor(elapsed / (1000 * 60 * 60 * 24 * 365));
                const months = Math.floor((elapsed % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 * 24 * 30));
                const days = Math.floor((elapsed % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 * 24));
                const hours = Math.floor((elapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((elapsed % (1000 * 60)) / 1000);

                let timeString = '';

                if (years > 0) {
                    timeString = `${years} yıl ${months} ay ${days} gün ${hours} saat ${minutes} dk`;
                } else if (months > 0) {
                    timeString = `${months} ay ${days} gün ${hours} saat ${minutes} dk`;
                } else if (days > 0) {
                    timeString = `${days} gün ${hours} saat ${minutes} dk`;
                } else if (hours > 0) {
                    timeString = `${hours} saat ${minutes} dk`;
                } else if (minutes > 0) {
                    timeString = `${minutes} dk ${seconds} sn`;
                } else {
                    timeString = `${seconds} saniye`;
                }

                elapsedTimeElement.textContent = timeString;
            }

            // İlk çalıştırma
            updateElapsedTime();

            // Her saniye güncelle
            setInterval(updateElapsedTime, 1000);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {




            document.querySelectorAll('.attachment-delete-form').forEach(function(formEl) {
                formEl.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const fileName = formEl.getAttribute('data-name') || 'dosya';

                    Swal.fire({
                        html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-5">
                                <h4>Ek Sil</h4>
                                <p class="text-muted mx-4 mb-0">\`${fileName}\` ekini silmek istediğine emin misin?</p>
                            </div>
                        </div>`,
                        showCancelButton: true,
                        customClass: {
                            confirmButton: "btn btn-primary w-xs me-2 mb-1",
                            cancelButton: "btn btn-danger w-xs mb-1",
                        },
                        cancelButtonText: "Hayır",
                        confirmButtonText: "Sil",
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then((result) => {
                        if (!result.isConfirmed) return;
                        formEl.submit();
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('comment-form');
            if (!form) return;
            const textarea = document.getElementById('comment-textarea');
            const submitBtn = document.getElementById('comment-submit-btn');
            const cancelBtn = document.getElementById('cancel-edit-btn');
            const storeUrl = form.getAttribute('data-store-url');
            const defaultBtnText = submitBtn ? submitBtn.textContent : '';
            let methodInput = null;

            function enterEditMode(updateUrl, text) {
                if (textarea) {
                    textarea.value = decodeHTMLEntities(text || '').trim();
                }
                if (form && updateUrl) {
                    form.setAttribute('action', updateUrl);
                }
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                } else {
                    methodInput.value = 'PUT';
                }
                if (submitBtn) submitBtn.textContent = 'Update Comment';
                if (cancelBtn) cancelBtn.style.display = 'inline-block';
                if (textarea) {
                    textarea.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    textarea.focus();
                }
            }

            function exitEditMode() {
                if (form && storeUrl) form.setAttribute('action', storeUrl);
                if (methodInput) {
                    methodInput.remove();
                    methodInput = null;
                }
                if (submitBtn) submitBtn.textContent = defaultBtnText || 'Post Comments';
                if (cancelBtn) cancelBtn.style.display = 'none';
                if (textarea) textarea.value = '';
            }

            function decodeHTMLEntities(str) {
                const txt = document.createElement('textarea');
                txt.innerHTML = str;
                return txt.value;
            }

            document.querySelectorAll('.comment-edit').forEach(function(editEl) {
                editEl.addEventListener('click', function(e) {
                    e.preventDefault();
                    const updateUrl = this.getAttribute('data-update-url');
                    const text = this.getAttribute('data-text') || '';
                    enterEditMode(updateUrl, text);
                });
            });

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    exitEditMode();
                });
            }

            // Delete confirm for comments
            document.querySelectorAll('.comment-delete-form').forEach(function(formEl) {
                formEl.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const container = formEl.closest('.d-flex.mb-4');
                    const contentEl = container ? container.querySelector('p.text-muted') : null;
                    let preview = contentEl ? contentEl.textContent.trim() : '';
                    if (preview.length > 100) preview = preview.slice(0, 100) + '…';

                    Swal.fire({
                        html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-5">
                                <h4>Yorumu Sil</h4>
                                <p class="text-muted mx-4 mb-0">Bu yorumu silmek istediğine emin misin?<br><em>\`${preview}\`</em></p>
                            </div>
                        </div>`,
                        showCancelButton: true,
                        customClass: {
                            confirmButton: "btn btn-primary w-xs me-2 mb-1",
                            cancelButton: "btn btn-danger w-xs mb-1",
                        },
                        cancelButtonText: "Hayır",
                        confirmButtonText: "Sil",
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then((result) => {
                        if (!result.isConfirmed) return;
                        formEl.submit();
                    });
                });
            });
        });
    </script>
@endsection
