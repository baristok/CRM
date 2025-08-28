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
                    @foreach ($dealsTitle as $dealsTitle)
                        <div class="col deal-column">
                            <div class="card">
                                <a class="card-body {{ $dealsTitle->title_badge_class }}" data-bs-toggle="collapse"
                                    href="#{{ Str::slug($dealsTitle->name, '_') }}" role="button" aria-expanded="true"
                                    aria-controls="{{ Str::slug($dealsTitle->name, '_') }}">
                                    <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">
                                        {{ $dealsTitle->title }}
                                    </h5>
                                    <p class="text-muted mb-0">
                                        $0 <span class="fw-medium deal-count-badge">0 Deals</span>
                                    </p>
                                </a>

                                <div class="card-body deals-list">
                                    <div class="collapse show" id="{{ Str::slug($dealsTitle->name, '_') }}">
                                        @foreach ($deals as $deal)
                                            @if ($deal->deals_title_id == $dealsTitle->id)
                                                <div class="card mb-1 ribbon-box ribbon-fill ribbon-sm deal-item">


                                                    @if ($dealsTitle->name == 'Proposal Sent')
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
                                                                    ${{ number_format($deal->value ?? 0) }} -
                                                                    {{ $deal->created_at ? $deal->created_at->format('d M, Y') : 'N/A' }}
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="collapse border-top border-top-dashed"
                                                        id="deal{{ $deal->id }}">
                                                        <div class="card-body">
                                                            <h6 class="fs-14 mb-1">
                                                                {{ $deal->company_name ?? 'N/A' }}
                                                                @if ($deal->due_date)
                                                                    <small class="badge bg-danger-subtle text-danger">
                                                                        {{ \Carbon\Carbon::parse($deal->due_date)->diffForHumans() }}
                                                                    </small>
                                                                @endif
                                                            </h6>
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
                                        Create Deals
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="needs-validation" novalidate id="deals-form" onsubmit="return false">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="deatType" class="form-label">Deals Type</label>
                                            <select class="form-select" id="deatType" data-choices
                                                aria-label="Default select example" required>
                                                <option value="" data-custom-properties="[object Object]">
                                                    Select deals type
                                                </option>
                                                <option value="Lead Disovered">Lead Disovered</option>
                                                <option value="Contact Initiated">
                                                    Contact Initiated
                                                </option>
                                                <option value="Need Identified">
                                                    Need Identified
                                                </option>
                                                <option value="Meeting Arranged">
                                                    Meeting Arranged
                                                </option>
                                                <option value="Offer Accepted">Offer Accepted</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please write an deals owner name.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dealTitle" class="form-label">Deal Title</label>
                                            <input type="text" class="form-control" id="dealTitle"
                                                placeholder="Enter title" required />
                                            <div class="invalid-feedback">
                                                Please write a title.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dealValue" class="form-label">Value (USD)</label>
                                            <input type="number" class="form-control" id="dealValue" step="0.01"
                                                placeholder="Enter value" required />
                                            <div class="invalid-feedback">
                                                Please write a value.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dealOwner" class="form-label">Deals Owner</label>
                                            <input type="text" class="form-control" id="dealOwner" required
                                                placeholder="Enter owner name" />
                                            <div class="invalid-feedback">
                                                Please write an deals owner name.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dueDate" class="form-label">Due Date</label>
                                            <input type="text" class="form-control" id="dueDate"
                                                data-provider="flatpickr" placeholder="Select date" required />
                                            <div class="invalid-feedback">
                                                Please select a due date.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dealEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="dealEmail"
                                                placeholder="Enter email" required />
                                            <div class="invalid-feedback">
                                                Please write a email.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="contactNumber" class="form-label">Contact</label>
                                            <input type="text" class="form-control" id="contactNumber"
                                                placeholder="Enter contact number" required />
                                            <div class="invalid-feedback">
                                                Please add a contact.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contactDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="contactDescription" rows="3" placeholder="Enter description" required></textarea>
                                            <div class="invalid-feedback">
                                                Please add a description.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" id="close-modal"
                                            data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line align-bottom me-1"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->
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
                        if (dealsContainer && badge) {
                            var dealCount = dealsContainer.querySelectorAll('.deal-item').length;
                            badge.textContent = dealCount;
                        }
                    });
                }

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    initializeDealsKanban();
                });
            </script>
        @endsection
