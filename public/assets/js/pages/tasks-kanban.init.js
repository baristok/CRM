/*
Template Name: Phoenix - Admin Dashboard Template
Author: Pixelstrap
File Description: Kanban Task Board with SortableJS
*/

// Global variables
var myModalEl, kanbanboard, addNewBoard, addMember, profileField, reader;
var sortableInstances = [];
var task_lists = ['unassigned-task', 'todo-task', 'inprogress-task', 'reviews-task', 'completed-task', 'new-task'];

// Initialize function
function initializeKanban() {
    // Create sortable instances for each task list
    task_lists.forEach(function(listId) {
        var element = document.getElementById(listId);
        if (element) {
            var sortable = Sortable.create(element, {
                group: 'kanban',
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
                    updateTaskCounters();
                    removeNoTaskImage();
                },
                onUpdate: function(evt) {
                    updateTaskCounters();
                },
                onRemove: function(evt) {
                    updateTaskCounters();
                    removeNoTaskImage();
                },
                onEnd: function(evt) {
                    removeNoTaskImage();
                    updateTaskCounters();
                }
            });
            sortableInstances.push(sortable);
        }
    });

    removeNoTaskImage();
    updateTaskCounters();
}

// Remove "no task" styling when tasks are present
function removeNoTaskImage() {
    task_lists.forEach(function(listId) {
        var container = document.getElementById(listId);
        if (container) {
            var tasksCount = container.querySelectorAll('.tasks-box').length;
            if (tasksCount > 0) {
                container.classList.remove('noTask');
            } else {
                container.classList.add('noTask');
            }
        }
    });
}

// Update task counters in badges
function updateTaskCounters() {
    var taskLists = document.querySelectorAll('.tasks-list');
    taskLists.forEach(function(taskList) {
        var tasksContainer = taskList.querySelector('.tasks');
        var badge = taskList.querySelector('.totaltask-badge');
        if (tasksContainer && badge) {
            var taskCount = tasksContainer.querySelectorAll('.tasks-box').length;
            badge.textContent = taskCount;
        }
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('kanbanboard')) {
        initializeKanban();
    }
    
    // Delete task modal functionality
    myModalEl = document.getElementById('deleteRecordModal');
    if (myModalEl) {
        myModalEl.addEventListener('show.bs.modal', function(event) {
            var deleteBtn = document.getElementById('delete-record');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    var triggerElement = event.relatedTarget;
                    if (triggerElement) {
                        var taskBox = triggerElement.closest('.tasks-box');
                        if (taskBox) {
                            taskBox.remove();
                            updateTaskCounters();
                            removeNoTaskImage();
                        }
                    }
                    document.getElementById('delete-btn-close').click();
                });
            }
        });
    }
});