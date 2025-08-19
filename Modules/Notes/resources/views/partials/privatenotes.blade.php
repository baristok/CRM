<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-lg-auto">
                <div class="hstack gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#private-createboardModal"><i
                            class="ri-add-line align-bottom me-1"></i> {{__('notes.add_board')}}</button>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-3 col-auto">
                <div class="search-box">
                    <input type="text" class="form-control search" id="private-search-task-options"
                        placeholder="{{__('notes.search_for_project_tasks')}}">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>

            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end card-body-->
</div>
<!--end card-->

<?php
if ($boards->count() > 0) {
    $NoTask = false;
} else {
    $NoTask = true;
}
?>


<div class="tasks-board mb-3" id="private-kanbanboard">
    @foreach ($boards as $board)
        <div class="tasks-list " data-sortable-group="kanban" data-sortable-animation="150">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">{{ $board->name }} <small
                            class="badge bg-secondary align-bottom ms-1 totaltask-badge">{{ $board->notes->count() }}</small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">
                                <i class="mdi mdi-pencil-outline"></i>
                                <i class="mdi mdi-chevron-down ms-1"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item edit-board-btn" href="#" data-bs-toggle="modal"
                                data-bs-target="#private-editBoardModal" data-board-id="{{ $board->id }}"
                                data-board-name="{{ $board->name }}">{{__('notes.edit')}}</a>
                            <a class="dropdown-item delete-board-btn" href="#" data-bs-toggle="modal"
                                data-bs-target="#private-deleteBoardModal" data-board-id="{{ $board->id }}"
                                data-board-name="{{ $board->name }}">{{__('notes.delete')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="private-board-{{ $board->id }}" class="tasks" data-sortable="true"
                    data-board-id="{{ $board->id }}">
                    @foreach ($board->notes as $note)
                        <div class="card tasks-box" data-note-id="{{ $note->id }}">
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    @php
                                        $customHash = strtoupper(substr(md5($note->id . $note->created_at . $note->title), 0, 8));
                                    @endphp
                                    <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#{{ $customHash }}</a>
                                    {{-- <div class="flex-grow-1">
                                        <h6 class="fs-15 mb-0 text-truncate task-title"><a
                                                href="apps-tasks-details.html" class="d-block">{{ $note->title }}</a>
                                        </h6>
                                    </div> --}}
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="text-muted" id="private-dropdownMenuLink3"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="ri-more-fill"></i></a>
                                        <ul class="dropdown-menu" aria-labelledby="private-dropdownMenuLink3">
                                            <li><a class="dropdown-item" href="{{ route('notes.noteDetails', $note->uuid) }}"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i> {{__('notes.view')}}</a>
                                            </li>
                                            <li><a class="dropdown-item edit-note-btn" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#private-editNoteModal"
                                                    data-note-id="{{ $note->id }}">
                                                    <i class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                    {{__('notes.edit')}}</a></li>
                                            <li><a class="dropdown-item delete-note-btn" data-bs-toggle="modal"
                                                    data-bs-target="#private-deleteNoteModal"
                                                    data-note-id="{{ $note->id }}"
                                                    data-note-title="{{ $note->title }}" href="#"><i
                                                        class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                    {{__('notes.delete')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h6 class="fs-15 mb-0 text-truncate task-title"><a
                                    href="{{ route('notes.noteDetails', $note->uuid) }}" class="d-block" style="min-height: 34px;">{{ $note->title }}</a>
                            </h6>
                                <p class="text-muted">{{ $note->description }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">

                                        @if ($note->tags && $note->tags->count() > 0)
                                            @foreach ($note->tags as $tag)
                                                <span
                                                    class="badge bg-primary-subtle text-primary">{{ $tag->name }}</span>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <!--end card-body-->
                            <div class="card-footer border-top-dashed">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span class="text-muted"><i class="ri-time-line align-bottom"></i>
                                            {{ $note->due_date ? $note->due_date->format('d-m-Y') : '' }}</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $progress = $note->progress;
                                                if ($progress < 30) {
                                                    $progressColor = 'bg-danger';
                                                } elseif ($progress < 80) {
                                                    $progressColor = 'bg-warning';
                                                } else {
                                                    $progressColor = 'bg-success';
                                                }
                                            @endphp
                                            <div class="progress"
                                                style="width: 100px; height: 8px; background-color: #f1f1f1;">
                                                <div class="progress-bar {{ $progressColor }}" role="progressbar"
                                                    style="width: {{ $progress }}%;"
                                                    aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <span class="text-muted small">{{ $progress }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    @endforeach
                    <!--end card-->
                </div>
            </div>
            <div class="my-3">
                <button class="btn btn-soft-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#private-creatertaskModal" data-board-id="{{ $board->id }}">{{__('notes.add_more')}}</button>
            </div>
        </div>
    @endforeach
</div>
<!--end tasks-list-->
</div>
<!--end task-board-->


<!--add board modal-->
<div class="modal fade" id="private-createboardModal" tabindex="-1" aria-labelledby="private-createboardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="private-createboardModalLabel">{{__('notes.add_board')}}</h5>
                <button type="button" class="btn-close" id="private-addBoardBtn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.storePrivateBoard') }}" id="private-createboardForm" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="boardName" class="form-label">Board Name</label>
                            <input type="text" class="form-control" id="private-boardName" name="name"
                                placeholder="{{__('notes.enter_board_name')}}">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.close')}}</button>
                                <button type="submit" class="btn btn-primary" id="private-addNewBoard">{{__('notes.add_board')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end add board modal-->

<!--edit board modal-->
<div class="modal fade" id="private-editBoardModal" tabindex="-1" aria-labelledby="private-editBoardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-warning-subtle">
                <h5 class="modal-title" id="private-editBoardModalLabel">{{__('notes.edit_board')}}</h5>
                <button type="button" class="btn-close" id="private-editBoardBtn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="private-editBoardForm" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="private-edit-board-id" name="board_id" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="editBoardName" class="form-label">Board Adı</label>
                            <input type="text" class="form-control" id="private-editBoardName" name="name"
                                placeholder="{{__('notes.enter_board_name')}}">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.cancel')}}</button>
                                <button type="submit" class="btn btn-warning" id="private-updateBoard">{{__('notes.update_board')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end edit board modal-->

<!--delete board modal-->
<div class="modal fade zoomIn" id="private-deleteBoardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="private-delete-board-btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>{{__('notes.are_you_sure')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.delete_board_text')}}</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">{{__('notes.cancel')}}</button>
                    <button type="button" class="btn w-sm btn-danger" id="private-delete-board-confirm">{{__('notes.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end delete board modal-->

<div class="modal fade" id="private-creatertaskModal" tabindex="-1" aria-labelledby="private-creatertaskModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="private-creatertaskModalLabel">{{ __('notes.add_note') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.storePrivateTask') }}" id="private-creatertaskForm" method="post">
                    @csrf
                    <input type="hidden" id="private-board-id" name="board_id" value="">
                    <input type="hidden" id="private-user-id" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="projectName" class="form-label">{{__('notes.project_name')}}</label>
                            <input type="text" class="form-control" id="private-projectName" name="title"
                                placeholder="{{__('notes.enter_project_name')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="task-description" class="form-label">{{__('notes.note_description')}}</label>
                            <textarea class="form-control" id="private-task-description" name="description" rows="3"
                                placeholder="{{__('notes.enter_note_description')}}"></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="due-date" class="form-label">{{__('notes.due_date')}}</label>
                            <input type="text" class="form-control" id="private-due-date" name="due_date"
                                format="Y-m-d" data-provider="flatpickr" placeholder="{{__('notes.select_date')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="tags" class="form-label">{{__('notes.tags')}}</label>
                            <select class="form-select" id="private-tags" name="tags[]" multiple data-choices
                                data-choices-removeItem>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="tasks-progress" class="form-label">{{__('notes.progress')}}</label>
                            <div class="progress-input-wrapper">
                                <input type="range" class="form-range" id="private-tasks-progress" min="0"
                                    max="100" value="0" step="5" name="progress">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="progress-value" id="private-progress-value">0%</span>
                                    <div class="progress" style="width: 60%; height: 8px;">
                                        <div class="progress-bar" id="private-progress-bar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.close')}}</button>
                                <button type="submit" id="private-addNewTask" class="btn btn-primary">{{__('notes.add_note')}}</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
<!--end add board modal-->

<!--edit note modal-->
<div class="modal fade" id="private-editNoteModal" tabindex="-1" aria-labelledby="private-editNoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-warning-subtle">
                <h5 class="modal-title" id="private-editNoteModalLabel">{{__('notes.edit_note')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="private-editNoteForm" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="private-edit-note-id" name="note_id" value="">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="editProjectName" class="form-label">{{__('notes.project_name')}}</label>
                            <input type="text" class="form-control" id="private-editProjectName" name="title"
                                placeholder="{{__('notes.enter_project_name')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="edit-task-description" class="form-label">{{__('notes.note_description')}}</label>
                            <textarea class="form-control" id="private-edit-task-description" name="description" rows="3"
                                placeholder="{{__('notes.enter_note_description')}}"></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="edit-due-date" class="form-label">{{__('notes.due_date')}}</label>
                            <input type="text" class="form-control" id="private-edit-due-date" name="due_date"
                                format="Y-m-d" data-provider="flatpickr" placeholder="{{__('notes.select_date')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="edit-tags" class="form-label">{{__('notes.tags')}}</label>
                            <select class="form-select" id="private-edit-tags" name="tags[]" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="edit-tasks-progress" class="form-label">{{__('notes.progress')}}</label>
                            <div class="progress-input-wrapper">
                                <input type="range" class="form-range" id="private-edit-tasks-progress"
                                    min="0" max="100" value="0" step="5" name="progress">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="progress-value" id="private-edit-progress-value">0%</span>
                                    <div class="progress" style="width: 60%; height: 8px;">
                                        <div class="progress-bar" id="private-edit-progress-bar" style="width: 0%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.cancel')}}</button>
                                <button type="submit" id="private-updateNote" class="btn btn-warning">{{__('notes.update_note')}}</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
<!--end edit note modal-->

<!--delete note modal-->
<div class="modal fade zoomIn" id="private-deleteNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="private-delete-note-btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>{{__('notes.are_you_sure')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.are_you_sure_text')}}</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">{{__('notes.cancel')}}</button>
                    <button type="button" class="btn w-sm btn-danger" id="private-delete-note-confirm">{{__('notes.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end delete note modal-->

<div class="modal fade zoomIn" id="private-deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="private-delete-btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>{{__('notes.are_you_sure')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.are_you_sure_text')}}</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">{{__('notes.close')}}</button>
                    <button type="button" class="btn w-sm btn-danger" id="private-delete-record">{{__('notes.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end modal -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.js"></script>
<script>
    const csrfToken = "{{ csrf_token() }}";
    let privateCreateChoices = null;
    let privateEditChoices = null;
    let privateEditPendingTagValues = [];

    $(document).ready(function() {
        // Choices.js'i etiketler için başlat
        try {
            if (window.Choices && document.querySelector('#private-tags')) {
                privateCreateChoices = new Choices('#private-tags', {
                    removeItemButton: true,
                    searchEnabled: true,
                });
            }

            // DİKKAT: Edit modalındaki select için Choices'i burada başlatmıyoruz.
            // Seçimler uygulandıktan sonra, modal 'shown' olduğunda başlatacağız.
        } catch (e) {
            console.error("Choices.js initialization failed:", e);
        }

        $('#private-creatertaskModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var boardId = button.data('board-id');
            var modal = $(this);
            modal.find('#private-board-id').val(boardId);
        });

        // Board ekleme form submit
        $('#private-createboardForm').on('submit', function(e) {
            e.preventDefault();
            privateAddNewBoard();
        });

        // Task ekleme form submit  
        $('#private-creatertaskForm').on('submit', function(e) {
            e.preventDefault();
            var boardId = $('#private-board-id').val();
            privateAddNewTask(boardId);
        });

        // Board düzenleme modal açılırken veri doldurma
        $('#private-editBoardModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var boardId = button.data('board-id');
            var boardName = button.data('board-name');
            var modal = $(this);
            modal.find('#private-edit-board-id').val(boardId);
            modal.find('#private-editBoardName').val(boardName);
        });

        // Board düzenleme form submit
        $('#private-editBoardForm').on('submit', function(e) {
            e.preventDefault();
            privateUpdateBoard();
        });

        // Board silme modal açılırken veri doldurma
        $('#private-deleteBoardModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var boardId = button.data('board-id');
            $('#private-delete-board-confirm').data('board-id', boardId);
        });

        // Board silme onayı
        $('#private-delete-board-confirm').on('click', function() {
            var boardId = $(this).data('board-id');
            privateDeleteBoard(boardId);
        });


        // Note silme modal açılırken veri doldurma
        $('#private-deleteNoteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var noteId = button.data('note-id');
            $('#private-delete-note-confirm').data('note-id', noteId);
        });

        // Note silme onayı
        $('#private-delete-note-confirm').on('click', function() {
            var noteId = $(this).data('note-id');
            privateDeleteNote(noteId);
        });

        // Progress range slider için event
        $('#private-edit-tasks-progress').on('input', function() {
            var value = $(this).val();
            $('#private-edit-progress-value').text(value + '%');
            $('#private-edit-progress-bar').css('width', value + '%');
        });

        // Note düzenleme modal açıldığında verileri AJAX ile çekme
        $('#private-editNoteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var noteId = button.data('note-id');
            var modal = $(this);

            // Formun action URL'ini ve not ID'sini güncelle
            var updateUrl = "{{ url('notes') }}/" + noteId;
            modal.find('#private-editNoteForm').attr('action', updateUrl);
            modal.find('#private-edit-note-id').val(noteId);

            // Not verilerini çekmek için fetch isteği
            var editUrl = "{{ url('notes') }}/" + noteId + "/edit";
            fetch(editUrl, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json",
                    },
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('{{__('notes.error')}}');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('private-editProjectName').value = data.title || '';
                    document.getElementById('private-edit-task-description').value = data.description || '';

                    let dueDateValue = '';
                    if (data.due_date) {
                        dueDateValue = new Date(data.due_date).toISOString().split('T')[0];
                    }
                    document.getElementById('private-edit-due-date').value = dueDateValue;

                    const progressValue = data.progress || 0;
                    document.getElementById('private-edit-tasks-progress').value = progressValue;
                    $('#private-edit-progress-value').text(progressValue + '%');
                    $('#private-edit-progress-bar').css('width', progressValue + '%');

                    // // Tag'ları seçili yap
                    // if (privateEditChoices && data.tags) {
                    //     // Önce mevcut seçimleri temizle
                    //     privateEditChoices.removeActiveItems();
                        
                    //     // Eğer tag'lar varsa onları tek tek seçili yap
                    //     if (Array.isArray(data.tags) && data.tags.length > 0) {
                    //         const tagIds = data.tags.map(tag => tag.id.toString());
                    //         tagIds.forEach(tagId => {
                    //             privateEditChoices.setChoiceByValue(tagId);
                    //         });
                    //     }
                    // }


                    // Tag değerlerini sakla; seçim 'shown' eventinde uygulanacak
                    privateEditPendingTagValues = (Array.isArray(data.tags) ? data.tags : []).map(t => String(t.id));
                    
                    console.log(data);
                    console.log(data.tags);
                })
                .catch(error => {
                    console.error("Error fetching or processing note data:", error);
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('notes.error')}}',
                        text: '{{__('notes.error_text')}}',
                    });
                });
        });

        // Modal tam açıldığında (DOM görünürken) tag seçimlerini uygula
        $('#private-editNoteModal').on('shown.bs.modal', function() {
            const selectElement = document.getElementById('private-edit-tags');
            if (!selectElement) return;

            const values = Array.isArray(privateEditPendingTagValues) ? privateEditPendingTagValues : [];

            // Eğer daha önce init edildiyse temizle
            if (privateEditChoices && typeof privateEditChoices.destroy === 'function') {
                try { privateEditChoices.destroy(); } catch (_) {}
                privateEditChoices = null;
            }

            // Native select'i güncelle
            Array.from(selectElement.options).forEach(option => {
                option.selected = values.includes(option.value);
            });

            // Şimdi Choices'i yeniden başlat ve değerleri ver
            privateEditChoices = new Choices('#private-edit-tags', {
                removeItemButton: true,
                searchEnabled: true,
            });
            if (values.length) {
                try {
                    privateEditChoices.setValueByChoice(values);
                } catch (e) {
                    console.warn('setValueByChoice on init failed', e);
                }
            }

            // Bir sonraki açılış için temizle
            // privateEditPendingTagValues = [];
        });

        // Not güncelleme formu gönderildiğinde
        $('#private-editNoteForm').on('submit', function(e) {
            e.preventDefault();

            const url = $(this).attr('action');
            const formData = new FormData(this);
            const payload = Object.fromEntries(formData.entries());

            if (privateEditChoices) {
                payload.tags = privateEditChoices.getValue(true);
            }

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload)
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{__('notes.success')}}',
                        text: '{{__('notes.note_updated')}}',
                    }).then(() => {
                        $('#private-editNoteModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('notes.error')}}',
                        text: data.message || '{{__('notes.error_text')}}',
                    });
                }
            }).catch(error => {
                console.error('Error updating note:', error);
                Swal.fire({
                    icon: 'error',
                    title: '{{__('notes.error')}}',
                    text: '{{__('notes.error_text')}}',
                });
            });
        });
    });


    async function privateAddNewBoard() {
        try {
            const response = await fetch("{{ route('notes.storePrivateBoard') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    name: $("#private-boardName").val(),
                }),
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.board_created')}}</h4>
                            <p class="text-muted mx-4 mb-0">{{__('notes.board_created_text')}}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(() => {
                    $('#private-createboardModal').modal('hide');
                    $('#private-createboardForm')[0].reset();
                    location.reload();
                });
            } else {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.error')}}</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || '{{__('notes.error_text')}}'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                });
            }
        } catch (error) {
            Swal.fire({
                html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15">
                        <h4>{{__('notes.error')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.error_text')}}</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "{{__('notes.ok')}}",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }

    async function privateAddNewTask(boardId) {
        try {
            const payload = {
                board_id: boardId,
                user_id: $("#private-user-id").val(),
                title: $("#private-projectName").val(),
                description: $("#private-task-description").val(),
                due_date: $("#private-due-date").val(),
                tags: $("#private-tags").val(), // array
                progress: $("#private-tasks-progress").val(),
            };

            const response = await fetch("{{ route('notes.storePrivateTask') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.task_created')}}</h4>
                            <p class="text-muted mx-4 mb-0">{{__('notes.task_created_text')}}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(() => {
                    $('#private-creatertaskModal').modal('hide');
                    $('#private-creatertaskForm')[0].reset();
                    location.reload();
                });
            } else {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.error')}}</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || '{{__('notes.error_text')}}'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                });
            }
        } catch (error) {
            Swal.fire({
                html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15">
                        <h4>{{__('notes.error')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.error_text')}}</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "{{__('notes.ok')}}",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }

    // Board güncelleme fonksiyonu
    async function privateUpdateBoard() {
        try {
            const boardId = $("#private-edit-board-id").val();
            const response = await fetch("{{ route('notes.updatePrivateBoard', ':id') }}".replace(':id',
                boardId), {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    name: $("#private-editBoardName").val(),
                }),
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.board_updated')}}</h4>
                            <p class="text-muted mx-4 mb-0">{{__('notes.board_updated_text')}}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(() => {
                    $('#private-editBoardModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.error')}}</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || '{{__('notes.error_text')}}'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                });
            }
        } catch (error) {
            Swal.fire({
                html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15">
                        <h4>{{__('notes.error')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.error_text')}}</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "{{__('notes.ok')}}",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }

    // Board silme fonksiyonu
    async function privateDeleteBoard(boardId) {
        try {
            const response = await fetch("{{ route('notes.deleteBoard', ':id') }}".replace(':id', boardId), {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.board_deleted')}}</h4>
                            <p class="text-muted mx-4 mb-0">{{__('notes.board_deleted_text')}}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(() => {
                    $('#private-deleteBoardModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>{{__('notes.error')}}</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || '{{__('notes.error_text')}}'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "{{__('notes.ok')}}",
                    buttonsStyling: false,
                    showCloseButton: true
                });
            }
        } catch (error) {
            Swal.fire({
                html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15">
                        <h4>{{__('notes.error')}}</h4>
                        <p class="text-muted mx-4 mb-0">{{__('notes.error_text')}}</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "{{__('notes.ok')}}",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }
</script>