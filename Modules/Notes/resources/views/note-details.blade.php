@extends('layouts.index')

@section('title', $note->title)

@section('css')

@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                    <h4 class="mb-sm-0">{{__('notes.note_details')}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('notes.notes')}}</a></li>
                            <li class="breadcrumb-item active">{{__('notes.note_details')}}</li>
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
                        <h6 class="card-title mb-3 flex-grow-1 text-start">{{__('notes.time_tracking')}}</h6>
                        <div class="mb-2">
                            <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" colors="primary:#8c68cd,secondary:#4788ff" style="width:90px;height:90px"></lord-icon>
                        </div>
                        <h3 class="mb-1" id="elapsed-time">Hesaplanıyor...</h3>
                        <h5 class="fs-14 mb-4">{{ $note->title }}</h5>
                        <div class="hstack gap-2 justify-content-center">
                            <button class="btn btn-secondary btn-sm" disabled><i class="ri-time-line align-bottom me-1"></i> Geçen Süre</button>
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
                                        <td class="fw-medium">{{__('notes.note_no')}}</td>
                                        <td>#{{$noteNo}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">{{__('notes.note_title')}}</td>
                                        <td>{{$note->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Priority</td>
                                        <td><span class="badge bg-danger-subtle text-danger">High</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">{{__('notes.status')}}</td>
                                        @if ($note->progress == 0)
                                            <td><span class="badge bg-secondary-subtle text-secondary">{{__('notes.not_started')}}</span></td>
                                        @elseif ($note->progress == 100)
                                            <td><span class="badge bg-success-subtle text-success">{{__('notes.completed')}}</span></td>
                                        @else
                                            <td><span class="badge bg-warning-subtle text-warning">{{__('notes.in_progress')}}</span></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">{{__('notes.due_date')}}</td>
                                        <td>{{$note->due_date ? $note->due_date->format('d.m.Y') : 'Belirtilmedi'}}</td>
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
                            <h6 class="card-title mb-0 flex-grow-1">{{__('notes.assigned_to')}}</h6>
                            {{-- <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inviteMembersModal"><i class="ri-share-line me-1 align-bottom"></i> Assigned Member</button>
                            </div> --}}
                        </div>
                        <ul class="list-unstyled vstack gap-3 mb-0">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{asset('assets/images/users/user-dummy-img.jpg')}}" alt="" class="avatar-xs rounded-circle">
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">{{$note->user->name}}</h6>
                                        <p class="text-muted mb-0">{{$note->user->email}}</p>
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
                        <h5 class="card-title mb-3">{{__('notes.attachments')}}</h5>
                        <div class="vstack gap-2">
                            @if (!$isPrivate)
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
                            <h6 class="mb-3 fw-semibold text-uppercase">{{__('notes.note')}}</h6>
                            <p>{{$note->description}}</p>

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
                                <h6 class="mb-3 fw-semibold text-uppercase">{{__('notes.note_tags')}}</h6>
                                <div class="hstack flex-wrap gap-2 fs-15">
                                    @foreach ($note->tags as $tag)
                                        <div class="badge fw-medium bg-primary-subtle text-primary">{{$tag->name}}</div>
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
                                    <a class="nav-link {{!$isPrivate ? 'active' : ''}}" data-bs-toggle="tab" href="#home-1" role="tab">
                                        Comments
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                                        Attachments File
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link {{$isPrivate ? 'active' : ''}}" data-bs-toggle="tab" href="#profile-1" role="tab">
                                        Activity
                                    </a>
                                </li>
                            </ul>
                            <!--end nav-->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane {{$isPrivate ? '' : 'active'}}" id="home-1" role="tabpanel">
                                <h5 class="card-title mb-4">Comments</h5>
                                <div data-simplebar style="height: 508px;" class="px-3 mx-n3 mb-2">
                                    @foreach ($note->comments as $comment)
                                    <div class="d-flex mb-4">
                                        <div class="flex-shrink-0">
                                            <img src="{{asset('assets/images/users/user-dummy-img.jpg')}}" alt="" class="avatar-xs rounded-circle" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fs-13"><a href="pages-profile.html">{{$comment->user->name}}</a> <small class="text-muted">{{$comment->created_at->format('d.m.Y')}}</small></h5>
                                            <p class="text-muted">{{$comment->comment}}</p>
                                            {{-- <a href="javascript: void(0);" class="badge text-muted bg-light"><i class="mdi mdi-reply"></i> Reply</a> --}}
                                            {{-- <div class="d-flex mt-4">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-10.jpg" alt="" class="avatar-xs rounded-circle" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-13"><a href="pages-profile.html">Tonya Noble</a> <small class="text-muted">22 Dec 2021 - 02:32PM</small></h5>
                                                    <p class="text-muted">Please be sure to check your Spam mailbox to see if your email filters have identified the email from Dell as spam.</p>
                                                    <a href="javascript: void(0);" class="badge text-muted bg-light"><i class="mdi mdi-reply"></i> Reply</a>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <form class="mt-4" action="{{route('notes.storeComment')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="note_id" value="{{$note->id}}">
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <label for="exampleFormControlTextarea1" class="form-label">Leave a Comments</label>
                                            <textarea class="form-control bg-light border-light" id="exampleFormControlTextarea1" rows="3" placeholder="Enter comments" name="comment"></textarea>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary">Post Comments</button>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="messages-1" role="tabpanel">
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                <i class="ri-file-zip-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0)">App pages.zip</a></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Zip File</td>
                                                <td>2.22 MB</td>
                                                <td>21 Dec, 2021</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="true">
                                                            <i class="ri-equalizer-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink1" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill me-2 align-middle text-muted"></i>View</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a></li>
                                                            <li class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-danger-subtle text-danger rounded fs-20">
                                                                <i class="ri-file-pdf-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0);">Velzon admin.ppt</a></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>PPT File</td>
                                                <td>2.24 MB</td>
                                                <td>25 Dec, 2021</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="true">
                                                            <i class="ri-equalizer-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill me-2 align-middle text-muted"></i>View</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a></li>
                                                            <li class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-info-subtle text-info rounded fs-20">
                                                                <i class="ri-folder-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0);">Images.zip</a></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>ZIP File</td>
                                                <td>1.02 MB</td>
                                                <td>28 Dec, 2021</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-expanded="true">
                                                            <i class="ri-equalizer-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink3" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill me-2 align-middle"></i>View</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-download-2-fill me-2 align-middle"></i>Download</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-danger-subtle text-danger rounded fs-20">
                                                                <i class="ri-image-2-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0);">Bg-pattern.png</a></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>PNG File</td>
                                                <td>879 KB</td>
                                                <td>02 Nov 2021</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink4" data-bs-toggle="dropdown" aria-expanded="true">
                                                            <i class="ri-equalizer-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink4" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill me-2 align-middle"></i>View</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-download-2-fill me-2 align-middle"></i>Download</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane {{$isPrivate ? 'active' : ''}}" id="profile-1" role="tabpanel">
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
                                                        <img src="assets/images/users/avatar-8.jpg" alt="" class="rounded-circle avatar-xxs">
                                                        <div class="flex-grow-1 ms-2">
                                                            <a href="pages-profile.html" class="fw-medium">Thomas Taylor</a>
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
                                                        <img src="assets/images/users/avatar-10.jpg" alt="" class="rounded-circle avatar-xxs">
                                                        <div class="flex-grow-1 ms-2">
                                                            <a href="pages-profile.html" class="fw-medium">Tonya Noble</a>
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
                                                        <img src="assets/images/users/avatar-10.jpg" alt="" class="rounded-circle avatar-xxs">
                                                        <div class="flex-grow-1 ms-2">
                                                            <a href="pages-profile.html" class="fw-medium">Tonya Noble</a>
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
@endsection