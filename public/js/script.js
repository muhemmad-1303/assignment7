const userId = document.cookie.split('; ').find(row => row.startsWith('userId=')).split('=')[1] || null;
console.log(userId);
    const addTaskForm = document.getElementById('add-task-form');
    const taskList = document.getElementById('task-list');
    const modal=document.querySelector('.modal');
    addTaskForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const taskInput = document.getElementById('task');
        const task = taskInput.value.trim();

        if (task) {
            fetch('/api/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ task }),
            })
                .then(response => response.json())
                .then(data => {
                    taskInput.value = '';
                    taskList.innerHTML="";
                    fetchTasks();
                })
                .catch(error => {
                    console.error({"message":"error"});
                });
        }
    });
    function fetchTasks() {
        fetch('/api/tasks')
            .then(response => response.json())
            .then(data => {
                const taskList = document.getElementById('task-list');
                data.forEach(task => {
                    const taskItem = document.createElement('div');
                    taskItem.classList.add('task-item');
                    if(!task.complete){
                    taskItem.innerHTML = `
                        <div>
                        <div>${task.task}</div>
                        </div 
                    `;
                    taskItem.innerHTML+=`   <aside><button class="delete-task" data-task-id="${task.id}">🗑️</button>
                    <button class="edit-task"   data-task-id="${task.id}">✏️</button>
                    <button class="complete-task" data-task-id="${task.id}">✔️</button></aside>`}
                    else{
                        taskItem.innerHTML = `
                        <div>
                        <div class="strike">${task.task}</div>
                        </div 
                    `;
                    taskItem.innerHTML+=`   <aside><button class="delete-task" data-task-id="${task.id}">🗑️</button>
                    <button class="edit-task"   data-task-id="${task.id}">✏️</button>
                    <button class="undo-task" data-task-id="${task.id}">\u{21BA}</button></aside>`
                    }
                    taskList.appendChild(taskItem);
                });
            })
            .catch(error => {
                console.error({"message":"error"});
            });
    }
    taskList.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-task')) {
            const taskId = e.target.getAttribute('data-task-id');
            const modalParent=document.querySelector('.buttons');
            modalParent.innerHTML=" ";
            const dltbtn=document.createElement('button');
            dltbtn.id='delete';
            dltbtn.textContent="delete";
            const canclbtn=document.createElement('button');
            canclbtn.id='cancel';
            canclbtn.textContent="cancel";
            modalParent.append(canclbtn,dltbtn)
            modal.classList.toggle('modalHidden');
            dltbtn.addEventListener('click',function(){
                handledlt(taskId);
                modal.classList.toggle('modalHidden')
      
  })
  canclbtn.addEventListener('click',function(){
    modal.classList.toggle('modalHidden');
    
})
            
        }
        else if (e.target.classList.contains('complete-task')) {
            const taskId = e.target.getAttribute('data-task-id');
            if (taskId) {
                fetch(`/api/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Pass the CSRF token
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        // Call the fetchTasks function to update the task list
                        taskList.innerHTML="";
                        fetchTasks();
                    })
                    .catch(error => {
                        console.error({"message":"error"});
                    });
            }}
            else if (e.target.classList.contains('undo-task')) {
                const taskId = e.target.getAttribute('data-task-id');
                if (taskId) {
                    fetch(`/api/tasks/${taskId}`, {
                        method: 'PUT', 
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Pass the CSRF token
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            
                            taskList.innerHTML="";
                            fetchTasks();
                        })
                        .catch(error => {
                            console.error({"message":"error"});
                        });
                }}
                else if (e.target.classList.contains('edit-task')) {
                    const taskitem = e.target.closest('.task-item');
                    const tasktext = taskitem.querySelector('div');
                    const inputfield = document.createElement('input');
                    inputfield.type = 'text';
                    inputfield.value = tasktext.textContent.trim();
                    const saveButton = document.createElement('button');
                    saveButton.textContent = 'Save';
                    saveButton.classList.add('save');
                    taskitem.innerHTML = '';
                    taskitem.appendChild(inputfield);
                    taskitem.appendChild(saveButton);
                    saveButton.addEventListener('click', function () {
                        const updatedTask = inputfield.value;
                        const taskId = e.target.getAttribute('data-task-id');
                        if (taskId && updatedTask) {
                            fetch(`/api/tasks/${taskId}`, {
                                method: 'PUT', 
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Pass the CSRF token
                                },
                                body: JSON.stringify({ task: updatedTask }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    taskList.innerHTML="";
                                    fetchTasks();
                                })
                                .catch(error => {
                                    console.error({"message":"error"});
                                });
                        }
                    });
                }
    });

   
  function handledlt(taskId){
      if (taskId) {
    fetch(`/api/tasks/${taskId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Pass the CSRF token
        },
    })
        .then(response => response.json())
        .then(data => {
            taskList.innerHTML="";
            fetchTasks();
        })
        .catch(error => {
            console.error({"message":"error"});
        });
}
  }

   
  fetchTasks()
  