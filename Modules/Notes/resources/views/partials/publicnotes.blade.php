<div class="card">

    <div class="card-body">
        <div class="row g-2">
            @can('public-notes')
                <div class="col-lg-auto">
                    <div class="hstack gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#public-createboardModal"><i
                                class="ri-add-line align-bottom me-1"></i> {{__('notes.create_board')}}</button>
                    </div>
                </div>
            @endcan
            <!--end col-->
            <div class="col-lg-3 col-auto">
                <div class="search-box">
                    <input type="text" class="form-control search" id="public-search-task-options"
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

<div class="tasks-board mb-3" id="public-kanbanboard">
    @foreach ($publicBoards as $board)
        <div class="tasks-list" data-sortable-group="kanban" data-sortable-animation="150">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">{{ $board->name }} <small
                            class="badge bg-secondary align-bottom ms-1 totaltask-badge">{{ $board->notes->count() }}</small>
                    </h6>
                </div>
                @can('public-notes')
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
                                <a class="dropdown-item public-edit-board-btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#public-editBoardModal" data-board-id="{{ $board->id }}"
                                    data-board-name="{{ $board->name }}">{{__('notes.edit')}}</a>
                                <a class="dropdown-item public-delete-board-btn" href="#"
                                    data-board-id="{{ $board->id }}">{{__('notes.delete')}}</a>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="public-board-{{ $board->id }}" class="tasks" @can('public-notes') data-sortable="true" @endcan
                    data-board-id="{{ $board->id }}" ondragend="onDragEnd(event, {{ $board->id }})">
                    @foreach ($board->notes as $note)
                        <div class="card tasks-box" data-note-id="{{ $note->id }}" data-position="{{ $note->position }}">
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    @php
                                        $customHash = strtoupper(substr(md5($note->id . $note->created_at . $note->title), 0, 8));
                                    @endphp
                                    <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#{{ $customHash }}</a>
                                    
                                    
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="text-muted" id="public-dropdownMenuLink3"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="ri-more-fill"></i></a>
                                        <ul class="dropdown-menu" aria-labelledby="public-dropdownMenuLink3">
                                            <li><a class="dropdown-item" href="{{ route('notes.noteDetails', $note->uuid) }}"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i> {{__('notes.view')}}</a>
                                            </li>
                                            @can('public-notes')
                                                <li><a class="dropdown-item edit-note-btn" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#public-editNoteModal"
                                                        data-note-id="{{ $note->id }}"><i
                                                            class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                        {{__('notes.edit')}}</a></li>
                                                <li><a class="dropdown-item delete-note-btn" data-bs-toggle="modal"
                                                        data-bs-target="#public-deleteNoteModal"
                                                        data-note-id="{{ $note->id }}"><i
                                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                        {{__('notes.delete')}}</a></li>
                                            @endcan
                                        </ul>
                                    </div>
                                </div>
                                <h6 class="fs-15 mb-0 text-truncate task-title"><a
                                    href="{{ route('notes.noteDetails', $note->uuid) }}" class="d-block" style="min-height: 34px;">{{ $note->title }}</a>
                            </h6>
                                <p class="text-muted">{{ Str::limit($note->description, 50) }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        @foreach ($note->tags as $tag)
                                            <span
                                                class="badge bg-primary-subtle text-primary">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                            <div class="card-footer border-top-dashed">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span class="text-muted"><i class="ri-time-line align-bottom"></i>
                                            {{ $note->due_date ? $note->due_date->format('d M Y') : '' }}</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $progress = $note->progress;
                                                if ($progress < 30) {
                                                    $progressColor = 'bg-danger';
                                                } elseif ($progress < 70) {
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
                </div>
            </div>
            <div class="my-3">
                @can('public-notes')
                    <button class="btn btn-soft-primary w-100" data-bs-toggle="modal"
                        data-bs-target="#public-creatertaskModal" data-board-id="{{ $board->id }}">{{__('notes.add_more')}}</button>
                @endcan
            </div>
        </div>
    @endforeach
</div>
<!--end tasks-list-->
</div>
<!--end task-board-->


<div class="modal fade" id="public-createboardModal" tabindex="-1" aria-labelledby="public-createboardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="public-createboardModalLabel">{{__('notes.add_board')}}</h5>
                <button type="button" class="btn-close" id="public-addBoardBtn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.storePublicBoard') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="boardName" class="form-label">{{__('notes.board_name')}}</label>
                            <input type="text" class="form-control" name="name" id="public-boardName"
                                placeholder="{{__('notes.enter_board_name')}}">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.close')}}</button>
                                <button type="submit" class="btn btn-primary" id="public-addNewBoard">{{__('notes.add_board')}}</button>
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
<div class="modal fade" id="public-editBoardModal" tabindex="-1" aria-labelledby="public-editBoardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-warning-subtle">
                <h5 class="modal-title" id="public-editBoardModalLabel">{{__('notes.edit_board')}}</h5>
                <button type="button" class="btn-close" id="public-editBoardBtn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="public-editBoardForm" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="public-edit-board-id" name="board_id" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="editBoardName" class="form-label">{{__('notes.board_name')}}</label>
                            <input type="text" class="form-control" id="public-editBoardName" name="name"
                                placeholder="{{__('notes.enter_board_name')}}">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.cancel')}}</button>
                                <button type="submit" class="btn btn-warning" id="public-updateBoard">{{__('notes.update_board')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end edit board modal-->

<!--edit note modal-->
<div class="modal fade" id="public-editNoteModal" tabindex="-1" aria-labelledby="public-editNoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-warning-subtle">
                <h5 class="modal-title" id="public-editNoteModalLabel">{{__('notes.edit_note')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="public-editNoteForm" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="public-edit-note-id" name="note_id" value="">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="editProjectName" class="form-label">{{__('notes.project_name')}}</label>
                            <input type="text" class="form-control" id="public-editProjectName" name="title"
                                placeholder="{{__('notes.enter_project_name')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="edit-task-description" class="form-label">{{__('notes.note_description')}}</label>
                            <textarea class="form-control" id="public-edit-task-description" name="description" rows="3"
                                placeholder="{{__('notes.enter_note_description')}}"></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="edit-due-date" class="form-label">{{__('notes.due_date')}}</label>
                            <input type="text" class="form-control" id="public-edit-due-date" name="due_date"
                                format="Y-m-d" data-provider="flatpickr" placeholder="{{__('notes.select_date')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="edit-tags" class="form-label">{{__('notes.tags')}}</label>
                            <select class="form-select" id="public-edit-tags" name="tags[]" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="edit-tasks-progress" class="form-label">{{__('notes.progress')}}</label>
                            <div class="progress-input-wrapper">
                                <input type="range" class="form-range" id="public-edit-tasks-progress"
                                    min="0" max="100" value="0" step="5" name="progress">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="progress-value" id="public-edit-progress-value">0%</span>
                                    <div class="progress" style="width: 60%; height: 8px;">
                                        <div class="progress-bar" id="public-edit-progress-bar" style="width: 0%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.cancel')}}</button>
                                <button type="submit" id="public-updateNote" class="btn btn-warning">{{__('notes.update_note')}}</button>
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


<div class="modal fade" id="public-creatertaskModal" tabindex="-1" aria-labelledby="public-creatertaskModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="public-creatertaskModalLabel">{{ __('notes.add_note') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.storePublicTask') }}" id="public-creatertaskForm" method="post">
                    @csrf
                    <input type="hidden" id="public-board-id" name="board_id" value="">
                    <input type="hidden" id="public-user-id" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="projectName" class="form-label">{{__('notes.project_name')}}</label>
                            <input type="text" class="form-control" id="public-projectName" name="title"
                                placeholder="{{__('notes.enter_project_name')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="task-description" class="form-label">{{__('notes.note_description')}}</label>
                            <textarea class="form-control" id="public-task-description" name="description" rows="3"
                                placeholder="{{__('notes.enter_note_description')}}"></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="due-date" class="form-label">{{__('notes.due_date')}}</label>
                            <input type="text" class="form-control" id="public-due-date" name="due_date"
                                format="Y-m-d" data-provider="flatpickr" placeholder="{{__('notes.select_date')}}">
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="tags" class="form-label">{{__('notes.tags')}}</label>
                            <select class="form-select" id="public-tags" name="tags[]" multiple data-choices
                                data-choices-removeItem>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="public-tasks-progress" class="form-label">{{__('notes.progress')}}</label>
                            <div class="progress-input-wrapper">
                                <input type="range" class="form-range" id="public-tasks-progress" min="0"
                                    max="100" value="0" step="5" name="progress">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="progress-value" id="public-progress-value">0%</span>
                                    <div class="progress" style="width: 60%; height: 8px;">
                                        <div class="progress-bar" id="public-progress-bar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('notes.close')}}</button>
                                <button type="submit" id="public-addNewTask" class="btn btn-primary">{{__('notes.add_note')}}</button>
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


<!--delete note modal-->
<div class="modal fade zoomIn" id="public-deleteNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('notes.deletePublicNote', ['id' => ':id']) }}" id="public-deleteNoteForm" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" id="public-delete-note-id" name="note_id" value="">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="public-delete-note-btn-close"></button>
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
                        <button type="submit" class="btn w-sm btn-danger" id="public-delete-note-confirm">{{__('notes.delete')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end delete note modal-->


<div class="modal fade zoomIn" id="public-deleteBoardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="public-delete-btn-close"></button>
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
                    <button type="button" class="btn w-sm btn-danger" id="public-delete-board-confirm">{{__('notes.delete')}}</button>
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
    let publicCreateChoices = null;
    let publicEditChoices = null;
    let publicEditPendingTagValues = [];
    $(document).ready(function() {
        try {
            if (window.Choices && document.querySelector('#public-tags')) {
                publicCreateChoices = new Choices('#public-tags', {
                    removeItemButton: true,
                    searchEnabled: true,
                });
            }
        } catch (e) {
            console.error("Choices.js initialization for create form failed:", e);
        }
        // Progress range slider için event
        $('#public-tasks-progress').on('input', function() {
            var value = $(this).val();
            $('#public-progress-value').text(value + '%');
            $('#public-progress-bar').css('width', value + '%');
        });
        // Progress range slider için event
        $('#public-edit-tasks-progress').on('input', function() {
            var value = $(this).val();
            $('#public-edit-progress-value').text(value + '%');
            $('#public-edit-progress-bar').css('width', value + '%');
        });
        $('.public-edit-board-btn').click(function() {
            var boardId = $(this).data('board-id');
            var boardName = $(this).data('board-name');
            var modal = $('#public-editBoardModal');

            // Formun action URL'ini dinamik olarak ayarla
            var urlTemplate = "{{ route('notes.updatePublicBoard', ['id' => ':id']) }}";
            var newUrl = urlTemplate.replace(':id', boardId);
            modal.find('#public-editBoardForm').attr('action', newUrl);

            modal.find('#public-edit-board-id').val(boardId);
            modal.find('#public-editBoardName').val(boardName);
        });


        // Task modal create
        $('#public-creatertaskModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var boardId = button.data('board-id');
            var modal = $(this);
            modal.find('#public-board-id').val(boardId);
        });

        // Public progress slider functionality
        $('#public-tasks-progress').on('input', function() {
            const value = $(this).val();
            const progressBar = $('#public-progress-bar');
            $('#public-progress-value').text(value + '%');
            progressBar.css('width', value + '%');

            // Progress bar renk değişimi
            progressBar.removeClass('bg-danger bg-warning bg-success');
            if (value < 30) {
                progressBar.addClass('bg-danger');
            } else if (value < 80) {
                progressBar.addClass('bg-warning');
            } else {
                progressBar.addClass('bg-success');
            }
        });

        //edit modalın açılması ve verilerin doldurulması
        $('#public-editNoteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var noteId = button.data('note-id');
            var modal = $(this);
            var updateUrl = "{{ url('notes/') }}/" + noteId;
            modal.find('#public-editNoteForm').attr('action', updateUrl);
            modal.find('#public-edit-note-id').val(noteId);
            var editUrl = "{{ url('notes/') }}/" + noteId + "/edit";
            fetch(editUrl, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    },
                }).then(response => {
                    return response.json();
                }).then(data => {
                    $('#public-editProjectName').val(data.title);
                    $('#public-edit-task-description').val(data.description);
                    let dueDateValue = '';
                    if (data.due_date) {
                        dueDateValue = new Date(data.due_date).toISOString().split('T')[0];
                    }
                    document.getElementById('public-edit-due-date').value = dueDateValue;
                    const progressValue = data.progress || 0;
                    document.getElementById('public-edit-tasks-progress').value = progressValue;
                    $('#public-edit-progress-value').text(progressValue + '%');
                    $('#public-edit-progress-bar').css('width', progressValue + '%');
                    publicEditPendingTagValues = (Array.isArray(data.tags) ? data.tags : []).map(
                        t => String(t.id));
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
        $('#public-editNoteModal').on('shown.bs.modal', function() {
            const selectElement = document.getElementById('public-edit-tags');
            if (!selectElement) return;

            const values = Array.isArray(publicEditPendingTagValues) ? publicEditPendingTagValues : [];

            // Eğer daha önce init edildiyse temizle
            if (publicEditChoices && typeof publicEditChoices.destroy === 'function') {
                try {
                    publicEditChoices.destroy();
                } catch (_) {}
                publicEditChoices = null;
            }

            // Native select'i güncelle
            Array.from(selectElement.options).forEach(option => {
                option.selected = values.includes(option.value);
            });

            // Şimdi Choices'i yeniden başlat ve değerleri ver
            publicEditChoices = new Choices('#public-edit-tags', {
                removeItemButton: true,
                searchEnabled: true,
            });
            if (values.length) {
                try {
                    publicEditChoices.setValueByChoice(values);
                } catch (e) {
                    console.warn('setValueByChoice on init failed', e);
                }
            }

            // Bir sonraki açılış için temizle
            // privateEditPendingTagValues = [];
        });


        // Not güncelleme formu gönderildiğinde
        $('#public-editNoteForm').on('submit', function(e) {
            e.preventDefault();

            const url = $(this).attr('action');
            const formData = new FormData(this);
            const payload = Object.fromEntries(formData.entries());

            if (publicEditChoices) {
                payload.tags = publicEditChoices.getValue(true);
            }

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload)
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{__('notes.success')}}',
                        text: '{{__('notes.note_updated')}}',
                    }).then(() => {
                        $('#public-editNoteModal').modal('hide');
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

        // $('#public-deleteNoteModal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var noteId = button.data('note-id');
        //     var modal = $(this);
        //     modal.find('#public-delete-note-id').val(noteId);
        // });

        // $('#public-deleteNoteForm').on('submit', function(e) {
        //     e.preventDefault();
        //     const url = $(this).attr('action');
        //     const formData = new FormData(this);
        //     const payload = Object.fromEntries(formData.entries());
        //     fetch(url, {
        //         method: 'DELETE',
        //         headers: {
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //             'Accept': 'application/json'
        //         }
        //     });
        //     .then(response => {
        //         return response.json();
        //     }).then(data => {
        //         if (data.success) {
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Başarılı!',
        //                 text: 'Not başarıyla silindi.',
        //             }).then(() => {
        //                 $('#public-deleteNoteModal').modal('hide');
        //                 location.reload();
        //             });
        //         } else {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Hata!',
        //                 text: data.message || 'Not silinemedi.',
        //             });
        //         }
        //     });
        // });


        $('#public-deleteNoteModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var noteId = button.data('note-id');
    var modal = $(this);
    modal.find('#public-delete-note-id').val(noteId);
    
    // Form action'ını güncelle
    var form = modal.find('#public-deleteNoteForm');
    var actionUrl = form.attr('action').replace(':id', noteId);
    form.attr('action', actionUrl);
});

$('#public-deleteNoteForm').on('submit', function(e) {
    e.preventDefault();
    const url = $(this).attr('action');
    const formData = new FormData(this);
    
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        return response.json();
    }).then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '{{__('notes.success')}}',
                text: '{{__('notes.note_deleted')}}',
            }).then(() => {
                $('#public-deleteNoteModal').modal('hide');
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: '{{__('notes.error')}}',
                text: data.message || '{{__('notes.error_text')}}',
            });
        }
    });
});


        $('.public-delete-board-btn').on('click', function(event) {
            event.preventDefault();
            var boardId = $(this).data('board-id');

            Swal.fire({
                html: `
            <div class="mt-3">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-5">
                    <h4>{{__('notes.delete_board')}}</h4>
                    <p class="text-muted mx-4 mb-0">{{__('notes.delete_board_text')}}</p>
                </div>
            </div>`,
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mb-1",
                    cancelButton: "btn btn-danger w-xs mb-1",
                },
                cancelButtonText: "{{__('notes.no')}}",
                confirmButtonText: "{{__('notes.delete')}}",
                buttonsStyling: false,
                showCloseButton: true
            }).then((result) => {
                if (!result.isConfirmed) return;

                const destroyUrlTemplate =
                    "{{ route('notes.deletePublicBoard', ['id' => ':id']) }}";
                const url = destroyUrlTemplate.replace(':id', boardId);

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (response.ok && data.success) {
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
                                cancelButtonText: "{{__('notes.ok')}}",
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                buttonsStyling: false,
                                showCloseButton: true
                            }).then(() => window.location.reload());
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
                                cancelButtonText: "{{__('notes.close')}}",
                                customClass: {
                                    cancelButton: "btn btn-primary w-xs mb-1"
                                },
                                buttonsStyling: false,
                                showCloseButton: true
                            });
                        }
                    })
                    .catch(() => {
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
                            cancelButtonText: "{{__('notes.close')}}",
                            customClass: {
                                cancelButton: "btn btn-primary w-xs mb-1"
                            },
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                    });
            });
        });




        

    });
    async function onDragEnd(event, boardId) {
    const noteId = event.target.dataset.noteId;
    const notePosition = event.target.dataset.position;
    // console.log(notePosition);
    
    // console.log('Taşınan not:', noteId, 'Yeni board:', boardId, 'Position:', notePosition);
    
    try {
        const response = await fetch("{{ route('notes.updateNotePosition') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json",
            },
            body: JSON.stringify({
                note_id: noteId,
                board_id: boardId,
                position: notePosition
            }),
        });

        const data = await response.json();

        if (data.success) {
            // Başarılı olduğunda toast notification göster
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{__('notes.note_moved')}}',
                showConfirmButton: false,
                timer: 2000
            });
            
            // Sayfayı yenile (isteğe bağlı)
            // location.reload();
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        
    }

}
    
</script>
