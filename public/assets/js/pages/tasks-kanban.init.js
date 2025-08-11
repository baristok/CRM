/*
Template Name: Phoenix - Admin Dashboard Template
Author: Pixelstrap
File Description: Kanban Task Board with SortableJS
*/

// Global variables
var myModalEl, kanbanboard, addNewBoard, addMember, profileField, reader;
var sortableInstances = [];
var task_lists = ['unassigned-task', 'todo-task', 'inprogress-task', 'reviews-task', 'completed-task', 'new-task'];

// Dinamik task listesi oluşturma fonksiyonu
function getDynamicTaskLists(tabId) {
    var tabElement = document.getElementById(tabId);
    if (!tabElement) return task_lists; // Fallback to default
    
    var dynamicLists = [];
    var prefix = tabId === 'private-notes' ? 'private-' : 'public-';
    
    // Önce varsayılan listeleri kontrol et
    task_lists.forEach(function(listId) {
        var element = tabElement.querySelector('#' + prefix + listId);
        if (element) {
            dynamicLists.push(prefix + listId);
        }
    });
    
    // Ek olarak dinamik board'ları bul
    var allSortableElements = tabElement.querySelectorAll('[data-sortable="true"]');
    allSortableElements.forEach(function(element) {
        if (!dynamicLists.includes(element.id)) {
            dynamicLists.push(element.id);
        }
    });
    
    return dynamicLists;
}

// Initialize function - ESKİ VERSİYON - KULLANILMIYOR
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

// Tab'lar arasında geçiş yapılırken sürükleme işlemini yeniden başlat
document.addEventListener('DOMContentLoaded', function() {
    // Sayfa yüklendiğinde aktif olan tab'ı tespit et ve sadece o tab için başlat
    var activeTab = document.querySelector('#notesTab .nav-link.active');
    if (activeTab) {
        var targetTabId = activeTab.getAttribute('href').replace('#', '');
        if (targetTabId === 'public-notes') {
            initializeKanbanForTab('public-notes');
        } else if (targetTabId === 'private-notes') {
            initializeKanbanForTab('private-notes');
        }
    } else {
        // Eğer aktif tab bulunamazsa, private-notes'u varsayılan olarak başlat
        initializeKanbanForTab('private-notes');
    }
    
    // Tab değiştiğinde sürükleme işlemini yeniden başlat
    var tabLinks = document.querySelectorAll('#notesTab a[data-bs-toggle="tab"]');
    tabLinks.forEach(function(tab) {
        tab.addEventListener('shown.bs.tab', function(event) {
            var targetTabId = event.target.getAttribute('href').replace('#', '');
            if (targetTabId === 'public-notes') {
                initializeKanbanForTab('public-notes');
            } else if (targetTabId === 'private-notes') {
                initializeKanbanForTab('private-notes');
            }
        });
    });
});

function initializeKanbanForTab(tabId) {
    var tabElement = document.getElementById(tabId);
    if (!tabElement) return;
    
    var kanbanboardId = tabId === 'private-notes' ? '#private-kanbanboard' : '#public-kanbanboard';
    var kanbanboard = tabElement.querySelector(kanbanboardId);
    if (!kanbanboard) return;
    
    // Önceki sortable instanceları temizle
    if (window.currentSortableInstances) {
        window.currentSortableInstances.forEach(function(instance) {
            instance.destroy();
        });
    }
    window.currentSortableInstances = [];
    
    // Dinamik task listelerini al
    var dynamicTaskLists = getDynamicTaskLists(tabId);
    
    // Her task listesi için sortable oluştur
    dynamicTaskLists.forEach(function(listId) {
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
                onAdd: function(evt) {
                    updateTaskCountersForTab(tabId);
                    removeNoTaskImageForTab(tabId);
                },
                onUpdate: function(evt) {
                    updateTaskCountersForTab(tabId);
                },
                onRemove: function(evt) {
                    updateTaskCountersForTab(tabId);
                    removeNoTaskImageForTab(tabId);
                },
                onEnd: function(evt) {
                    updateTaskCountersForTab(tabId);
                    removeNoTaskImageForTab(tabId);
                }
            });
            window.currentSortableInstances.push(sortable);
        }
    });
    
    // İlk başlatmada da noTask kontrolü yap
    removeNoTaskImageForTab(tabId);
}

function updateTaskCountersForTab(tabId) {
    var tabElement = document.getElementById(tabId);
    if (!tabElement) return;
    
    var taskLists = tabElement.querySelectorAll('.tasks-list');
    taskLists.forEach(function(taskList) {
        var tasksContainer = taskList.querySelector('.tasks');
        var badge = taskList.querySelector('.totaltask-badge');
        if (tasksContainer && badge) {
            var taskCount = tasksContainer.querySelectorAll('.tasks-box').length;
            badge.textContent = taskCount;
        }
    });
}

// Tab-specific noTask image kontrolü
function removeNoTaskImageForTab(tabId) {
    var tabElement = document.getElementById(tabId);
    if (!tabElement) return;
    
    var kanbanboardId = tabId === 'private-notes' ? '#private-kanbanboard' : '#public-kanbanboard';
    var kanbanboard = tabElement.querySelector(kanbanboardId);
    if (!kanbanboard) return;
    
    // Dinamik task listelerini al
    var dynamicTaskLists = getDynamicTaskLists(tabId);
    
    dynamicTaskLists.forEach(function(listId) {
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