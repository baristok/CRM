@extends('layouts.index')

@section('title', __('contacts.title') . ' | CRM Barış Tok')

@section('css')
    <style>
        #contact-detail-area {
            display: none;
        }
    </style>
@endsection

@section('content')


    <div class="page-content">
        <div class="container-fluid">



            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">{{ __('contacts.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{ __('contacts.title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

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


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div class="flex-grow-1">
                                    <button class="btn btn-primary add-btn" data-bs-toggle="modal"
                                        data-bs-target="#showModal"><i class="ri-add-fill me-1 align-bottom"></i>
                                        {{ __('contacts.add') }}</button>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="hstack text-nowrap gap-2">
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                        <button class="btn btn-secondary"><i class="ri-filter-2-line me-1 align-bottom"></i>
                                            {{ __('contacts.filters') }}</button>
                                        <button class="btn btn-soft-primary" data-bs-toggle="modal"
                                            data-bs-target="#importModal">{{ __('contacts.import') }}</button>
                                        <a href="{{ route('contacts.export') }}"
                                            class="btn btn-soft-success">{{ __('contacts.export') }}</a>
                                        <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                            aria-expanded="false" class="btn btn-soft-secondary"><i
                                                class="ri-more-2-fill"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                            <li><a class="dropdown-item" href="#">All</a></li>
                                            <li><a class="dropdown-item" href="#">Last Week</a></li>
                                            <li><a class="dropdown-item" href="#">Last Month</a></li>
                                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-9" id="contact-content-area">
                    <div class="card" id="contactList">
                        <div class="card-header">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="search-box">
                                        <input type="text" class="form-control search"
                                            placeholder="{{ __('contacts.search') }}">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-auto ms-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted">{{ __('contacts.sort_by') }}: </span>
                                        <select class="form-control mb-0" data-choices data-choices-search-false
                                            id="choices-single-default">
                                            <option value="name">{{ __('contacts.name') }}</option>
                                            <option value="company_name">{{ __('contacts.company') }}</option>
                                            <option value="lead_score">{{ __('contacts.lead') }}</option>
                                            <option value="created_at">{{ __('contacts.created_at') }}</option>
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
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th data-sort="name" scope="col">{{ __('contacts.name') }}</th>
                                                <th data-sort="company_name" scope="col">{{ __('contacts.company') }}
                                                </th>
                                                <th data-sort="email_id" scope="col">{{ __('contacts.email') }}</th>
                                                <th data-sort="phone" scope="col">{{ __('contacts.phone') }}</th>
                                                <th data-sort="lead_score" scope="col">{{ __('contacts.lead_score') }}
                                                </th>
                                                <th data-sort="tags" scope="col">{{ __('contacts.tags') }}</th>
                                                <th data-sort="date" scope="col">{{ __('contacts.last_contacted') }}
                                                </th>
                                                <th scope="col">{{ __('contacts.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($contacts as $contact)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="chk_child" value="option1">
                                                        </div>
                                                    </th>
                                                    <td class="id" style="display:none;"><a
                                                            href="javascript:void(0);"
                                                            class="fw-medium link-primary">#VZ001</a></td>
                                                    <td class="name">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0"><img
                                                                    src="assets/images/users/avatar-10.jpg" alt=""
                                                                    class="avatar-xs rounded-circle"></div>
                                                            <div class="flex-grow-1 ms-2 name">{{ $contact->name }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="company_name">{{ $contact->company_name }}</td>
                                                    <td class="email_id">{{ $contact->email }}</td>
                                                    <td class="phone">{{ $contact->phone }}</td>
                                                    <td class="lead_score">{{ $contact->lead_score }}</td>
                                                    <td class="tags">
                                                        @if ($contact->tags->count() > 0)
                                                            @foreach ($contact->tags as $tag)
                                                                <span
                                                                    class="badge bg-primary-subtle text-primary">{{ $tag->name }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="date">
                                                        {{ isset($contact->last_contacted) ? $contact->last_contacted->format('d M, Y') : 'Yok' }}
                                                        <small
                                                            class="text-muted">{{ isset($contact->last_contacted) ? $contact->last_contacted->format('H:i') : '' }}</small>
                                                    </td>
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="{{ __('contacts.call') }}">
                                                                <a href="javascript:void(0);"
                                                                    class="text-muted d-inline-block">
                                                                    <i class="ri-phone-line fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="{{ __('contacts.message') }}">
                                                                <a href="javascript:void(0);"
                                                                    class="text-muted d-inline-block">
                                                                    <i class="ri-question-answer-line fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-soft-primary btn-sm dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill align-middle"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a class="dropdown-item view-item-btn"
                                                                                href="javascript:void(0);"><i
                                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>{{ __('contacts.view') }}</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item edit-item-btn"
                                                                                href="javascript:void(0);"
                                                                                onclick="EditContact({{ $contact->id }})"><i
                                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                                {{ __('contacts.edit') }}</a></li>
                                                                        <li><a class="dropdown-item remove-item-btn"

                                                                                href="javascript:void(0);"
                                                                                onclick="deleteContact({{ $contact->id }})"><i
                                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                                {{ __('contacts.delete') }}</a></li>
                                                                    </ul>
                                                                </div>
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
                                            <p class="text-muted mb-0">We've searched more than 150+ contacts We did not
                                                find any contacts for you search.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            {{ __('contacts.previous') }}
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            {{ __('contacts.next') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0">
                                        <div class="modal-header bg-primary-subtle p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <span
                                                    id="modalTitle">{{ isset($contact) ? __('contacts.edit_contact') : __('contacts.add_contact') }}</span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" autocomplete="off" id="contactForm" method="POST"
                                            action="{{ route('contacts.store') }}">
                                            @csrf
                                            <input type="hidden" name="_method" id="method" value="POST">
                                            <input type="hidden" name="contact_id" id="contact_id" value="">
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <div class="position-relative d-inline-block">
                                                                <div class="position-absolute  bottom-0 end-0">
                                                                    <label for="customer-image-input" class="mb-0"
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
                                                                        id="customer-image-input" type="file"
                                                                        accept="image/png, image/gif, image/jpeg">
                                                                </div>
                                                                <div class="avatar-lg p-1">
                                                                    <div class="avatar-title bg-light rounded-circle">
                                                                        <img src="assets/images/users/user-dummy-img.jpg"
                                                                            id="customer-img"
                                                                            class="avatar-md rounded-circle object-fit-cover" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="name-field"
                                                                class="form-label">{{ __('contacts.name') }}</label>
                                                            <input type="text" name="name" id="name-field"
                                                                class="form-control"
                                                                placeholder="{{ __('contacts.enter_name') }}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="company_name-field"
                                                                class="form-label">{{ __('contacts.company_name') }}</label>
                                                            <input type="text" name="company_name"
                                                                id="company_name-field" class="form-control"
                                                                placeholder="{{ __('contacts.enter_company_name') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="designation-field"
                                                                class="form-label">{{ __('contacts.designation') }}</label>
                                                            <input type="text" name="designation"
                                                                id="designation-field" class="form-control"
                                                                placeholder="{{ __('contacts.enter_designation') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="email_id-field"
                                                                class="form-label">{{ __('contacts.email') }}</label>
                                                            <input type="text" name="email" id="email_id-field"
                                                                class="form-control"
                                                                placeholder="{{ __('contacts.enter_email') }}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="phone-field"
                                                                class="form-label">{{ __('contacts.phone') }}</label>
                                                            <input type="text" name="phone" id="phone-field"
                                                                class="form-control"
                                                                placeholder="{{ __('contacts.enter_phone') }}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="lead_score-field"
                                                                class="form-label">{{ __('contacts.lead_score') }}</label>
                                                            <input type="text" name="lead_score" id="lead_score-field"
                                                                class="form-control"
                                                                placeholder="{{ __('contacts.enter_lead_score') }}"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="taginput-choices"
                                                                class="form-label font-size-13 text-muted">{{ __('contacts.tags') }}</label>
                                                            <select class="form-control" name="tags[]"
                                                                id="taginput-choices" multiple>
                                                                @foreach ($tags as $tag)
                                                                    <option value="{{ $tag->id }}">
                                                                        {{ $tag->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">{{ __('contacts.close') }}</button>
                                                    <button type="submit" class="btn btn-success" id="submitBtn">
                                                        {{ __('contacts.add') }}
                                                    </button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- Import Modal -->
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="importModalLabel">
                                                {{ __('contacts.import_contacts') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('contacts.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="importFile"
                                                        class="form-label">{{ __('contacts.select_file') }}</label>
                                                    <input type="file" class="form-control" id="importFile"
                                                        name="file" accept=".xlsx, .xls, .csv" required>
                                                    <div class="form-text">
                                                        {{ __('contacts.allowed_formats') }}: .xlsx, .xls, .csv
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>{{ __('contacts.import_instructions') }}</h6>
                                                    <ul class="text-muted small">
                                                        <li>{{ __('contacts.required_columns') }}: isim, e_posta, telefon
                                                        </li>
                                                        <li>{{ __('contacts.optional_columns') }}: sirket_adi, pozisyon,
                                                            lead_skoru, etiketler, son_iletisim_tarihi</li>
                                                    </ul>
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">{{ __('contacts.close') }}</button>
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ __('contacts.upload_and_import') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Import Modal -->

                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-3" id="contact-detail-area">
                    <div class="card" id="contact-view-detail" style="display: none;">
                        <!-- Kişi detayları burada dinamik olarak yüklenecek -->
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
        // Choices.js instance’ı globalde tutuyoruz
        const tagInputField = new Choices("#taginput-choices", {
            removeItemButton: true,
            searchEnabled: true,
            searchChoices: true,
            searchFloor: 1,
            placeholder: true,
            placeholderValue: 'Etiket seçin veya arayın...',
            noResultsText: 'Sonuç bulunamadı',
            itemSelectText: 'Seçmek için tıklayın'
        });

        // Kişi düzenleme fonksiyonu
        function EditContact(id) {
            // Modal başlık ve buton metinlerini ayarla
            document.getElementById('modalTitle').innerText = "{{ __('contacts.edit_contact') }}";
            document.getElementById('method').value = "PUT";
            document.getElementById('submitBtn').innerText = "{{ __('contacts.edit') }}";
            document.getElementById('contact_id').value = id;
            document.getElementById('contactForm').action = "{{ route('contacts.index') }}/" + id;

            // Verileri AJAX ile çek
            fetch("{{ route('contacts.index') }}/" + id + "/edit", {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Form alanlarını doldur
                    document.getElementById('name-field').value = data.name || '';
                    document.getElementById('company_name-field').value = data.company_name || '';
                    document.getElementById('designation-field').value = data.designation || '';
                    document.getElementById('email_id-field').value = data.email || '';
                    document.getElementById('phone-field').value = data.phone || '';
                    document.getElementById('lead_score-field').value = data.lead_score || '';

                    if (data.image) {
                        document.getElementById('customer-img').src = `/storage/${data.image}`;
                    }

                    // Etiketleri güncelle
                    tagInputField.removeActiveItems();
                    if (Array.isArray(data.tag_ids)) {
                        data.tag_ids.forEach(tagId => {
                            tagInputField.setChoiceByValue(String(tagId));
                        });
                    }

                    // Modalı göster
                    new bootstrap.Modal(document.getElementById('showModal')).show();
                })
                .catch(err => {
                    console.error('EditContact error:', err);
                    alert('Veriler yüklenirken bir hata oluştu!');
                });
        }

        // Form submit override (PUT için)
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            if (document.getElementById('method').value === 'PUT') {
                e.preventDefault();
                const formData = new FormData(this);
                const contactId = document.getElementById('contact_id').value;

                fetch("{{ route('contacts.index') }}/" + contactId, {
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
                    .catch(() => alert('Kayıt düzenlenirken bir hata oluştu!'));
            }
        });

        // Formu sıfırlarken etiketleri de temizle
        document.getElementById('close-modal').addEventListener('click', resetForm);

        function resetForm() {
            document.getElementById('contactForm').reset();
            document.getElementById('method').value = 'POST';
            document.getElementById('contact_id').value = '';
            document.getElementById('modalTitle').innerText = "{{ __('contacts.add_contact') }}";
            document.getElementById('submitBtn').innerText = "{{ __('contacts.add') }}";
            document.getElementById('contactForm').action = "{{ route('contacts.store') }}";
            document.getElementById('customer-img').src = "assets/images/users/user-dummy-img.jpg";
            tagInputField.removeActiveItems();
        }

        // Detay paneli & görüntüle tuşu davranışı
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.view-item-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tr = this.closest('tr');
                    const contactId = tr.querySelector('.edit-item-btn').getAttribute('onclick')
                        .match(/\d+/)[0];

                    fetch("{{ route('contacts.details', ['id' => ':id']) }}".replace(':id',
                            contactId), {
                            method: 'GET',
                            headers: {
                                'Accept': 'text/html',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            const detail = document.getElementById('contact-view-detail');
                            detail.innerHTML = html;
                            detail.style.display = 'block';
                            document.getElementById('contact-content-area').classList.replace(
                                'col-xxl-12', 'col-xxl-9');
                            document.getElementById('contact-detail-area').style.display =
                                'block';

                            document.getElementById('contact-detail-close')?.addEventListener(
                                'click', () => {
                                    detail.style.display = 'none';
                                    document.getElementById('contact-detail-area').style
                                        .display = 'none';
                                    document.getElementById('contact-content-area')
                                        .classList.replace('col-xxl-9', 'col-xxl-12');
                                });
                        })
                        .catch(() => alert('Detaylar yüklenirken bir hata oluştu!'));
                });
            });

            // Başlangıçta detay kapalıysa alanı genişlet
            const detailPanel = document.getElementById('contact-view-detail');
            if (detailPanel.style.display === 'none') {
                document.getElementById('contact-detail-area').style.display = 'none';
                document.getElementById('contact-content-area').classList.replace('col-xxl-9', 'col-xxl-12');
            }
        });

        function deleteContact(contactId) {
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
          <h4>{{ __('contacts.delete_contact') }}</h4>
          <p class="text-muted mx-4 mb-0">{{ __('contacts.delete_contact_info') }}</p>
        </div>
      </div>`,
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mb-1",
                    cancelButton: "btn btn-danger w-xs mb-1",
                },
                cancelButtonText: "{{ __('contacts.no') }}",
                confirmButtonText: "{{ __('contacts.yes') }}",
                buttonsStyling: false,
                showCloseButton: true
            }).then((result) => {
                if (!result.isConfirmed) return;

                // 2️⃣ Onay verildiyse silme isteğini yolla
                const destroyUrlTemplate = "{{ route('contacts.destroy', ':id') }}";
                fetch(destroyUrlTemplate.replace(':id', contactId), {
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
                <h4>{{ __('contacts.contact_deleted') }}</h4>
                <p class="text-muted mx-4 mb-0">{{ __('contacts.contact_deleted_info') }}</p>
              </div>
            </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                cancelButtonText: "{{ __('contacts.back') }}",
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
                <p class="text-muted mx-4 mb-0">${data.message || 'Silme işlemi başarısız oldu.'}</p>
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
              <p class="text-muted mx-4 mb-0">Bir hata oluştu. Lütfen tekrar deneyin.</p>
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
