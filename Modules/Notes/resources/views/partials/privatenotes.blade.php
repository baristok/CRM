<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-lg-auto">
                <div class="hstack gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#private-createboardModal"><i
                            class="ri-add-line align-bottom me-1"></i> Create Board</button>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-3 col-auto">
                <div class="search-box">
                    <input type="text" class="form-control search" id="private-search-task-options"
                        placeholder="Search for project, tasks...">
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
                                data-board-name="{{ $board->name }}">Düzenle</a>
                            <a class="dropdown-item delete-board-btn" href="#" data-bs-toggle="modal"
                                data-bs-target="#private-deleteBoardModal" data-board-id="{{ $board->id }}"
                                data-board-name="{{ $board->name }}">Sil</a>
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
                                    <div class="flex-grow-1">
                                        <h6 class="fs-15 mb-0 text-truncate task-title"><a
                                                href="apps-tasks-details.html" class="d-block">{{ $note->title }}</a>
                                        </h6>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="text-muted" id="private-dropdownMenuLink3"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="ri-more-fill"></i></a>
                                        <ul class="dropdown-menu" aria-labelledby="private-dropdownMenuLink3">
                                            <li><a class="dropdown-item" href="apps-tasks-details.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>
                                            </li>
                                            <li><a class="dropdown-item edit-note-btn" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#private-editNoteModal"
                                                    data-note-id="{{ $note->id }}"
                                                    data-note-title="{{ $note->title }}"
                                                    data-note-description="{{ $note->description }}"
                                                    data-note-due-date="{{ $note->due_date }}"
                                                    data-note-tags='@json($note->tags)'
                                                    data-note-progress="{{ $note->progress }}"><i
                                                        class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                    Edit</a></li>
                                            <li><a class="dropdown-item delete-note-btn" data-bs-toggle="modal"
                                                    data-bs-target="#private-deleteNoteModal"
                                                    data-note-id="{{ $note->id }}"
                                                    data-note-title="{{ $note->title }}" href="#"><i
                                                        class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                    Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-muted">{{ $note->description }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        
                                        @if($note->tags && $note->tags->count() > 0)
                                            @foreach ($note->tags as $tag)
                                                <span class="badge bg-primary-subtle text-primary">{{ $tag->name }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Tonya">
                                                <img src="{{ asset('assets/images/users/avatar-10.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Frank">
                                                <img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Herbert">
                                                <img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                            <div class="card-footer border-top-dashed">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span class="text-muted"><i class="ri-time-line align-bottom"></i>
                                            {{ $note->due_date }}</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <ul class="link-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted"><i
                                                        class="ri-eye-line align-bottom"></i>
                                                    {{ $note->progress }}</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted"><i
                                                        class="ri-question-answer-line align-bottom"></i>
                                                    {{ $note->priority }}</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted"><i
                                                        class="ri-attachment-2 align-bottom"></i>
                                                    {{ $note->image }}</a>
                                            </li>
                                        </ul>
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
                    data-bs-target="#private-creatertaskModal" data-board-id="{{ $board->id }}">Add More</button>
            </div>
        </div>
    @endforeach
</div>
<!--end tasks-list-->
</div>
<!--end task-board-->

<div class="modal fade" id="private-addmemberModal" tabindex="-1" aria-labelledby="private-addmemberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="private-addmemberModalLabel">Add Member</h5>
                <button type="button" class="btn-close" id="private-btn-close-member" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="submissionidInput" class="form-label">Submission ID</label>
                            <input type="number" class="form-control" id="private-submissionidInput"
                                placeholder="Submission ID">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="profileimgInput" class="form-label">Profile Images</label>
                            <input class="form-control" type="file" id="private-profileimgInput">
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="firstnameInput" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="private-firstnameInput"
                                placeholder="Enter firstname">
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="lastnameInput" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="private-lastnameInput"
                                placeholder="Enter lastname">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="designationInput" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="private-designationInput"
                                placeholder="Designation">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="titleInput" class="form-label">Title</label>
                            <input type="text" class="form-control" id="private-titleInput" placeholder="Title">
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="numberInput" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="private-numberInput"
                                placeholder="Phone number">
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="joiningdateInput" class="form-label">Joining Date</label>
                            <input type="text" class="form-control" id="private-joiningdateInput"
                                data-provider="flatpickr" placeholder="Select date">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="emailInput" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="private-emailInput" placeholder="Email">
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i
                        class="ri-close-line align-bottom me-1"></i> Close</button>
                <button type="button" class="btn btn-primary" id="private-addMember">Add Member</button>
            </div>
        </div>
    </div>
</div>
<!--end add member modal-->

<!--add board modal-->
<div class="modal fade" id="private-createboardModal" tabindex="-1" aria-labelledby="private-createboardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="private-createboardModalLabel">Add Board</h5>
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
                                placeholder="Enter board name">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="private-addNewBoard">Add
                                    Board</button>
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
                <h5 class="modal-title" id="private-editBoardModalLabel">Board Düzenle</h5>
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
                                placeholder="Board adını girin">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                                <button type="submit" class="btn btn-warning" id="private-updateBoard">Board
                                    Güncelle</button>
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
                        <h4>Emin misiniz?</h4>
                        <p class="text-muted mx-4 mb-0">Bu board'u silmek istediğinizden emin misiniz? Bu işlem geri
                            alınamaz ve board içindeki tüm notlar da silinecektir.</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn w-sm btn-danger" id="private-delete-board-confirm">Evet,
                        Sil!</button>
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
                <h5 class="modal-title" id="private-creatertaskModalLabel">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.storePrivateTask') }}" id="private-creatertaskForm" method="post">
                    @csrf
                    <input type="hidden" id="private-board-id" name="board_id" value="">
                    <input type="hidden" id="private-user-id" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="projectName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="private-projectName" name="title"
                                placeholder="Enter project name">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="task-description" class="form-label">Task Description</label>
                            <textarea class="form-control" id="private-task-description" name="description" rows="3"
                                placeholder="Task description"></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="due-date" class="form-label">Due Date</label>
                            <input type="text" class="form-control" id="private-due-date" name="due_date"
                                format="Y-m-d" data-provider="flatpickr" placeholder="Select date">
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="tags" class="form-label">Tags</label>
                            <select class="form-select" id="private-tags" name="tags[]" multiple data-choices
                                data-choices-removeItem>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="tasks-progress" class="form-label">Tasks Progress</label>
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
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="private-addNewTask" class="btn btn-primary">Add
                                    Task</button>
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
                <h5 class="modal-title" id="private-editNoteModalLabel">Not Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="private-editNoteForm" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="private-edit-note-id" name="note_id" value="">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="editProjectName" class="form-label">Proje Adı</label>
                            <input type="text" class="form-control" id="private-editProjectName" name="title"
                                placeholder="Proje adını girin">
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="edit-task-description" class="form-label">Not Açıklaması</label>
                            <textarea class="form-control" id="private-edit-task-description" name="description" rows="3"
                                placeholder="Not açıklaması"></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="edit-due-date" class="form-label">Son Tarih</label>
                            <input type="text" class="form-control" id="private-edit-due-date" name="due_date"
                                format="Y-m-d" data-provider="flatpickr" placeholder="Tarih seçin">
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="edit-tags" class="form-label">Etiketler</label>
                            <select class="form-select" id="private-edit-tags" name="tags[]" multiple data-choices
                                data-choices-removeItem>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <label for="edit-tasks-progress" class="form-label">İlerleme</label>
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
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                                <button type="submit" id="private-updateNote" class="btn btn-warning">Not
                                    Güncelle</button>
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
                        <h4>Emin misiniz?</h4>
                        <p class="text-muted mx-4 mb-0">Bu notu silmek istediğinizden emin misiniz? Bu işlem geri
                            alınamaz.</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn w-sm btn-danger" id="private-delete-note-confirm">Evet,
                        Sil!</button>
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
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this tasks ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="private-delete-record">Yes, Delete
                        It!</button>
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

    $(document).ready(function() {
        // Initialize Choices.js for tags selects if available
        try {
            if (window.Choices && document.querySelector('#private-tags')) {
                privateCreateChoices = new Choices('#private-tags', {
                    removeItemButton: true,
                    searchEnabled: true,
                });
            }
        } catch (e) {
            /* no-op */ }
        try {
            if (window.Choices && document.querySelector('#private-edit-tags')) {
                privateEditChoices = new Choices('#private-edit-tags', {
                    removeItemButton: true,
                    searchEnabled: true,
                });
            }
        } catch (e) {
            /* no-op */ }
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

        // Note düzenleme modal açılırken veri doldurma
        $('#private-editNoteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var noteId = button.data('note-id');
            var noteTitle = button.data('note-title');
            var noteDescription = button.data('note-description');
            var noteDueDate = button.data('note-due-date');
            var noteTags = button.data('note-tags');
            var noteProgress = button.data('note-progress');

            var modal = $(this);
            modal.find('#private-edit-note-id').val(noteId);
            modal.find('#private-editProjectName').val(noteTitle);
            modal.find('#private-edit-task-description').val(noteDescription);
            modal.find('#private-edit-due-date').val(noteDueDate);
            modal.find('#private-edit-tasks-progress').val(noteProgress);
            modal.find('#private-edit-progress-value').text(noteProgress + '%');
            modal.find('#private-edit-progress-bar').css('width', noteProgress + '%');

            // Choices instance yoksa güvenli şekilde başlat
            if (!privateEditChoices && window.Choices) {
                try {
                    privateEditChoices = new Choices('#private-edit-tags', {
                        removeItemButton: true,
                        searchEnabled: true,
                    });
                } catch (e) {
                    /* no-op */ }
            }

            // Tags için güvenli doldurma (JSON veya virgüllü string destekli)
            var rawTags = noteTags;
            var tagsArray = [];
            if (Array.isArray(rawTags)) {
                tagsArray = rawTags;
            } else if (typeof rawTags === 'string' && rawTags.trim() !== '') {
                try {
                    if (rawTags.trim().startsWith('[')) {
                        tagsArray = JSON.parse(rawTags);
                    } else {
                        tagsArray = rawTags.split(',');
                    }
                } catch (e) {
                    tagsArray = rawTags.split(',');
                }
            }

            const normalized = tagsArray.map(function(tag) {
                return String(tag).trim().replace(/^\"|\"$/g, '');
            });

            if (privateEditChoices) {
                privateEditChoices.removeActiveItems();
                normalized.forEach(function(val) {
                    privateEditChoices.setChoiceByValue(val);
                });
            } else {
                modal.find('#private-edit-tags option').prop('selected', false);
                normalized.forEach(function(value) {
                    modal.find('#private-edit-tags option[value="' + value + '"]').prop(
                        'selected', true);
                });
                modal.find('#private-edit-tags').trigger('change');
            }
        });

        // Note düzenleme form submit
        $('#private-editNoteForm').on('submit', function(e) {
            e.preventDefault();
            privateUpdateNote();
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
                            <h4>Board Oluşturuldu!</h4>
                            <p class="text-muted mx-4 mb-0">Board başarıyla oluşturuldu.</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                            <h4>Hata!</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || 'Board oluşturulamadı'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                        <h4>Bağlantı Hatası!</h4>
                        <p class="text-muted mx-4 mb-0">Sunucuya bağlanırken bir hata oluştu.</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "Tamam",
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
                            <h4>Task Oluşturuldu!</h4>
                            <p class="text-muted mx-4 mb-0">Task başarıyla oluşturuldu.</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                            <h4>Hata!</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || 'Task oluşturulamadı'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                        <h4>Bağlantı Hatası!</h4>
                        <p class="text-muted mx-4 mb-0">Sunucuya bağlanırken bir hata oluştu.</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "Tamam",
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
                            <h4>Board Güncellendi!</h4>
                            <p class="text-muted mx-4 mb-0">Board başarıyla güncellendi.</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                            <h4>Hata!</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || 'Board güncellenemedi'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                        <h4>Bağlantı Hatası!</h4>
                        <p class="text-muted mx-4 mb-0">Sunucuya bağlanırken bir hata oluştu.</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "Tamam",
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
                            <h4>Board Silindi!</h4>
                            <p class="text-muted mx-4 mb-0">Board başarıyla silindi.</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                            <h4>Hata!</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || 'Board silinemedi'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                        <h4>Bağlantı Hatası!</h4>
                        <p class="text-muted mx-4 mb-0">Sunucuya bağlanırken bir hata oluştu.</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "Tamam",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }

    // Note güncelleme fonksiyonu
    async function privateUpdateNote() {
        try {
            const noteId = $('#private-edit-note-id').val();
            const response = await fetch("{{ route('notes.updateNote', ':id') }}".replace(':id', noteId), {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    title: $("#private-editProjectName").val(),
                    description: $("#private-edit-task-description").val(),
                    due_date: $("#private-edit-due-date").val(),
                    tags: $("#private-edit-tags").val(),
                    progress: $("#private-edit-tasks-progress").val()
                }),
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>Not Güncellendi!</h4>
                            <p class="text-muted mx-4 mb-0">Not başarıyla güncellendi.</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(() => {
                    $('#private-editNoteModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>Hata!</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || 'Not güncellenemedi'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                        <h4>Bağlantı Hatası!</h4>
                        <p class="text-muted mx-4 mb-0">Sunucuya bağlanırken bir hata oluştu.</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "Tamam",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }

    // Note silme fonksiyonu
    async function privateDeleteNote(noteId) {
        try {
            const response = await fetch("{{ route('notes.deleteNote', ':id') }}".replace(':id', noteId), {
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
                            <h4>Not Silindi!</h4>
                            <p class="text-muted mx-4 mb-0">Not başarıyla silindi.</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(() => {
                    $('#private-deleteNoteModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15">
                            <h4>Hata!</h4>
                            <p class="text-muted mx-4 mb-0">${data.message || 'Not silinemedi'}</p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1"
                    },
                    cancelButtonText: "Tamam",
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
                        <h4>Bağlantı Hatası!</h4>
                        <p class="text-muted mx-4 mb-0">Sunucuya bağlanırken bir hata oluştu.</p>
                    </div>
                </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                cancelButtonText: "Tamam",
                buttonsStyling: false,
                showCloseButton: true
            });
        }
    }
</script>
