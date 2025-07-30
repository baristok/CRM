@extends('layouts.index')

@section('title', __('companies.title') . ' | CRM Barış Tok')

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
                        <h4 class="mb-sm-0">{{ __('companies.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{ __('companies.title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div class="flex-grow-1">
                                    <button class="btn btn-primary add-btn" data-bs-toggle="modal"
                                        data-bs-target="#showModal">
                                        <i class="ri-add-fill me-1 align-bottom"></i> {{ __('companies.add_company') }}
                                    </button>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="hstack text-nowrap gap-2">
                                        <button class="btn btn-soft-secondary" id="remove-actions"
                                            onClick="deleteMultiple()">
                                            <i class="ri-delete-bin-2-line"></i>
                                        </button>
                                        <button class="btn btn-secondary">
                                            <i class="ri-filter-2-line me-1 align-bottom"></i>
                                            Filters
                                        </button>
                                        <button class="btn btn-soft-primary">Import</button>
                                        {{-- <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                            aria-expanded="false" class="btn btn-soft-primary">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                            <li><a class="dropdown-item" href="#">All</a></li>
                                            <li>
                                                <a class="dropdown-item" href="#">Last Week</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">Last Year</a>
                                            </li>
                                        </ul> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card" id="companyList">
                        <div class="card-header">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="search-box">
                                        <input type="text" class="form-control search"
                                            placeholder="{{ __('companies.search_company') }}" />
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-auto ms-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted">{{ __('companies.sort_by') }}: </span>
                                        <select class="form-control mb-0" data-choices data-choices-search-false
                                            id="choices-single-default">
                                            <option value="Owner">{{ __('companies.owner') }}</option>
                                            <option value="Company">{{ __('companies.company') }}</option>
                                            <option value="location">{{ __('companies.location') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-3">
                                    <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 50px">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option" />
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="name" scope="col">
                                                    {{ __('companies.company_name') }}
                                                </th>
                                                <th class="sort" data-sort="owner" scope="col">
                                                    {{ __('companies.owner') }}
                                                </th>
                                                <th class="sort" data-sort="industry_type" scope="col">
                                                    {{ __('companies.industry_type') }}
                                                </th>
                                                <th class="sort" data-sort="star_value" scope="col">
                                                    {{ __('companies.rating') }}
                                                </th>
                                                <th class="sort" data-sort="location" scope="col">
                                                    {{ __('companies.location') }}
                                                </th>
                                                <th scope="col">{{ __('companies.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($companies as $company)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="option1" />
                                                        </div>
                                                    </th>
                                                    <td class="id" style="display: none">
                                                        <a href="javascript:void(0);"
                                                            class="fw-medium link-primary">#VZ001</a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/brands/dribbble.png" alt=""
                                                                    class="avatar-xxs rounded-circle image_src object-fit-cover" />
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 name">
                                                                {{ $company->name }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="owner">{{ $company->owner_name }}</td>
                                                    <td class="industry_type">{{ $company->industry_type }}</td>
                                                    <td>
                                                        <span class="star_value">{{ $company->rating }}</span>
                                                        <i class="ri-star-fill text-warning align-bottom"></i>
                                                    </td>
                                                    <td class="location">{{ $company->location }}</td>
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
                                                                <a href="javascript:void(0);" class="view-item-btn"><i
                                                                        class="ri-eye-fill align-bottom text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Edit">
                                                                <a class="edit-item-btn" href="javascript:void(0);"
                                                                    onclick="EditCompany({{ $company->id }})"><i
                                                                        class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Delete">
                                                                <a class="remove-item-btn" href="javascript:void(0);"
                                                                    onclick="DeleteCompany({{ $company->id }})">
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
                                                style="width: 75px; height: 75px"></lord-icon>
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted mb-0">
                                                We've searched more than 150+ companies We did not
                                                find any companies for you search.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0">
                                        <div class="modal-header bg-primary-subtle p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <span id="modalTitle">{{ __('companies.add_company') }}</span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" autocomplete="off" id="companyForm" method="POST"
                                            action="{{ route('companies.store') }}">
                                            @csrf
                                            <input type="hidden" name="_method" id="method" value="POST">
                                            <input type="hidden" name="company_id" id="company_id" value="">
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <div class="position-relative d-inline-block">
                                                                <div class="position-absolute bottom-0 end-0">
                                                                    <label for="company-logo-input" class="mb-0"
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
                                                                        id="company-logo-input" name="logo"
                                                                        type="file"
                                                                        accept="image/png, image/gif, image/jpeg" />
                                                                </div>
                                                                <div class="avatar-lg p-1">
                                                                    <div class="avatar-title bg-light rounded-circle">
                                                                        <img src="assets/images/users/multi-user.jpg"
                                                                            id="companylogo-img"
                                                                            class="avatar-md rounded-circle object-fit-cover" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h5 class="fs-13 mt-3">{{ __('companies.company_logo') }}</h5>
                                                        </div>
                                                        <div>
                                                            <label for="companyname-field" class="form-label">{{ __('companies.company_name') }}</label>
                                                            <input type="text" id="companyname-field" name="name"
                                                                class="form-control" placeholder="{{ __('companies.company_name_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="owner-field" class="form-label">{{ __('companies.owner_name') }}</label>
                                                            <input type="text" id="owner-field" name="owner_name"
                                                                class="form-control" placeholder="{{ __('companies.owner_name_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="industry_type-field" class="form-label">{{ __('companies.industry_type') }}</label>
                                                            <select class="form-select" id="industry_type-field"
                                                                name="industry_type">
                                                                <option value="">
                                                                    {{ __('companies.select_industry_type') }}
                                                                </option>
                                                                <option value="Computer Industry">
                                                                    {{ __('companies.computer_industry') }}
                                                                </option>
                                                                <option value="Chemical Industries">
                                                                    {{ __('companies.chemical_industries') }}
                                                                </option>
                                                                <option value="Health Services">
                                                                    {{ __('companies.health_services') }}
                                                                </option>
                                                                <option value="Telecommunications Services">
                                                                    {{ __('companies.telecommunications_services') }}
                                                                </option>
                                                                <option value="Textiles: Clothing, Footwear">
                                                                    {{ __('companies.textiles_clothing_footwear') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="star_value-field"
                                                                class="form-label">{{ __('companies.rating') }}</label>
                                                            <input type="text" id="star_value-field" name="rating"
                                                                class="form-control" placeholder="{{ __('companies.rating_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="location-field"
                                                                class="form-label">{{ __('companies.location') }}</label>
                                                            <input type="text" id="location-field" name="location"
                                                                class="form-control" placeholder="{{ __('companies.location_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="employee-field"
                                                                class="form-label">{{ __('companies.employee') }}</label>
                                                            <input type="text" id="employee-field"
                                                                name="employee_count" class="form-control"
                                                                placeholder="{{ __('companies.employee_placeholder') }}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="website-field" class="form-label">{{ __('companies.website') }}</label>
                                                            <input type="text" id="website-field" name="website"
                                                                class="form-control" placeholder="{{ __('companies.website_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="contact_email-field" class="form-label">{{ __('companies.contact_email') }}</label>
                                                            <input type="text" id="contact_email-field"
                                                                name="contact_email" class="form-control"
                                                                placeholder="{{ __('companies.contact_email_placeholder') }}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="since-field" class="form-label">{{ __('companies.since') }}</label>
                                                            <input type="text" id="since-field" name="since"
                                                                class="form-control" placeholder="{{ __('companies.since_placeholder') }}" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        {{ __('companies.close') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-success" id="submitBtn">
                                                        {{ __('companies.add') }}
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--end add modal-->

                            <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                                aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" id="deleteRecord-close"
                                                data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                        </div>
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                colors="primary:#8c68cd,secondary:#f06548"
                                                style="width: 90px; height: 90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4 class="fs-semibold">
                                                    {{ __('companies.delete_company') }}
                                                </h4>
                                                <p class="text-muted fs-14 mb-4 pt-1">
                                                    {{ __('companies.delete_company_message') }}
                                                </p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button
                                                        class="btn btn-link link-success fw-medium text-decoration-none"
                                                        data-bs-dismiss="modal">
                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                        {{ __('companies.close') }}
                                                    </button>
                                                    <button class="btn btn-danger" id="delete-record">
                                                        {{ __('companies.delete_company_button') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end delete modal -->
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-3">
                    <div class="card" id="company-view-detail">
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block">
                                <div class="avatar-md">
                                    <div class="avatar-title bg-light rounded-circle">
                                        <img src="assets/images/brands/mail_chimp.png" alt=""
                                            class="avatar-sm rounded-circle object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-3 mb-1">Syntyce Solution</h5>
                            <p class="text-muted">Michael Morris</p>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-success-subtle text-success fs-15 rounded">
                                        <i class="ri-global-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                        <i class="ri-mail-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                        <i class="ri-question-answer-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">
                                Information
                            </h6>
                            <p class="text-muted mb-4">
                                A company incurs fixed and variable costs such as the
                                purchase of raw materials, salaries and overhead, as
                                explained by AccountingTools, Inc. Business owners have
                                the discretion to determine the actions.
                            </p>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" scope="row">Industry Type</td>
                                            <td>Chemical Industries</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Location</td>
                                            <td>Damascus, Syria</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Employee</td>
                                            <td>10-50</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Rating</td>
                                            <td>
                                                4.0
                                                <i class="ri-star-fill text-warning align-bottom"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Website</td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    class="link-primary text-decoration-underline">www.syntycesolution.com</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Contact Email</td>
                                            <td>info@syntycesolution.com</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Since</td>
                                            <td>1995</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
    <!-- Tek seferlik Choices.js yüklemesi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.js"></script>
    <script>
        function EditCompany(id) {
            //formu düzenleme moduna çevir
            document.getElementById('modalTitle').innerText = "{{ __('companies.edit_company') }}";
            document.getElementById('method').value = "PUT";
            document.getElementById('submitBtn').innerText = "{{ __('companies.edit_company') }}";
            document.getElementById('company_id').value = id;
            document.getElementById('companyForm').action = "{{ route('companies.index') }}/" + id;
            // Verileri AJAX ile çek
            fetch("{{ route('companies.index') }}/" + id + "/edit", {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Form alanlarını doldur
                    document.getElementById('companyname-field').value = data.name || '';
                    document.getElementById('owner-field').value = data.owner_name || '';
                    document.getElementById('industry_type-field').value = data.industry_type || '';
                    document.getElementById('star_value-field').value = data.rating || '';
                    document.getElementById('location-field').value = data.location || '';
                    document.getElementById('employee-field').value = data.employee_count || '';
                    document.getElementById('website-field').value = data.website || '';
                    document.getElementById('contact_email-field').value = data.contact_email || '';
                    document.getElementById('since-field').value = data.since || '';

                    if (data.logo) {
                        document.getElementById('companylogo-img').src = `/storage/${data.logo}`;
                    }

                    // console.log('gelen veri: ', data);

                    // Modalı göster
                    new bootstrap.Modal(document.getElementById('showModal')).show();

                })
                .catch(err => {
                    console.error('EditCompany error:', err);
                    alert('{{ __('companies.error_loading_data') }}');
                });

            // Form submit override (PUT için)
            document.getElementById('companyForm').addEventListener('submit', function(e) {
                if (document.getElementById('method').value === 'PUT') {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const companyId = document.getElementById('company_id').value;

                    fetch("{{ route('companies.index') }}/" + companyId, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(res => {
                            if (res.ok) window.location.reload();
                            else throw new Error();
                        })
                        .catch(() => alert('{{ __('companies.error_loading_data') }}'));
                    // console.error('Error updating company:', err);
                }
            });
        }


        // Formu sıfırlarken etiketleri de temizle
        document.getElementById('close-modal').addEventListener('click', resetForm);
        //formu sıfırlama

        function resetForm() {
            document.getElementById('companyForm').reset();
            document.getElementById('method').value = 'POST';
            document.getElementById('company_id').value = '';
            document.getElementById('modalTitle').innerText = "{{ __('companies.add_company') }}";
            document.getElementById('submitBtn').innerText = "{{ __('companies.add_company') }}";
            document.getElementById('companyForm').action = "{{ route('companies.store') }}";
            document.getElementById('customer-img').src = "assets/images/users/user-dummy-img.jpg";
            tagInputField.removeActiveItems();
        }
    </script>

@endsection
