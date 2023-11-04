@extends('layouts.app')

@section('content')
    <div id="preloader">
        <div class="loader">
            <div class="loader-inner">
                <div class="loader-circle"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="rounded" style="border:1px solid var(--info);">
            <div class="flex fJBetween" style="background: var(--info); padding:5px 8px; color: var(--light); font-size:18px">
                <b> Task Management System</b>
                <button onclick="add(this)" style="display: none" id="task-add" class="button button-success">Add</button>
            </div>

            <div style="margin: 10px">
                <p class="b" id="task-error" style="color: var(--danger)"></p>
                <input type="hidden" id="task-id">
                <label class="b" for="task-title">Title</label>
                <input required type="text" class="input" id="task-title" name="title" placeholder="Enter Title">
                <label class="b" for="task-desc">Description</label>
                <textarea required name="desc" placeholder="Enter Description" style="height: 100px" id="task-desc" class="input"></textarea>
                <input id="task-add-btn" onclick="addTask()" type="submit" class="input button button-success"
                    value="Submit">
                <input id="task-update" onclick="editTask()" type="submit" class="input button button-info"
                    style="display: none" value="Update">
            </div>
        </div>
    </div>
    <div class="container ">
        <div class="flex " id="searchBar">
            <input class="input" style="margin: 3px 13px 3px 0" type="text" onkeyup="searchingTextFun(this.value)"
                id="searchingInput" placeholder="Search here">

            <button style="white-space: nowrap" class="button button-orange s-button"
                onclick="searchBtn(this,'complete')">Show Completed</button>
            <button style="white-space: nowrap" class="button button-warning s-button"
                onclick="searchBtn(this,'incomplete')">Show UnCompleted</button>
            <button style="white-space: nowrap" class="button button-success s-button active-border"
                onclick="searchBtn(this,'dataCards')">Show All</button>
            <button style="white-space: nowrap" onclick="deleteAll()" class="button button-danger ">Delete
                All</button>
        </div>
    </div>
    <div class="container" id="dataCardsContainer">

    </div>
    <script>
        const url = '{{ url('api/task') }}';
        const user_id = {{ auth()->user()->id }};
        const preloader = document.getElementById('preloader');

        function edit(id, title, desc) {
            document.getElementById('task-id').value = id;
            document.getElementById('task-title').value = title;
            document.getElementById('task-desc').value = desc;
            document.getElementById('task-add').style.display = "inline-block";
            document.getElementById('task-add-btn').style.display = "none";
            document.getElementById('task-update').style.display = "block";
        }

        function add() {
            document.getElementById('task-add').style.display = 'none';
            document.getElementById('task-add-btn').style.display = 'block';
            document.getElementById('task-update').style.display = 'none'
            document.getElementById('task-title').value = '';
            document.getElementById('task-desc').value = '';
            document.getElementById('task-id').value = '';
        }

        function searchBtn(thi, classes) {
            document.getElementById('searchingInput').value = '';
            buttons = document.querySelectorAll('.s-button')
            buttons.forEach(function f(element) {
                if (element.classList.contains('active-border')) {
                    element.classList.remove('active-border')
                }
            });
            thi.classList.add('active-border')
            dataCards = document.querySelectorAll('.dataCards')
            dataCards.forEach(function f(element) {
                if (!element.classList.contains(classes)) {
                    element.style.display = 'none'
                    element.classList.remove('searchText')
                } else {
                    element.classList.add('searchText')
                    element.style.display = 'block'
                }
            });
        }

        function searchingTextFun(value) {
            value = value.toLowerCase();
            boxes = document.querySelectorAll('.searchText')
            boxes.forEach(function f(element) {
                let text = element.querySelectorAll('.boxText')[0].innerText;
                text = text + ' ' + element.querySelectorAll('.boxText')[1].innerText;
                text = text.toLowerCase()
                if (!text.includes(value)) {
                    element.style.display = 'none'
                } else {
                    element.style.display = 'block'
                }
            });
        }

        function fetchAllTask() {
            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    dataCardsContainerContent = ''
                    data.forEach(function f(element) {
                        dataCardsContainerContent += `

                        <div class="dataCards  ${(element.completed==1)?'complete':'incomplete'} searchText"  ${(element.completed==1)?'style="background-color: var(--orange);"':'style="background-color: var(--warning);color:var(--dark)"'}>
                            <div class="flex fJEnd">
                                <div class="flex fJCenter fACenter" style="margin: 5px 15px">
                                    <p>Complete:</p> <input onclick='status(${element.completed},this,${element.id})' style="margin: 5px" ${(element.completed==1)?'checked':''} searchText" type="checkbox">
                                </div>
                                <a href="#" class="button-sm button-info" onclick="edit(${element.id},'${element.title}','${element.desc}')">Edit</a>
                                <button class="button-sm button-danger" onclick="deleteTask(${element.id})">Delete</button>

                            </div>
                            <div class="flex" style="gap: 10px">
                                <div class="flex column">
                                    <b>Title: </b>
                                    <b>Description:</b>
                                </div>
                                <div class="flex column">
                                    <p class="boxText">${element.title}</p>
                                    <p class="justify boxText">${element.desc}</p>
                                </div>
                            </div>
                        </div>

                        `
                    });
                    if (dataCardsContainerContent == '') {
                        dataCardsContainerContent = '<p style="text-align:center">No task found</p>'
                    }
                    dataCardsContainer = document.getElementById('dataCardsContainer');
                    dataCardsContainer.innerHTML = dataCardsContainerContent;
                });
            preloader.style.display = 'none'
        }

        function addTask() {
            preloader.style.display = 'none'
            title = document.getElementById('task-title');
            desc = document.getElementById('task-desc');
            error = document.getElementById('task-error');
            error.innerText = ''
            if (title.value == '') {
                error.innerText = 'title is required'
                return;
            } else if (desc.value == '') {
                error.innerText = 'description is required'
                return;
            }
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: title.value,
                        desc: desc.value,
                        user_id: user_id
                    })
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    title.value = '';
                    desc.value = '';

                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
            fetchAllTask();
        }

        function editTask() {
            preloader.style.display = 'none'
            id = document.getElementById('task-id');
            title = document.getElementById('task-title');
            desc = document.getElementById('task-desc');
            error = document.getElementById('task-error');
            error.innerText = ''
            if (title.value == '') {
                error.innerText = 'title is required'
                return;
            } else if (desc.value == '') {
                error.innerText = 'description is required'
                return;
            } else if (id.value == '') {
                error.innerText = 'description is required'
                return;
            }
            fetch(url + '/' + id.value, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: title.value,
                        desc: desc.value,
                    })
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    console.log(data)
                    title.value = '';
                    desc.value = '';


                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
            add();
            fetchAllTask();

        }

        function status(s, value, id) {
            preloader.style.display = 'none'
            value = (value.checked == true) ? 1 : 0;
            console.log(value)
            if (s != value.checked) {
                if (confirm('Update Task Status?')) {
                    fetch("{{ url('api/status') }}", {
                            method: 'put',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                id: id,
                                completed: value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                        });

                    add();
                    fetchAllTask();
                }
            }

        }

        function deleteTask(id) {
            if (confirm('Cofirm Deletion?')) {
                fetch(url + '/' + id, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                    });
                add();
                fetchAllTask();

            }

        }

        function deleteAll() {
            if (confirm('Cofirm Deletion All Tasks?')) {
                fetch('api/deleteAll', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                    });
                add();
                fetchAllTask();

            }

        }



        window.onload = function() {
            fetchAllTask()
        };
    </script>
@endsection
