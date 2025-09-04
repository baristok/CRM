@extends('layouts.index')

@section('title', __('deals.title') . ' | CRM Barış Tok')

@section('css')
    <!-- SortableJS css -->
    <style>
        .sortable-ghost {
            opacity: 0.5;
            background: #f8f9fa;
        }

        .sortable-chosen {
            transform: rotate(5deg);
        }

        .sortable-drag {
            transition: transform 0.18s ease;
            transform: rotate(5deg);
        }

        .tasks-list {
            min-height: 200px;
            padding: 10px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            flex-wrap: nowrap;
        }

        .tasks-list.sortable-over {
            background-color: #e3f2fd;
        }

        .deals-container {
            overflow-x: auto;
            overflow-y: hidden;
            padding: 1rem;
            margin: -1rem;
        }

        .deal-column {
            min-width: 280px;
            max-width: 280px;
            flex: 0 0 280px;
        }

        .deal-column .card {
            border: none;
            background: transparent;
        }

        .deal-column .card-body {
            border: none;
            padding: 1rem;
            background: var(--vz-card-bg);
            border-radius: 0.375rem;
        }

        .deals-list .card {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
        }
    </style>
@endsection

@section('content')

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
                    cancelButtonText: "{{ __('notes.ok') }}",
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
                    cancelButtonText: "{{ __('notes.okey') }}",
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
                        <h4 class="mb-sm-0">{{ __('deals.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">CRM</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('deals.title') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button data-bs-toggle="modal" data-bs-target="#adddeals" class="btn btn-primary">
                                <i class="ri-add-fill align-bottom me-1"></i> {{ __('deals.add') }}
                            </button>
                        </div>
                        <!--end col-->
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex hastck gap-2 flex-wrap">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted">Sort by: </span>
                                    <select class="form-control mb-0" data-choices data-choices-search-false
                                        id="choices-single-default">
                                        <option value="Owner">Owner</option>
                                        <option value="Company">Company</option>
                                        <option value="Date">Date</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end card-->

            <div class="deals-container overflow-auto" style="height: 50rem;">
                <div class="d-flex tasks-list gap-3" data-sortable-group="kanban" data-sortable-animation="150">
                    @foreach ($dealsTitle as $title)
                        <div class="col deal-column">
                            <div class="card">
                                <a class="card-body {{ $title->title_badge_class }}" data-bs-toggle="collapse"
                                    href="#{{ Str::slug($title->name, '_') }}" role="button" aria-expanded="true"
                                    aria-controls="{{ Str::slug($title->name, '_') }}">
                                    <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">
                                        {{ $title->title }}
                                    </h5>
                                    <p class="text-muted mb-0">
                                        <span class="deal-total-value">₺0</span> <span class="fw-medium deal-count-badge">0 {{ __('deals.deals') }}</span>
                                    </p>
                                </a>

                                <div class="card-body deals-list">
                                    <div class="collapse show" id="{{ Str::slug($title->name, '_') }}"
                                        data-deals-title-id="{{ $title->id }}">
                                        @foreach ($deals as $deal)
                                            @if ($deal->deals_title_id == $title->id)
                                                <div class="card mb-1 ribbon-box ribbon-fill ribbon-sm deal-item"
                                                    data-deal-id="{{ $deal->id }}"
                                                    data-position="{{ $loop->index }}">


                                                    @if ($title->name == 'Proposal Sent')
                                                        <div class="ribbon ribbon-primary">
                                                            <i class="ri-briefcase-line"></i>
                                                        </div>
                                                        {{-- Geçmiş tarihli deal'lar için kırmızı ribbon --}}
                                                    @elseif ($deal->due_date && $deal->due_date < now()->startOfDay())
                                                        <div class="ribbon ribbon-danger">
                                                            <i class="ri-alarm-warning-line"></i>
                                                        </div>
                                                        {{-- 1 hafta kala olan deal'lar için turuncu ribbon --}}
                                                    @elseif ($deal->due_date && $deal->due_date <= now()->addDays(7) && $deal->due_date >= now()->startOfDay())
                                                        <div class="ribbon ribbon-warning">
                                                            <i class="ri-time-line"></i>
                                                        </div>
                                                    @endif

                                                    <div class="card-body">
                                                        <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                                            href="#deal{{ $deal->id }}" role="button"
                                                            aria-expanded="false" aria-controls="deal{{ $deal->id }}">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-2.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="fs-14 mb-1">
                                                                    {{ $deal->title ?? 'Untitled Deal' }}
                                                                </h6>
                                                                <p class="text-muted mb-0">
                                                                    @if ($deal->currency == 'TRY')
                                                                    <i class="bx bx-lira"></i> {{ number_format($deal->value ?? 0) }} ({{ $deal->currency }}) 
                                                                    @else
                                                                        <i class="bx bx-dollar"></i> {{ number_format($deal->value ?? 0) }} ({{ $deal->currency }}) 
                                                                    @endif
                                                                    -
                                                                    {{ $deal->created_at ? $deal->created_at->format('d M, Y') : 'N/A' }}
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="collapse border-top border-top-dashed"
                                                        id="deal{{ $deal->id }}">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <h6 class="fs-14 mb-1">
                                                                    @if ($deal->owner_type == 'company')
                                                                        @php
                                                                            $company = collect($companies)->firstWhere(
                                                                                'id',
                                                                                $deal['owner_id'],
                                                                            );
                                                                        @endphp
                                                                        {{ $company['name'] ?? 'N/A' }}
                                                                    @else
                                                                        @php
                                                                            $contact = collect($contacts)->firstWhere(
                                                                                'id',
                                                                                $deal['owner_id'],
                                                                            );
                                                                        @endphp
                                                                        {{ $contact['name'] ?? 'N/A' }}
                                                                    @endif
                                                                    @if ($deal->due_date)
                                                                        <small class="badge bg-danger-subtle text-danger">
                                                                            {{ \Carbon\Carbon::parse($deal->due_date)->diffForHumans() }}
                                                                        </small>
                                                                    @endif
                                                                </h6>

                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-ghost-secondary btn-sm dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-2-fill align-middle"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a class="dropdown-item" href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editDealModal"
                                                                                onclick="editDeal({{ $deal->id }})"><i
                                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>Düzenle</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#addNoteModal"
                                                                                onclick="addNote({{ $deal->id }})"><i
                                                                                    class=" ri-sticky-note-fill align-bottom me-2 text-muted"></i>Not
                                                                                Ekle</a></li>
                                                                        <li>
                                                                            <hr class="dropdown-divider">
                                                                        </li>
                                                                        <li><a class="dropdown-item text-danger"
                                                                                href="#"
                                                                                onclick="deleteDeal({{ $deal->id }})"><i
                                                                                    class="ri-delete-bin-fill align-bottom me-2 text-danger"></i>Sil</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted">
                                                                {{ $deal->description ?? 'No description available' }}
                                                            </p>
                                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                                @if ($deal->notes && $deal->notes->count() > 0)
                                                                    @foreach ($deal->notes->take(3) as $note)
                                                                        <li>
                                                                            <div class="d-flex">
                                                                                <div
                                                                                    class="flex-shrink-0 avatar-xxs text-muted">
                                                                                    <i class="ri-question-answer-line"></i>
                                                                                </div>
                                                                                <div class="flex-grow-1">
                                                                                    <h6 class="mb-0">
                                                                                        {{ Str::limit($note->title, 30) }}
                                                                                    </h6>
                                                                                    <small
                                                                                        class="text-muted">{{ $note->created_at->format('d M, Y \a\t h:iA') }}</small>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <div class="d-flex">
                                                                            <div
                                                                                class="flex-shrink-0 avatar-xxs text-muted">
                                                                                <i class="ri-information-line"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <h6 class="mb-0">No notes available</h6>
                                                                                <small class="text-muted">Add notes to
                                                                                    track
                                                                                    progress</small>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="card-footer hstack gap-2">
                                                            <button class="btn btn-primary btn-sm w-100">
                                                                <i class="ri-phone-line align-bottom me-1"></i> Call
                                                            </button>
                                                            <button class="btn btn-secondary btn-sm w-100">
                                                                <i class="ri-question-answer-line align-bottom me-1"></i>
                                                                Message
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach



                    <!-- Modal -->
                    <div class="modal fade" id="adddeals" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ __('deals.create_deals') }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="needs-validation" novalidate id="deals-form" method="POST"
                                    action="{{ route('deals.store') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="deatType" class="form-label">{{ __('deals.deal_type') }}</label>
                                            <select class="form-select" id="deatType" data-choices
                                                aria-label="Default select example" required name="deals_title_id">
                                                <option selected disabled value="">
                                                    {{ __('deals.select_a_deal_type') }}</option>
                                                @foreach ($dealsTitle as $dealTitle)
                                                    @if ($dealTitle->default_title != false)
                                                        <option value="{{ $dealTitle->id }}">{{ $dealTitle->title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $dealTitle->id }}">{{ $dealTitle->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_an_deals_owner_name') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dealTitle"
                                                class="form-label">{{ __('deals.deal_title') }}</label>
                                            <input type="text" class="form-control" id="dealTitle" name="title"
                                                placeholder="{{ __('deals.please_write_a_title') }}" required />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_a_title') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dealValue" class="form-label">{{ __('deals.value') }} </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="dealValue" name="value"
                                                    step="0.01" placeholder="{{ __('deals.please_write_a_value') }}"
                                                    required />
                                                <select class="form-select" id="dealCurrency" name="currency"
                                                    style="max-width: 100px;" required>
                                                    <option value="TRY">₺ TRY</option>
                                                    <option value="USD">$ USD</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_a_value') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dealOwner"
                                                class="form-label">{{ __('deals.deal_owner') }}</label>
                                            <select class="form-select" id="dealOwner" name="owner_id" data-choices
                                                data-choices-search-true aria-label="Default select example" required>
                                                <option selected disabled value="">
                                                    {{ __('deals.please_write_an_deals_owner_name') }}</option>
                                                @foreach ($companies as $company)
                                                    <option value="company:{{ $company['id'] }}"
                                                        data-email="{{ $company['contact_email'] ?? '' }}" data-phone=""
                                                        data-type="company">{{ $company['name'] }}</option>
                                                @endforeach
                                                @foreach ($contacts as $contact)
                                                    <option value="contact:{{ $contact['id'] }}"
                                                        data-email="{{ $contact['email'] ?? '' }}"
                                                        data-phone="{{ $contact['phone'] ?? '' }}" data-type="contact">
                                                        {{ $contact['name'] }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_an_deals_owner_name') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dueDate" class="form-label">{{ __('deals.due_date') }}</label>
                                            <input type="text" class="form-control" id="dueDate"
                                                data-provider="flatpickr"
                                                placeholder="{{ __('deals.please_select_a_date') }}" required
                                                name="due_date" format="Y-m-d" />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_select_a_date') }}
                                            </div>
                                        </div>

                                        @php

                                        @endphp

                                        <div class="mb-3">
                                            <label for="dealEmail" class="form-label">{{ __('deals.email') }}</label>
                                            <input type="email" class="form-control" id="dealEmail"
                                                placeholder="{{ __('deals.please_write_a_email') }}" required
                                                name="email" />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_a_email') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="contactNumber"
                                                class="form-label">{{ __('deals.contact') }}</label>
                                            <input type="text" class="form-control" id="contactNumber"
                                                placeholder="{{ __('deals.please_enter_contact_number') }}" required
                                                name="phone" />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_enter_contact_number') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contactDescription"
                                                class="form-label">{{ __('deals.description') }}</label>
                                            <textarea class="form-control" id="contactDescription" rows="3"
                                                placeholder="{{ __('deals.please_enter_contact_description') }}" required name="description"></textarea>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_enter_contact_description') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" id="close-modal"
                                            data-bs-dismiss="modal">
                                            {{ __('deals.close') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line align-bottom me-1"></i> {{ __('deals.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->

                    <!-- Edit Deal Modal -->
                    <div class="modal fade" id="editDealModal" tabindex="-1" aria-labelledby="editDealModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="editDealModalLabel">
                                        {{ __('deals.edit_deal') }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="needs-validation" novalidate id="edit-deals-form" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="editDealId" name="deal_id" />
                                        <div class="mb-3">
                                            <label for="editDeatType"
                                                class="form-label">{{ __('deals.deal_type') }}</label>
                                            <select class="form-select" id="editDeatType"
                                                aria-label="Default select example" required name="deals_title_id">
                                                <option selected disabled value="">
                                                    {{ __('deals.select_a_deal_type') }}</option>
                                                @foreach ($dealsTitle as $dealTitle)
                                                    <option value="{{ $dealTitle->id }}">{{ $dealTitle->title }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_an_deals_owner_name') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editDealTitle"
                                                class="form-label">{{ __('deals.deal_title') }}</label>
                                            <input type="text" class="form-control" id="editDealTitle" name="title"
                                                placeholder="{{ __('deals.please_write_a_title') }}" required />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_a_title') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editDealValue" class="form-label">{{ __('deals.value') }}
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="editDealValue"
                                                    name="value" step="0.01"
                                                    placeholder="{{ __('deals.please_write_a_value') }}" required />
                                                <select class="form-select" id="editDealCurrency" name="currency"
                                                    style="max-width: 100px;" required>
                                                    <option value="TRY">₺ TRY</option>
                                                    <option value="USD">$ USD</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_a_value') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editDealOwner"
                                                class="form-label">{{ __('deals.deal_owner') }}</label>
                                            <select class="form-select" id="editDealOwner" name="owner_id"
                                                aria-label="Default select example" required>
                                                <option selected disabled value="">
                                                    {{ __('deals.please_write_an_deals_owner_name') }}</option>
                                                @foreach ($companies as $company)
                                                    <option value="company:{{ $company['id'] }}"
                                                        data-email="{{ $company['contact_email'] ?? '' }}" data-phone=""
                                                        data-type="company">{{ $company['name'] }}</option>
                                                @endforeach
                                                @foreach ($contacts as $contact)
                                                    <option value="contact:{{ $contact['id'] }}"
                                                        data-email="{{ $contact['email'] ?? '' }}"
                                                        data-phone="{{ $contact['phone'] ?? '' }}" data-type="contact">
                                                        {{ $contact['name'] }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_an_deals_owner_name') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="editDueDate"
                                                class="form-label">{{ __('deals.due_date') }}</label>
                                            <input type="text" class="form-control" id="editDueDate"
                                                data-provider="flatpickr"
                                                placeholder="{{ __('deals.please_select_a_date') }}" required
                                                name="due_date" format="Y-m-d" />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_select_a_date') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="editDealEmail" class="form-label">{{ __('deals.email') }}</label>
                                            <input type="email" class="form-control" id="editDealEmail"
                                                placeholder="{{ __('deals.please_write_a_email') }}" required
                                                name="email" />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_write_a_email') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="editContactNumber"
                                                class="form-label">{{ __('deals.contact') }}</label>
                                            <input type="text" class="form-control" id="editContactNumber"
                                                placeholder="{{ __('deals.please_enter_contact_number') }}" required
                                                name="phone" />
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_enter_contact_number') }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editContactDescription"
                                                class="form-label">{{ __('deals.description') }}</label>
                                            <textarea class="form-control" id="editContactDescription" rows="3"
                                                placeholder="{{ __('deals.please_enter_contact_description') }}" required name="description"></textarea>
                                            <div class="invalid-feedback">
                                                {{ __('deals.please_enter_contact_description') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" id="close-edit-modal"
                                            data-bs-dismiss="modal">
                                            {{ __('deals.close') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line align-bottom me-1"></i> Güncelle
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end edit modal-->

                </div>
                <!-- container-fluid -->
            </div>









        @endsection

        @section('js')
            <!-- SortableJS -->
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

            <!-- Deals Kanban Script -->
            <script>
                // Global variables for Deals Kanban
                var dealsSortableInstances = [];

                // Edit modal Choices.js instances
                var editDealTypeChoices = null;
                var editDealOwnerChoices = null;

                // Dinamik olarak task list başlıklarını al
                function getDealsTaskLists() {
                    var taskLists = [];

                    // Default titles için
                    @foreach ($defaultTitles as $defaultTitle)
                        taskLists.push('{{ Str::slug($defaultTitle->name, '_') }}');
                    @endforeach

                    // User titles için
                    @foreach ($userTitles as $userTitle)
                        taskLists.push('{{ Str::slug($userTitle->name, '_') }}');
                    @endforeach

                    return taskLists;

                }

                // Initialize kanban functionality for deals
                function initializeDealsKanban() {
                    // Destroy existing instances
                    if (dealsSortableInstances.length > 0) {
                        dealsSortableInstances.forEach(function(instance) {
                            instance.destroy();
                        });
                        dealsSortableInstances = [];
                    }

                    // Dinamik olarak task list başlıklarını al
                    var dealsTaskLists = getDealsTaskLists();

                    // Create sortable instances for each deals column
                    dealsTaskLists.forEach(function(listId) {
                        var element = document.getElementById(listId);
                        if (element) {
                            var sortable = Sortable.create(element, {
                                group: 'deals-kanban',
                                animation: 150,
                                ghostClass: 'sortable-ghost',
                                chosenClass: 'sortable-chosen',
                                dragClass: 'sortable-drag',
                                scroll: true,
                                scrollSensitivity: 50,
                                scrollSpeed: 10,
                                bubbleScroll: true,
                                onStart: function(evt) {
                                    evt.item.classList.remove('ex-moved');
                                },
                                onAdd: function(evt) {
                                    evt.item.classList.add('ex-moved');
                                    updateDealsCounters();
                                    removeNoDealImage();
                                },
                                onUpdate: function(evt) {
                                    updateDealsCounters();
                                },
                                onRemove: function(evt) {
                                    updateDealsCounters();
                                    removeNoDealImage();
                                },
                                onEnd: function(evt) {
                                    removeNoDealImage();
                                    updateDealsCounters();

                                    // onDragEnd fonksiyonunu çağır
                                    if (evt.item && evt.to) {
                                        var dealsTitleId = evt.to.getAttribute('data-deals-title-id');
                                        if (dealsTitleId) {
                                            onDragEnd(evt, dealsTitleId);
                                        }
                                    }
                                }
                            });
                            dealsSortableInstances.push(sortable);
                        }
                    });

                    removeNoDealImage();
                    updateDealsCounters();
                }

                // Remove "no deal" styling when deals are present
                function removeNoDealImage() {
                    var dealsTaskLists = getDealsTaskLists();
                    dealsTaskLists.forEach(function(listId) {
                        var container = document.getElementById(listId);
                        if (container) {
                            var dealsCount = container.querySelectorAll('.deal-item').length;
                            if (dealsCount > 0) {
                                container.classList.remove('noTask');
                            } else {
                                container.classList.add('noTask');
                            }
                        }
                    });
                }

                // Update deal counters in badges
                function updateDealsCounters() {
                    var dealColumns = document.querySelectorAll('.deal-column');
                    dealColumns.forEach(function(column) {
                        var dealsContainer = column.querySelector('.deals-list');
                        var badge = column.querySelector('.deal-count-badge');
                        var totalValueSpan = column.querySelector('.deal-total-value');
                        
                        if (dealsContainer && badge) {
                            var dealCount = dealsContainer.querySelectorAll('.deal-item').length;
                            badge.textContent = dealCount + ' {{ __("deals.deals") }}';
                        }
                        
                        // Para birimi hesaplama
                        if (dealsContainer && totalValueSpan) {
                            updateDealTotalValue(dealsContainer, totalValueSpan);
                        }
                    });
                }

                // Para birimi toplamını hesapla ve göster
                function updateDealTotalValue(dealsContainer, totalValueSpan) {
                    var deals = dealsContainer.querySelectorAll('.deal-item');
                    var tryTotal = 0;
                    var usdTotal = 0;
                    
                    deals.forEach(function(deal) {
                        // Deal'ın para birimi ve değerini al
                        var dealValueElement = deal.querySelector('.flex-grow-1 .text-muted');
                        if (dealValueElement) {
                            var dealText = dealValueElement.textContent;
                            
                            // TRY para birimi kontrolü
                            if (dealText.includes('TRY')) {
                                var tryMatch = dealText.match(/([\d,]+)\s*\(TRY\)/);
                                if (tryMatch) {
                                    var value = parseFloat(tryMatch[1].replace(/,/g, ''));
                                    if (!isNaN(value)) {
                                        tryTotal += value;
                                    }
                                }
                            }
                            
                            // USD para birimi kontrolü
                            if (dealText.includes('USD')) {
                                var usdMatch = dealText.match(/([\d,]+)\s*\(USD\)/);
                                if (usdMatch) {
                                    var value = parseFloat(usdMatch[1].replace(/,/g, ''));
                                    if (!isNaN(value)) {
                                        usdTotal += value;
                                    }
                                }
                            }
                        }
                    });
                    
                    // Sonucu göster
                    var resultText = '';
                    if (tryTotal > 0 && usdTotal > 0) {
                        resultText = '<i class="bx bx-lira"></i>' + formatNumber(tryTotal) + ' + <i class="bx bx-dollar"></i>' + formatNumber(usdTotal);
                    } else if (tryTotal > 0) {
                        resultText = '<i class="bx bx-lira"></i>' + formatNumber(tryTotal);
                    } else if (usdTotal > 0) {
                        resultText = '<i class="bx bx-dollar"></i>' + formatNumber(usdTotal);
                    } else {
                        resultText = '₺0';
                    }
                    
                    totalValueSpan.innerHTML = resultText;
                }

                // Sayı formatla (virgül ekle)
                function formatNumber(num) {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                // Email ve telefon otomatik doldurma fonksiyonu
                function autoFillContactInfo(selectElement) {
                    var emailInput = document.getElementById('dealEmail');
                    var phoneInput = document.getElementById('contactNumber');
                    var selectedOption = selectElement.options[selectElement.selectedIndex];

                    if (selectedOption) {
                        // Email doldur
                        var email = selectedOption.dataset.email;
                        if (emailInput && email) {
                            emailInput.value = email;
                            console.log('Email otomatik dolduruldu: ' + email);
                        }

                        // Telefon doldur (sadece contact'lar için)
                        var phone = selectedOption.dataset.phone;
                        if (phoneInput && phone) {
                            phoneInput.value = phone;
                            console.log('Telefon otomatik dolduruldu: ' + phone);
                        }
                    }
                }

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    initializeDealsKanban();

                    // Deal owner select'ine change event listener ekle
                    var dealOwnerSelect = document.getElementById('dealOwner');
                    if (dealOwnerSelect) {
                        dealOwnerSelect.addEventListener('change', function() {
                            if (this.value) {
                                autoFillContactInfo(this);
                            }
                        });
                    }
                });


                // Edit Deal fonksiyonu
                function editDeal(dealId) {
                    // AJAX ile deal bilgilerini getir
                    var editUrl = "{{ route('deals.edit', ':id') }}".replace(':id', dealId);
                    fetch(editUrl)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const deal = data.deal;

                                // Form field'larını doldur
                                document.getElementById('editDealId').value = deal.id;
                                document.getElementById('editDealTitle').value = deal.title || '';
                                document.getElementById('editDealValue').value = deal.value || '';
                                document.getElementById('editDealEmail').value = deal.email || '';
                                document.getElementById('editContactNumber').value = deal.phone || '';
                                document.getElementById('editContactDescription').value = deal.description || '';
                                document.getElementById('editDueDate').value = deal.due_date || '';

                                // Currency field (normal select)
                                if (deal.currency) {
                                    document.getElementById('editDealCurrency').value = deal.currency;
                                }

                                // Değerler modal açıldığında set edilecek

                                // Form action'ını güncelle
                                document.getElementById('edit-deals-form').action = `/deals/${deal.id}`;

                                // Modal'ı aç
                                const editModal = new bootstrap.Modal(document.getElementById('editDealModal'));
                                editModal.show();

                                // Modal tam açıldığında Choices.js'i başlat ve değerleri set et
                                document.getElementById('editDealModal').addEventListener('shown.bs.modal', function() {
                                    // Önce native select'leri güncelle
                                    if (deal.deals_title_id) {
                                        document.getElementById('editDeatType').value = deal.deals_title_id;
                                    }

                                    if (deal.owner_type && deal.owner_id) {
                                        const ownerValue = `${deal.owner_type}:${deal.owner_id}`;
                                        document.getElementById('editDealOwner').value = ownerValue;
                                    }

                                    // Şimdi Choices.js'i başlat
                                    editDealTypeChoices = new Choices('#editDeatType', {
                                        searchEnabled: true,
                                        removeItemButton: false,
                                        shouldSort: false
                                    });

                                    editDealOwnerChoices = new Choices('#editDealOwner', {
                                        searchEnabled: true,
                                        searchChoices: true,
                                        searchFloor: 1,
                                        shouldSort: false
                                    });
                                }, {
                                    once: true
                                }); // once: true ile sadece bir kez çalışır
                            } else {
                                Swal.fire({
                                    title: 'Hata!',
                                    text: 'Deal bilgileri getirilemedi!',
                                    icon: 'error',
                                    confirmButtonClass: 'btn btn-primary w-xs mt-2',
                                    buttonsStyling: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Bir hata oluştu!');
                        });
                }

                // Delete Deal fonksiyonu
                function deleteDeal(dealId) {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: 'Bu sözleşmeyi silmek istediğinize emin misiniz?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Evet, sil',
                        cancelButtonText: 'Vazgeç',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-danger w-xs me-2',
                            cancelButton: 'btn btn-secondary w-xs'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var destroyUrl = "{{ route('deals.destroy', ':id') }}".replace(':id', dealId);
                            fetch(destroyUrl, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
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
                                            <h4>Sözleşme Silindi</h4>
                                            <p class="text-muted mx-4 mb-0">Seçilen sözleşme başarıyla silindi.</p>
                                          </div>
                                        </div>`,
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            customClass: {
                                                cancelButton: 'btn btn-primary w-xs mb-1'
                                            },
                                            cancelButtonText: 'Geri Dön',
                                            buttonsStyling: false,
                                            showCloseButton: true
                                        }).then(() => window.location.reload());
                                    } else {
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
                                            <h4>Silme Hatası</h4>
                                            <p class="text-muted mx-4 mb-0">Sözleşme silinemedi!</p>
                                          </div>
                                        </div>`,
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            customClass: {
                                                cancelButton: 'btn btn-primary w-xs mb-1'
                                            },
                                            cancelButtonText: 'Geri Dön',
                                            buttonsStyling: false,
                                            showCloseButton: true
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
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
                                        <h4>Bağlantı Hatası</h4>
                                        <p class="text-muted mx-4 mb-0">Bir hata oluştu!</p>
                                      </div>
                                    </div>`,
                                        showCancelButton: true,
                                        showConfirmButton: false,
                                        customClass: {
                                            cancelButton: 'btn btn-primary w-xs mb-1'
                                        },
                                        cancelButtonText: 'Geri Dön',
                                        buttonsStyling: false,
                                        showCloseButton: true
                                    });
                                });
                        }
                    });
                }

                // Edit form submit handler
                document.getElementById('edit-deals-form').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const dealId = document.getElementById('editDealId').value;

                    var updateUrl = "{{ route('deals.update', ':id') }}".replace(':id', dealId);
                    fetch(updateUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                        })
                        .then(response => response.text())
                        .then(responseText => {
                            const data = JSON.parse(responseText);

                            if (data.success) {
                                // Modal'ı kapat
                                const editModal = bootstrap.Modal.getInstance(document.getElementById('editDealModal'));
                                editModal.hide();

                                // Başarılı güncelleme SweetAlert'i
                                Swal.fire({
                                    html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Başarılı!</h4><p class="text-muted mx-4 mb-0">Deal başarıyla güncellendi</p></div></div>',
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    customClass: {
                                        cancelButton: "btn btn-success w-xs mb-1"
                                    },
                                    cancelButtonText: "Tamam",
                                    buttonsStyling: false,
                                    showCloseButton: true
                                }).then(() => window.location.reload());
                            } else {
                                // Hata SweetAlert'i
                                Swal.fire({
                                    html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Hata!</h4><p class="text-muted mx-4 mb-0">' +
                                        (data.message || 'Deal güncellenirken bir sorun oluştu') +
                                        '</p></div></div>',
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    customClass: {
                                        cancelButton: "btn btn-danger w-xs mb-1"
                                    },
                                    cancelButtonText: "Tamam",
                                    buttonsStyling: false,
                                    showCloseButton: true
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
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
                                <h4>Bağlantı Hatası</h4>
                                <p class="text-muted mx-4 mb-0">Bir hata oluştu!</p>
                              </div>
                            </div>`,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: 'btn btn-primary w-xs mb-1'
                                },
                                cancelButtonText: 'Geri Dön',
                                buttonsStyling: false,
                                showCloseButton: true
                            });
                        });
                });

                function onDragEnd(event, dealsTitleId) {
                    // SortableJS event objesi kullanarak deal bilgilerini al
                    if (event.item) {
                        var dealId = event.item.dataset.dealId;
                        var position = event.newIndex; // SortableJS'in yeni position bilgisi
                        var oldPosition = event.oldIndex; // Eski position bilgisi
                        var fromColumn = event.from.getAttribute('data-deals-title-id');
                        var toColumn = dealsTitleId;

                        console.log("dealId: ", dealId)
                        console.log("position: ", position)
                        console.log("oldPosition: ", oldPosition)
                        console.log("fromColumn: ", fromColumn)
                        console.log("toColumn: ", toColumn)




                        // AJAX isteği ile backend'e deal'ın yeni pozisyonunu gönder
                        updateDealPosition(dealId, toColumn, position);
                    }
                }

                // Deal pozisyonunu backend'e güncelleyen fonksiyon
                function updateDealPosition(dealId, newTitleId, newPosition) {
                    var updateUrl = "{{ route('deals.updatePosition') }}";
                    fetch(updateUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                deal_id: dealId,
                                deals_title_id: newTitleId,
                                position: newPosition
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Başarı toast notification
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Deal pozisyonu güncellendi!',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            } else {
                                // Hata alert'i
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Hata!',
                                    text: data.message || 'Deal pozisyonu güncellenirken hata oluştu',
                                    showConfirmButton: true
                                });
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('AJAX hatası:', error);
                            // Network hatası alert'i
                            Swal.fire({
                                icon: 'error',
                                title: 'Bağlantı Hatası!',
                                text: 'Sunucuyla bağlantı kurulamadı. Sayfa yeniden yüklenecek.',
                                showConfirmButton: true
                            }).then(() => {
                                location.reload();
                            });
                        });
                }
            </script>
        @endsection
