@extends('layouts.index')

@section('title', __('companies.title') . ' | CRM Barış Tok')

@section('css')

    <style>
        #company-detail-area {
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
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()" style="display: none;">
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
                <div class="col-xxl-9" id="company-content-area">
                    <div class="card" id="companyList">
                        <div class="card-header">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <form method="GET" action="{{ route('companies.search') }}" id="searchForm">
                                        <div class="search-box">
                                            <input type="text" name="search" class="form-control search"
                                                id="liveSearchInput" value="{{ request('search') }}"
                                                placeholder="{{ __('companies.search_company') }}" />
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </form>
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
                                                <th data-sort="name" scope="col">
                                                    {{ __('companies.company_name') }}
                                                </th>
                                                <th data-sort="owner" scope="col">
                                                    {{ __('companies.owner') }}
                                                </th>
                                                <th data-sort="industry_type" scope="col">
                                                    {{ __('companies.industry_type') }}
                                                </th>
                                                <th data-sort="star_value" scope="col">
                                                    {{ __('companies.rating') }}
                                                </th>
                                                <th data-sort="location" scope="col">
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
                                                                <a href="javascript:void(0);" class="view-item-btn"
                                                                    data-company-id="{{ $company->id }}"><i
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
                                                                    onclick="deleteCompany({{ $company->id }})">
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
                                {{-- <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div> --}}
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">

                                        @include('companies::custom-pagination', [
                                            'paginator' => $companies,
                                        ])
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
                                                            <label for="companyname-field"
                                                                class="form-label">{{ __('companies.company_name') }}</label>
                                                            <input type="text" id="companyname-field" name="name"
                                                                class="form-control"
                                                                placeholder="{{ __('companies.company_name_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="owner-field"
                                                                class="form-label">{{ __('companies.owner_name') }}</label>
                                                            <input type="text" id="owner-field" name="owner_name"
                                                                class="form-control"
                                                                placeholder="{{ __('companies.owner_name_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="industry_type-field"
                                                                class="form-label">{{ __('companies.industry_type') }}</label>
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
                                                                class="form-control"
                                                                placeholder="{{ __('companies.rating_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="location-field"
                                                                class="form-label">{{ __('companies.location') }}</label>
                                                            <input type="text" id="location-field" name="location"
                                                                class="form-control"
                                                                placeholder="{{ __('companies.location_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="employee-field"
                                                                class="form-label">{{ __('companies.employee') }}</label>
                                                            <input type="text" id="employee-field"
                                                                name="employee_count" class="form-control"
                                                                placeholder="{{ __('companies.employee_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="website-field"
                                                                class="form-label">{{ __('companies.website') }}</label>
                                                            <input type="text" id="website-field" name="website"
                                                                class="form-control"
                                                                placeholder="{{ __('companies.website_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="contact_email-field"
                                                                class="form-label">{{ __('companies.contact_email') }}</label>
                                                            <input type="text" id="contact_email-field"
                                                                name="contact_email" class="form-control"
                                                                placeholder="{{ __('companies.contact_email_placeholder') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="since-field"
                                                                class="form-label">{{ __('companies.since') }}</label>
                                                            <input type="text" id="since-field" name="since"
                                                                class="form-control"
                                                                placeholder="{{ __('companies.since_placeholder') }}"
                                                                required />
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
                                                        {{ __('companies.add_company') }}
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
                </div>
                <div class="col-xxl-3" id="company-detail-area">
                    <div class="card" id="company-view-detail" style="display: none;">
                        <!-- Şirket detayları burada dinamik olarak yüklenecek -->
                    </div>
                    <!--end card-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <!--end col-->
            {{-- Company-details --}}
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
        // '.add-btn' sınıfına sahip olan "Ekle" butonunu bul
        const addCompanyButton = document.querySelector('.add-btn');

        // Bu butona her tıklandığında...
        addCompanyButton.addEventListener('click', function() {
            // Bootstrap'in modal'ı açmasından hemen önce formu sıfırla
            resetForm();
        });

        // Formu sıfırlarken etiketleri de temizle
        document.getElementById('close-modal', 'add-btn').addEventListener('click', resetForm);
        //formu sıfırlama

        function resetForm() {
            document.getElementById('companyForm').reset();
            document.getElementById('method').value = 'POST';
            document.getElementById('company_id').value = '';
            document.getElementById('modalTitle').innerText = "{{ __('companies.add_company') }}";
            document.getElementById('submitBtn').innerText = "{{ __('companies.add_company') }}";
            document.getElementById('companyForm').action = "{{ route('companies.store') }}";
            // document.getElementById('customer-img').src = "assets/images/users/user-dummy-img.jpg";
            // tagInputField.removeActiveItems();
        }




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






        // Detay paneli & görüntüle tuşu davranışı
        document.addEventListener('DOMContentLoaded', function() {
            // Checkbox handler'larını başlat
            initializeCheckboxHandlers();

            // Check All Companies functionality
            const checkAll = document.getElementById('checkAll');
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('input[name="chk_child"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = checkAll.checked;
                        // Satır stilini güncelle
                        if (checkbox.checked) {
                            checkbox.closest('tr').classList.add('table-active');
                        } else {
                            checkbox.closest('tr').classList.remove('table-active');
                        }
                    });

                    // Seçili checkbox sayısını kontrol et
                    const checkedCount = document.querySelectorAll('input[name="chk_child"]:checked')
                        .length;
                    const removeActions = document.getElementById('remove-actions');
                    if (removeActions) {
                        removeActions.style.display = checkedCount > 0 ? 'block' : 'none';
                    }
                });
            }

            document.querySelectorAll('.view-item-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Company ID'yi al
                    const companyId = this.getAttribute('data-company-id');

                    // AJAX ile detay bilgilerini çek
                    fetch("{{ route('companies.details', ['id' => ':id']) }}".replace(':id',
                            companyId), {
                            method: 'GET',
                            headers: {
                                'Accept': 'text/html',
                                'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            // Detay alanına HTML'i yerleştir
                            const detail = document.getElementById('company-view-detail');
                            detail.innerHTML = html;
                            detail.style.display = 'block';

                            // Responsive mekanizma
                            document.getElementById('company-content-area')
                                .classList.replace('col-xxl-12', 'col-xxl-9');

                            document.getElementById('company-detail-area').style.display =
                                'block';

                            // Kapatma butonu
                            document.getElementById('company-detail-close')?.addEventListener(
                                'click', () => {
                                    detail.style.display = 'none';
                                    document.getElementById('company-detail-area').style
                                        .display = 'none';
                                    document.getElementById('company-content-area')
                                        .classList.replace('col-xxl-9', 'col-xxl-12');
                                });
                        })
                        .catch(() => alert('{{ __('companies.error_loading_data') }}'));
                });
            });

            // Başlangıçta detay kapalı olduğu için alanı genişlet
            document.getElementById('company-detail-area').style.display = 'none';
            document.getElementById('company-content-area').classList.add('col-xxl-12');
            document.getElementById('company-content-area').classList.remove('col-xxl-9');
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

        // Çoklu Şirket Silme
        function deleteMultiple() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]:checked');
            if (checkboxes.length === 0) {
                Swal.fire({
                    title: '{{ __('companies.no_record_selected') }}',
                    text: '{{ __('companies.please_select_records') }}',
                    icon: 'warning',
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false
                });
                return;
            }

            // Seçili satırlardan company ID'lerini al
            const companyIds = [];
            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const editBtn = row.querySelector('.edit-item-btn');
                if (editBtn) {
                    const onclickAttr = editBtn.getAttribute('onclick');
                    const idMatch = onclickAttr.match(/\d+/);
                    if (idMatch) {
                        companyIds.push(idMatch[0]);
                    }
                }
            });

            if (companyIds.length > 0) {
                Swal.fire({
                    title: '{{ __('companies.delete_multiple_companies') }}',
                    text: `${companyIds.length} {{ __('companies.delete_multiple_companies_info') }}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-secondary',
                    confirmButtonText: '{{ __('companies.yes') }}',
                    cancelButtonText: '{{ __('companies.no') }}',
                    buttonsStyling: false
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Toplu silme işlemi
                        let successCount = 0;
                        let errorCount = 0;
                        
                        for (const companyId of companyIds) {
                            try {
                                const destroyUrlTemplate = "{{ route('companies.destroy', ':id') }}";
                                const response = await fetch(destroyUrlTemplate.replace(':id', companyId), {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                                    <h4>${successCount} {{ __('companies.company_deleted') }}</h4>
                                    <p class="text-muted mx-4 mb-0">{{ __('companies.company_deleted_info') }}</p>
                                  </div>
                                </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('companies.back') }}",
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
                                    <h4>{{ __('companies.partial_success') }}</h4>
                                    <p class="text-muted mx-4 mb-0">${successCount} şirket silindi, ${errorCount} şirket silinemedi.</p>
                                  </div>
                                </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('companies.back') }}",
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
                                    <h4>{{ __('companies.error_deleting_data') }}</h4>
                                    <p class="text-muted mx-4 mb-0">{{ __('companies.no_record_selected') }}</p>
                                  </div>
                                </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('companies.back') }}",
                                buttonsStyling: false,
                                showCloseButton: true
                            });
                        }
                    }
                });
            }
        }

        function deleteCompany(id) {
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
          <h4>{{ __('companies.delete_company') }}</h4>
          <p class="text-muted mx-4 mb-0">{{ __('companies.delete_company_info') }}</p>
        </div>
      </div>`,
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mb-1",
                    cancelButton: "btn btn-danger w-xs mb-1",
                },
                cancelButtonText: "{{ __('companies.no') }}",
                confirmButtonText: "{{ __('companies.yes') }}",
                buttonsStyling: false,
                showCloseButton: true
            }).then((result) => {
                if (!result.isConfirmed) return;
                // 2️⃣ Onay verildiyse silme isteğini yolla
                const destroyUrlTemplate = "{{ route('companies.destroy', ':id') }}";
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
                <h4>{{ __('companies.company_deleted') }}</h4>
                <p class="text-muted mx-4 mb-0">{{ __('companies.company_deleted_info') }}</p>
              </div>
            </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('companies.back') }}",
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
                <p class="text-muted mx-4 mb-0">${data.message || '{{ __('companies.error_saving_data') }}'}</p>
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
              <p class="text-muted mx-4 mb-0">{{ __('companies.error_loading_data') }}</p>
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
    </script>

@endsection
