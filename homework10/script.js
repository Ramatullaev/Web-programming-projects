document.observe('dom:loaded', function() {
    
    // Get the add button and attach event
    $('addButton').observe('click', addTask);
    
    // Allow Enter key to add task
    $('taskInput').observe('keypress', function(event) {
        if (event.keyCode == 13) {
            addTask();
        }
    });
    
    // Enable drag and drop sorting
    Sortable.create('taskList', { tag: 'li' });
});

function addTask() {
    // Read input values using $F()
    var taskText = $F('taskInput');
    var priority = $F('prioritySelect');
    
    // Check if task is not empty
    if (taskText.trim() === '') {
        alert('Please enter a task');
        return;
    }
    
    // Create new task element
    var taskId = 'task_' + new Date().getTime();
    var taskItem = new Element('li', {
        'class': 'task-item ' + priority,
        'id': taskId
    });
    
    // Create task content
    var taskContent = new Element('span', {
        'class': 'task-content'
    }).update(taskText);
    
    // Create delete button
    var deleteBtn = new Element('button', {
        'class': 'delete-btn'
    }).update('Delete');
    
    // Insert content into task item
    taskItem.insert(taskContent);
    taskItem.insert(deleteBtn);
    
    // Insert task into list
    $('taskList').insert(taskItem);
    
    // Apply highlight effect to new task
    new Effect.Highlight(taskId, { duration: 1.5 });
    
    // Add click event to mark as completed
    taskContent.observe('click', function() {
        markCompleted(taskId);
    });
    
    // Add click event to delete button
    deleteBtn.observe('click', function(event) {
        event.stopPropagation();
        deleteTask(taskId);
    });
    
    // Clear input field
    $('taskInput').value = '';
    
    // Refresh sortable
    Sortable.create('taskList', { tag: 'li' });
}

function markCompleted(taskId) {
    var task = $(taskId);
    
    // Check if already completed
    if (task.hasClassName('completed')) {
        return;
    }
    
    // Use Effect.Morph to change style
    new Effect.Morph(taskId, {
        style: 'background-color: #e0e0e0; text-decoration: line-through; color: #888;',
        duration: 0.5
    });
    
    // Add completed class
    task.addClassName('completed');
}

function deleteTask(taskId) {
    // Fade out and remove task
    new Effect.Fade(taskId, {
        duration: 0.5,
        afterFinish: function() {
            $(taskId).remove();
        }
    });
}