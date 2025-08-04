@extends('layouts.index')

@section('title', __('leads.title') . ' | CRM Barış Tok')

@section('css')

    <style>

        #contact-detail-area {
            display: none;
        }

        /* Choices.js select kutusu hizalama düzeltmeleri */
        .choices {
            margin-bottom: 0 !important;
            display: flex;
            align-items: center;
        }

        .choices__inner {
            min-height: 38px;
            height: 38px;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }

        .choices__list--single {
            padding: 4px 16px 4px 4px;
        }

        /* Sort butonu yüksekliği eşitleme */
        #sortOrderBtn {
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive için ek güvenlik */
        @media (max-width: 768px) {
            .choices__inner {
                min-height: 36px;
                height: 36px;
            }

            #sortOrderBtn {
                height: 36px;
            }
        }
    </style>
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
                    cancelButtonText: "Tamam",
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
                    cancelButtonText: "Tamam",
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
                        <h4 class="mb-sm-0">{{ __('leads.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{ __('leads.title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="leadsList">
                        <div class="card-header border-0">

                            <div class="row g-4 align-items-center">
                                <div class="col-sm-3">
                                    <div class="search-box">
                                        <form method="GET" action="{{ route('leads.index') }}" id="searchForm">
                                            <input type="text" class="form-control search"
                                                placeholder="{{ __('leads.search') }}" name="search"
                                                value="{{ request('search') }}" id="liveSearchInput">
                                            <i class="ri-search-line search-icon"></i>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-auto ms-auto">
                                    <div class="hstack gap-2">
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                        <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                            id="create-btn" data-bs-target="#showModal"><i
                                                class="ri-add-line align-bottom me-1"></i>
                                            {{ __('leads.add_lead') }}</button>
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="offcanvas"
                                            href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>
                                            Fliters</button>
                                        <span class="dropdown">
                                            <button class="btn btn-soft-primary btn-icon fs-14" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-settings-4-line"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#">Copy</a></li>
                                                <li><a class="dropdown-item" href="#">Move to pipline</a></li>
                                                <li><a class="dropdown-item" href="#">Add to exceptions</a></li>
                                                <li><a class="dropdown-item" href="#">Switch to common form view</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Reset form view to default</a>
                                                </li>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card">
                                    <table class="table align-middle" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>

                                                <th data-sort="name">{{ __('leads.name') }}</th>
                                                <th data-sort="company_name">{{ __('leads.company') }}</th>
                                                <th data-sort="leads_score">{{ __('leads.lead_score') }}</th>
                                                <th data-sort="phone">{{ __('leads.phone') }}</th>
                                                <th data-sort="address">{{ __('leads.address') }}</th>
                                                <th data-sort="tags">{{ __('leads.tags') }}</th>
                                                <th data-sort="date">{{ __('leads.date') }}</th>
                                                <th data-sort="action">{{ __('leads.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($leads as $lead)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="option1">
                                                        </div>
                                                    </th>
                                                    <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                            class="fw-medium link-primary">#VZ2101</a></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-10.jpg" alt=""
                                                                    class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 name">{{ $lead->name }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="company_name">{{ $lead->company_name }}</td>
                                                    <td class="leads_score">{{ $lead->lead_score }}</td>
                                                    <td class="phone">{{ $lead->phone }}</td>
                                                    <td class="address">{{ $lead->location }}</td>
                                                    <td class="tags">
                                                        @foreach ($lead->tags as $tag)
                                                            <span
                                                                class="badge bg-primary-subtle text-primary">{{ $tag->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td class="date">{{ $lead->created_date }}</td>
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Call">
                                                                <a href="javascript:void(0);"
                                                                    class="text-muted d-inline-block">
                                                                    <i class="ri-phone-line fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Message">
                                                                <a href="javascript:void(0);"
                                                                    class="text-muted d-inline-block">
                                                                    <i class="ri-question-answer-line fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="View">
                                                                <a href="javascript:void(0);"><i
                                                                        class="ri-eye-fill align-bottom text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Edit">
                                                                <a class="edit-item-btn" href="javascript:void(0);" onclick="EditLead({{ $lead->id }})"
                                                                    data-bs-toggle="modal"><i
                                                                        class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Delete">
                                                                <a class="remove-item-btn" href="javascript:void(0);"
                                                                    onclick="deleteLead({{ $lead->id }})">
                                                                    <i
                                                                        class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="noresult" style="display: none">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#8c68cd,secondary:#4788ff"
                                                style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted mb-0">We've searched more than 150+ leads We did not find
                                                any leads for you search.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        @include('leads::custom-pagination', [
                                            'paginator' => $leads,
                                        ])
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="modalTitle">{{ __('leads.add_lead') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" autocomplete="off" id="leadForm" method="POST"
                                            action="{{ route('leads.store') }}">
                                            @csrf
                                            <input type="hidden" name="_method" id="method" value="POST">
                                            <input type="hidden" name="lead_id" id="lead_id" value="">
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <div class="position-relative d-inline-block">
                                                                <div class="position-absolute bottom-0 end-0">
                                                                    <label for="lead-image-input" class="mb-0"
                                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                                        title="Select Image">
                                                                        <div class="avatar-xs cursor-pointer">
                                                                            <div
                                                                                class="avatar-title bg-light border rounded-circle text-muted">
                                                                                <i class="ri-image-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <input class="form-control d-none" value=""
                                                                        id="lead-image-input" type="file"
                                                                        accept="image/png, image/gif, image/jpeg">
                                                                </div>
                                                                <div class="avatar-lg p-1">
                                                                    <div class="avatar-title bg-light rounded-circle">
                                                                        <img src="assets/images/users/user-dummy-img.jpg"
                                                                            id="lead-img"
                                                                            class="avatar-md rounded-circle object-fit-cover" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h5 class="fs-13 mt-3">Lead Image</h5>
                                                        </div>
                                                        <div>
                                                            <label for="leadname-field"
                                                                class="form-label">{{ __('leads.name') }}</label>
                                                            <input type="text" id="leadname-field" name="name"
                                                                class="form-control"
                                                                placeholder="{{ __('leads.enter_name') }}" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="company_name-field"
                                                                class="form-label">{{ __('leads.company_name') }}</label>
                                                            <input type="text" id="company_name-field"
                                                                name="company_name" class="form-control"
                                                                placeholder="{{ __('leads.enter_company_name') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="leads_score-field"
                                                                class="form-label">{{ __('leads.lead_score') }}</label>
                                                            <input type="text" id="leads_score-field"
                                                                name="lead_score" class="form-control"
                                                                placeholder="{{ __('leads.enter_lead_score') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="phone-field"
                                                                class="form-label">{{ __('leads.phone') }}</label>
                                                            <input type="text" id="phone-field" name="phone"
                                                                class="form-control"
                                                                placeholder="{{ __('leads.enter_phone') }}" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="location-field"
                                                                class="form-label">{{ __('leads.location') }}</label>
                                                            <input type="text" id="location-field" name="location"
                                                                class="form-control"    
                                                                placeholder="{{ __('leads.enter_location') }}" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="taginput-choices"
                                                                class="form-label font-size-13 text-muted">{{ __('leads.tags') }}</label>
                                                            <select class="form-control" name="tags[]"
                                                                id="taginput-choices" multiple>
                                                                @foreach ($tags as $tag)
                                                                    <option value="{{ $tag->id }}">
                                                                        {{ $tag->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="date-field"
                                                                class="form-label">{{ __('leads.date') }}</label>
                                                            <input type="date" id="date-field" name="created_date"
                                                                class="form-control" data-provider="flatpickr"
                                                                placeholder="{{ __('leads.enter_date') }}" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="submitBtn">{{ __('leads.add_lead') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--end modal-->

                            <!-- Modal -->
                            <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                                aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="btn-close"></button>
                                        </div>
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                colors="primary:#405189,secondary:#f06548"
                                                style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4 class="fs-semibold">You are about to delete a lead ?</h4>
                                                <p class="text-muted fs-14 mb-4 pt-1">Deleting your lead will remove all of
                                                    your information from our database.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button
                                                        class="btn btn-link link-success fw-medium text-decoration-none"
                                                        id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                            class="ri-close-line me-1 align-middle"></i> Close</button>
                                                    <button class="btn btn-danger" id="delete-record">Yes, Delete
                                                        It!!</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->


                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                                aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header bg-light">
                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Leads Fliters</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <!--end offcanvas-header-->
                                <form action="" class="d-flex flex-column justify-content-end h-100">
                                    <div class="offcanvas-body">
                                        <div class="mb-4">
                                            <label for="datepicker-range"
                                                class="form-label text-muted text-uppercase fw-semibold mb-3">Date</label>
                                            <input type="date" class="form-control" id="datepicker-range"
                                                data-provider="flatpickr" data-range="true" placeholder="Select date">
                                        </div>
                                        <div class="mb-4">
                                            <label for="country-select"
                                                class="form-label text-muted text-uppercase fw-semibold mb-3">Country</label>
                                            <select class="form-control" data-choices data-choices-multiple-remove="true"
                                                name="country-select" id="country-select" multiple>
                                                <option value="">Select country</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Brazil" selected>Brazil</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="France">France</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Syria">Syria</option>
                                                <option value="United Kingdom" selected>United Kingdom</option>
                                                <option value="United States of America">United States of America</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="status-select"
                                                class="form-label text-muted text-uppercase fw-semibold mb-3">Status</label>
                                            <div class="row g-2">
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox1" value="option1">
                                                        <label class="form-check-label" for="inlineCheckbox1">New
                                                            Leads</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox2" value="option2">
                                                        <label class="form-check-label" for="inlineCheckbox2">Old
                                                            Leads</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox3" value="option3">
                                                        <label class="form-check-label" for="inlineCheckbox3">Loss
                                                            Leads</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox4" value="option4">
                                                        <label class="form-check-label" for="inlineCheckbox4">Follow
                                                            Up</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="leadscore"
                                                class="form-label text-muted text-uppercase fw-semibold mb-3">Lead
                                                Score</label>
                                            <div class="row g-2 align-items-center">
                                                <div class="col-lg">
                                                    <input type="number" class="form-control" id="leadscore"
                                                        placeholder="0">
                                                </div>
                                                <div class="col-lg-auto">
                                                    To
                                                </div>
                                                <div class="col-lg">
                                                    <input type="number" class="form-control" id="leadscore"
                                                        placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="leads-tags"
                                                class="form-label text-muted text-uppercase fw-semibold mb-3">Tags</label>
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="marketing"
                                                            value="marketing">
                                                        <label class="form-check-label" for="marketing">Marketing</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="management"
                                                            value="management">
                                                        <label class="form-check-label"
                                                            for="management">Management</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="business"
                                                            value="business">
                                                        <label class="form-check-label" for="business">Business</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="investing"
                                                            value="investing">
                                                        <label class="form-check-label" for="investing">Investing</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="partner"
                                                            value="partner">
                                                        <label class="form-check-label" for="partner">Partner</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="lead"
                                                            value="lead">
                                                        <label class="form-check-label" for="lead">Leads</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="sale"
                                                            value="sale">
                                                        <label class="form-check-label" for="sale">Sale</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="owner"
                                                            value="owner">
                                                        <label class="form-check-label" for="owner">Owner</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="banking"
                                                            value="banking">
                                                        <label class="form-check-label" for="banking">Banking</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="banking"
                                                            value="banking">
                                                        <label class="form-check-label" for="banking">Exiting</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="banking"
                                                            value="banking">
                                                        <label class="form-check-label" for="banking">Finance</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="banking"
                                                            value="banking">
                                                        <label class="form-check-label" for="banking">Fashion</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end offcanvas-body-->
                                    <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                        <button class="btn btn-light w-100">Clear Filter</button>
                                        <button type="submit" class="btn btn-success w-100">Filters</button>
                                    </div>
                                    <!--end offcanvas-footer-->
                                </form>
                            </div>
                            <!--end offcanvas-->

                        </div>
                    </div>

                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>

@endsection

@section('js')


    <!-- Tek seferlik Choices.js yüklemesi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.js"></script>

    <script>
        // Live Search Fonksiyonalitesi
        let searchTimeout;
        const searchInput = document.getElementById('liveSearchInput');

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (searchInput.value.trim() !== '') {
                    document.getElementById('searchForm').submit();
                }
            }, 500); // 500ms bekle
        });

        // Sayfa yüklendiğinde search değeri varsa input'a focus ver
        document.addEventListener('DOMContentLoaded', function() {
            if (searchInput.value.trim() !== '') {
                searchInput.focus();
                // Cursor'u text'in sonuna getir
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        });



        // DOM yüklendiğinde çalışacak fonksiyonlar
        document.addEventListener('DOMContentLoaded', function() {
            // Checkbox işleyicilerini başlat
            initializeCheckboxHandlers();

            // Check All checkbox işleyicisi ekle
            const checkAllBox = document.getElementById('checkAll');
            if (checkAllBox) {
                checkAllBox.addEventListener('change', function() {
                    const childCheckboxes = document.querySelectorAll('[name="chk_child"]');
                    const removeButton = document.getElementById("remove-actions");

                    childCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = checkAllBox.checked;
                        const row = checkbox.closest("tr");

                        if (checkbox.checked) {
                            row.classList.add("table-active");
                        } else {
                            row.classList.remove("table-active");
                        }
                    });

                    // Silme butonunu göster/gizle
                    if (removeButton) {
                        removeButton.style.display = checkAllBox.checked && childCheckboxes.length > 0 ?
                            "block" : "none";
                    }
                });
            }

            // Search input'a focus ver
            if (searchInput.value.trim() !== '') {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }

        });



        // Choices.js instance’ı globalde tutuyoruz
            const tagInputField = new Choices("#taginput-choices", {
                removeItemButton: true,
                searchEnabled: true,
                searchChoices: true,
                searchFloor: 1,
                placeholder: true,
                placeholderValue: '{{ __('contacts.select_tag') }}',
                noResultsText: '{{ __('contacts.no_results') }}',
                itemSelectText: '{{ __('contacts.select_item') }}'
            });












        // Checkbox işleyicilerini başlat
        function initializeCheckboxHandlers() {
            // Her bir checkbox için change event listener ekle
            const childCheckboxes = document.getElementsByName("chk_child");

            if (childCheckboxes.length > 0) {
                Array.from(childCheckboxes).forEach(function(checkbox) {
                    checkbox.addEventListener("change", function(e) {
                        const row = e.target.closest("tr");

                        // Checkbox seçiliyse satırı aktif yap, değilse pasif yap
                        if (checkbox.checked) {
                            row.classList.add("table-active");
                        } else {
                            row.classList.remove("table-active");
                        }

                        // Seçili checkbox sayısını kontrol et
                        const checkedCount = document.querySelectorAll('[name="chk_child"]:checked').length;

                        // Silme butonunu göster/gizle
                        const removeButton = document.getElementById("remove-actions");
                        if (removeButton) {
                            removeButton.style.display = checkedCount > 0 ? "block" : "none";
                        }
                    });
                });
            }
        }

        // Çoklu Lead Silme
        function deleteMultiple() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]:checked');
            if (checkboxes.length === 0) {
                Swal.fire({
                    title: '{{ __('leads.no_record_selected') }}',
                    text: '{{ __('leads.please_select_records') }}',
                    icon: 'warning',
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false
                });
                return;
            }

            // Seçili satırlardan lead ID'lerini al
            const leadIds = [];
            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const removeBtn = row.querySelector('.remove-item-btn');
                if (removeBtn) {
                    const onclickAttr = removeBtn.getAttribute('onclick');
                    const idMatch = onclickAttr.match(/\d+/);
                    if (idMatch) {
                        leadIds.push(idMatch[0]);
                    }
                }
            });

            if (leadIds.length > 0) {
                Swal.fire({
                    title: '{{ __('leads.delete_multiple_leads') }}',
                    text: `${leadIds.length} {{ __('leads.delete_multiple_leads_info') }}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-secondary',
                    confirmButtonText: '{{ __('leads.yes') }}',
                    cancelButtonText: '{{ __('leads.no') }}',
                    buttonsStyling: false
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Toplu silme işlemi
                        let successCount = 0;
                        let errorCount = 0;

                        for (const leadId of leadIds) {
                            try {
                                const destroyUrlTemplate = "{{ route('leads.destroy', ':id') }}";
                                const response = await fetch(destroyUrlTemplate.replace(':id', leadId), {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'Accept': 'application/json'
                                    }
                                });

                                if (response.ok) {
                                    successCount++;
                                } else {
                                    errorCount++;
                                }
                            } catch (error) {
                                errorCount++;
                            }
                        }

                        // Sonuç bildirimi
                        if (successCount > 0 && errorCount === 0) {
                            // Tümü başarılı
                            Swal.fire({
                                html: `
                                <div class="mt-3">
                                  <lord-icon
                                    src="https://cdn.lordicon.com/lupuorrc.json"
                                    trigger="loop"
                                    colors="primary:#0ab39c,secondary:#405189"
                                    style="width:120px;height:120px">
                                  </lord-icon>
                                  <div class="mt-4 pt-2 fs-15">
                                    <h4>${successCount} {{ __('leads.lead_deleted') }}</h4>
                                    <p class="text-muted mx-4 mb-0">{{ __('leads.lead_deleted_info') }}</p>
                                  </div>
                                </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('leads.back') }}",
                                buttonsStyling: false,
                                showCloseButton: true
                            }).then(() => window.location.reload());
                        } else if (successCount > 0 && errorCount > 0) {
                            // Kısmi başarı
                            Swal.fire({
                                html: `
                                <div class="mt-3">
                                  <lord-icon
                                    src="https://cdn.lordicon.com/tdrtiskw.json"
                                    trigger="loop"
                                    colors="primary:#f06548,secondary:#f7b84b"
                                    style="width:120px;height:120px">
                                  </lord-icon>
                                  <div class="mt-4 pt-2 fs-15">
                                    <h4>{{ __('leads.partial_success') }}</h4>
                                    <p class="text-muted mx-4 mb-0">${successCount} lead silindi, ${errorCount} lead silinemedi.</p>
                                  </div>
                                </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('leads.back') }}",
                                buttonsStyling: false,
                                showCloseButton: true
                            }).then(() => window.location.reload());
                        } else {
                            // Tümü başarısız
                            Swal.fire({
                                html: `
                                <div class="mt-3">
                                  <lord-icon
                                    src="https://cdn.lordicon.com/tdrtiskw.json"
                                    trigger="loop"
                                    colors="primary:#f06548,secondary:#f7b84b"
                                    style="width:120px;height:120px">
                                  </lord-icon>
                                  <div class="mt-4 pt-2 fs-15">
                                    <h4>{{ __('leads.error_deleting_data') }}</h4>
                                    <p class="text-muted mx-4 mb-0">{{ __('leads.no_record_selected') }}</p>
                                  </div>
                                </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('leads.back') }}",
                                buttonsStyling: false,
                                showCloseButton: true
                            });
                        }
                    }
                });
            }
        }

        function deleteLead(id) {
            // 1️⃣ Önce onay sor
            Swal.fire({
                html: `
      <div class="mt-3">
        <lord-icon
          src="https://cdn.lordicon.com/gsqxdxog.json"
          trigger="loop"
          colors="primary:#f7b84b,secondary:#f06548"
          style="width:100px;height:100px">
        </lord-icon>
        <div class="mt-4 pt-2 fs-15 mx-5">
          <h4>{{ __('leads.delete_lead') }}</h4>
          <p class="text-muted mx-4 mb-0">{{ __('leads.delete_lead_info') }}</p>
        </div>
      </div>`,
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mb-1",
                    cancelButton: "btn btn-danger w-xs mb-1",
                },
                cancelButtonText: "{{ __('leads.no') }}",
                confirmButtonText: "{{ __('leads.yes') }}",
                buttonsStyling: false,
                showCloseButton: true
            }).then((result) => {
                if (!result.isConfirmed) return;
                // 2️⃣ Onay verildiyse silme isteğini yolla
                const destroyUrlTemplate = "{{ route('leads.destroy', ':id') }}";
                fetch(destroyUrlTemplate.replace(':id', id), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (response.ok) {
                            // 3️⃣ Başarılıysa başarı uyarısı göster ve yenile
                            Swal.fire({
                                html: `
                                 <div class="mt-3">
              <lord-icon
                src="https://cdn.lordicon.com/lupuorrc.json"
                trigger="loop"
                colors="primary:#0ab39c,secondary:#405189"
                style="width:120px;height:120px">
              </lord-icon>
              <div class="mt-4 pt-2 fs-15">
                <h4>{{ __('leads.lead_deleted') }}</h4>
                <p class="text-muted mx-4 mb-0">{{ __('leads.lead_deleted_info') }}</p>
              </div>
            </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('leads.back') }}",
                                buttonsStyling: false,
                                showCloseButton: true
                            }).then(() => window.location.reload());
                        } else {
                            // 4️⃣ Hata mesajını göster
                            Swal.fire({
                                html: `
                                <div class="mt-3">
              <lord-icon
                src="https://cdn.lordicon.com/tdrtiskw.json"
                trigger="loop"
                colors="primary:#f06548,secondary:#f7b84b"
                style="width:120px;height:120px">
              </lord-icon>
              <div class="mt-4 pt-2 fs-15">
                <h4>Oops...! Something went Wrong !</h4>
                <p class="text-muted mx-4 mb-0">${data.message || '{{ __('leads.error_saving_data') }}'}</p>
              </div>
            </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "Dismiss",
                                buttonsStyling: false,
                                showCloseButton: true
                            });
                        }
                    })
                    .catch(() => {
                        // 5️⃣ Network hatası vs.
                        Swal.fire({
                            html: `
          <div class="mt-3">
            <lord-icon
              src="https://cdn.lordicon.com/tdrtiskw.json"
              trigger="loop"
              colors="primary:#f06548,secondary:#f7b84b"
              style="width:120px;height:120px">
            </lord-icon>
            <div class="mt-4 pt-2 fs-15">
              <h4>Oops...! Something went Wrong !</h4>
              <p class="text-muted mx-4 mb-0">{{ __('leads.error_loading_data') }}</p>
            </div>
          </div>`,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: "btn btn-primary w-xs mb-1"
                            },
                            cancelButtonText: "Dismiss",
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                    });
            });
        }

        function EditLead(id) {
            // Formu düzenleme moduna çevir
            document.getElementById('modalTitle').innerText = "{{ __('leads.edit_lead') }}";
            document.getElementById('method').value = "PUT";
            document.getElementById('submitBtn').innerText = "{{ __('leads.update_lead') }}";
            document.getElementById('lead_id').value = id;
            document.getElementById('leadForm').action = "{{ route('leads.index') }}/" + id;
            
            // Verileri AJAX ile çek
            fetch("{{ route('leads.index') }}/" + id + "/edit", {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Form alanlarını doldur
                    document.getElementById('leadname-field').value = data.name || '';
                    document.getElementById('company_name-field').value = data.company_name || '';
                    document.getElementById('leads_score-field').value = data.lead_score || '';
                    document.getElementById('phone-field').value = data.phone || '';
                    document.getElementById('location-field').value = data.location || '';
                    document.getElementById('date-field').value = data.created_date || '';

                    // Tags'leri doldur (Choices.js için)
                    if (data.tags && data.tags.length > 0) {
                        const tagIds = data.tags.map(tag => tag.id.toString());
                        // Önce mevcut seçimleri temizle
                        tagInputField.removeActiveItems();
                        // Yeni değerleri seç
                        tagIds.forEach(tagId => {
                            tagInputField.setChoiceByValue(tagId);
                        });
                    } else {
                        tagInputField.removeActiveItems();
                    }

                    if (data.image) {
                        document.getElementById('lead-img').src = `/storage/${data.image}`;
                    }

                    // Modalı göster
                    new bootstrap.Modal(document.getElementById('showModal')).show();
                })
                .catch(err => {
                    console.error('EditLead error:', err);
                    Swal.fire({
                        html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15">
                                <h4>{{ __('leads.error_loading_data') }}</h4>
                                <p class="text-muted mx-4 mb-0">${err.message || '{{ __('leads.error_loading_data') }}'}</p>
                            </div>
                        </div>`,
                        showCancelButton: true,
                        showConfirmButton: false,
                        customClass: {
                            cancelButton: "btn btn-primary w-xs mb-1"
                        },
                        cancelButtonText: "{{ __('leads.back') }}",
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                });
        }

        // Düzenleme fonksiyonu için form gönderim işlemi
        document.getElementById('leadForm').addEventListener('submit', function(e) {
            const method = document.getElementById('method').value;
            const leadId = document.getElementById('lead_id').value;
            
            if (method === 'PUT' && leadId) {
                e.preventDefault();
                const formData = new FormData(this);
                // Laravel için method override ekle
                formData.append('_method', 'PUT');
                
                fetch("{{ route('leads.index') }}/" + leadId, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    // Response'un content-type'ını kontrol et
                    const contentType = res.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return res.json();
                    } else {
                        // HTML response geldi, muhtemelen redirect oldu
                        throw new Error('Sunucudan beklenmeyen yanıt alındı. Sayfa yenilenecek.');
                    }
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15">
                                    <h4>{{ __('leads.lead_updated') }}</h4>
                                    <p class="text-muted mx-4 mb-0">{{ __('leads.lead_updated_info') }}</p>
                                </div>
                            </div>`,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: "btn btn-primary w-xs mb-1"
                            },
                            cancelButtonText: "{{ __('leads.back') }}",
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then(() => window.location.reload());
                    } else {
                        throw new Error(data.message || '{{ __('leads.error_saving_data') }}');
                    }
                })
                .catch(err => {
                    console.error('Update error:', err);
                    
                    // Eğer sayfa yenilenmesi gereken bir hata ise
                    if (err.message.includes('beklenmeyen yanıt')) {
                        Swal.fire({
                            html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15">
                                    <h4>İşlem Tamamlandı</h4>
                                    <p class="text-muted mx-4 mb-0">Güncelleme başarılı olabilir. Sayfa yenileniyor...</p>
                                </div>
                            </div>`,
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            allowOutsideClick: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15">
                                    <h4>{{ __('leads.error_saving_data') }}</h4>
                                    <p class="text-muted mx-4 mb-0">${err.message || '{{ __('leads.error_saving_data') }}'}</p>
                                </div>
                            </div>`,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: "btn btn-primary w-xs mb-1"
                            },
                            cancelButtonText: "{{ __('leads.back') }}",
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                    }
                });
            }
        });

        // '.add-btn' sınıfına sahip olan "Ekle" butonunu bul
        const addLeadButton = document.querySelector('.add-btn');

        // Bu butona her tıklandığında...
        if (addLeadButton) {
            addLeadButton.addEventListener('click', function() {
                // Bootstrap'in modal'ı açmasından hemen önce formu sıfırla
                resetForm();
            });
        }

        // Formu sıfırlarken etiketleri de temizle
        document.getElementById('close-modal').addEventListener('click', resetForm);
        // Formu sıfırlama
        function resetForm() {
            document.getElementById('leadForm').reset();
            document.getElementById('method').value = 'POST';
            document.getElementById('lead_id').value = '';
            document.getElementById('modalTitle').innerText = "{{ __('leads.add_lead') }}";
            document.getElementById('submitBtn').innerText = "{{ __('leads.add_lead') }}";
            document.getElementById('leadForm').action = "{{ route('leads.store') }}";
            document.getElementById('lead-img').src = "assets/images/users/user-dummy-img.jpg";
            
            // Choices.js field'ını temizle
            if (tagInputField) {
                tagInputField.removeActiveItems();
            }
        }
    </script>

@endsection
