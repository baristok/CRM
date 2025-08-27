@extends('layouts.index')

@section('title', __('notes.title') . ' | CRM Barış Tok')

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
        }

        .tasks-list.sortable-over {
            background-color: #e3f2fd;
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
                        <h4 class="mb-sm-0">{{ __('notes.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{ __('notes.title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <ul class="nav animation-nav nav-tabs" role="tablist" id="notesTab">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#private-notes" role="tab"
                                aria-selected="true">
                                <span><i class="ri-lock-line me-2"></i>{{ __('notes.private_notes') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#public-notes" role="tab"
                                aria-selected="false">
                                <span><i class="ri-global-line me-2"></i>{{ __('notes.public_notes') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="notesTabContent">
                        <div class="tab-pane fade show active" id="private-notes" role="tabpanel">
                            @include('notes::partials.privatenotes')
                        </div>
                        <div class="tab-pane fade" id="public-notes" role="tabpanel">
                            @include('notes::partials.publicnotes')
                        </div>
                    </div>
                </div>
            </div>









        </div>
    </div>
@endsection

@section('js')



    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <!--taks-kanban-->
    <script src="{{ asset('assets/js/pages/tasks-kanban.init.js') }}"></script>

    <script>
        // Progress slider functionality
        document.getElementById('private-tasks-progress').addEventListener('input', function() {
            const value = this.value;
            document.getElementById('private-progress-value').textContent = value + '%';
            document.getElementById('private-progress-bar').style.width = value + '%';

            // Progress bar renk değişimi
            const progressBar = document.getElementById('private-progress-bar');
            if (value < 30) {
                progressBar.className = 'progress-bar bg-danger';
            } else if (value < 80) {
                progressBar.className = 'progress-bar bg-warning';
            } else {
                progressBar.className = 'progress-bar bg-success';
            }
        });
    </script>


@endsection
