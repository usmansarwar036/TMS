@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="rounded" style="border:1px solid var(--info);">
            <div class="flex fJBetween" style="background: var(--info); padding:5px 8px; color: var(--light); font-size:18px">
                <b> Task Management System</b>
                <button onclick="add(this)" style="display: none" id="task-add" class="button button-success">Add</button>
            </div>

            <div style="margin: 10px">
                <span class="b" id="task-error" style="color: var(--danger)"></span>
                <input type="hidden" id="task-id">
                <label class="b" for="task-title">Title</label>
                <input required type="text" class="input" id="task-title" name="title" placeholder="Enter Title">
                <label class="b" for="task-desc">Description</label>
                <textarea required name="desc" placeholder="Enter Description" style="height: 100px" id="task-desc" class="input"></textarea>
                <input id="task-add-btn" type="submit" class="input button button-success" value="Submit">
                <input id="task-update" type="submit" class="input button button-info" style="display: none"
                    value="Update">
            </div>
        </div>
    </div>
    <div class="container ">
        <div class="flex " id="searchBar">
            <input class="input" style="margin: 3px 13px 3px 0" type="text" onkeyup="searchingTextFun(this.value)"
                id="searchingInput" placeholder="Search here">
            <button style="white-space: nowrap" class="button button-success s-button active-border"
                onclick="searchBtn(this,'dataCards')">Show All</button>
            <button style="white-space: nowrap" class="button button-orange s-button"
                onclick="searchBtn(this,'complete')">Show Completed</button>
            <button style="white-space: nowrap" class="button button-warning s-button"
                onclick="searchBtn(this,'incomplete')">Show UnCompleted</button>
            <button style="white-space: nowrap" class="button button-danger ">Clear
                All</button>
        </div>
    </div>
    <div class="container">
        <div class="dataCards complete searchText" style="background-color: var(--orange);">
            <div class="flex fJEnd">

                <div class="flex fJCenter fACenter" style="margin: 5px 15px">
                    <p>Complete:</p> <input style="margin: 5px" checked type="checkbox">
                </div>
                <div class="flex fJCenter fACenter" style="margin: 5px 15px">
                    Updated at: 2023-07-12 08:23:00
                </div>
                <a href="#" class="button-sm button-info" onclick="edit(1,'title','desc')">Edit</a>
                <button class="button-sm button-danger">Delete</button>

            </div>
            <div class="flex" style="gap: 10px">
                <div class="flex column">
                    <b>Title: </b>
                    <b>Description:</b>
                </div>
                <div class="flex column">
                    <p class="boxText">First Box Title</p>
                    <p class="justify boxText">First Box Description</p>
                </div>
            </div>
        </div>
        <div class="dataCards incomplete searchText" style="background-color: var(--warning);color:var(--dark)">
            <div class="flex fJEnd">
                <div class="flex fJCenter fACenter" style="margin: 5px 15px">
                    <p>Complete:</p> <input style="margin: 5px" type="checkbox">
                </div>
                <div class="flex fJCenter fACenter" style="margin: 5px 15px">
                    Updated at: 2023-07-12 08:23:00
                </div>

                <button class="button-sm button-info">Edit</button>
                <button class="button-sm button-danger">Delete</button>

            </div>
            <div class="flex" style="gap: 10px">
                <div class="flex column">
                    <b>Title: </b>
                    <b>Description:</b>
                </div>
                <div class="flex column">
                    <p class="boxText">Second Box Title</p>
                    <p class="justify boxText">second Box Description</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function edit(id, title, desc) {
            document.getElementById('task-id').value = id;
            document.getElementById('task-title').value = title;
            document.getElementById('task-desc').value = desc;
            document.getElementById('task-add').style.display = "inline-block";
            document.getElementById('task-add-btn').style.display = "none";
            document.getElementById('task-update').style.display = "block";
        }

        function add(thi) {
            thi.style.display = 'none';
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
    </script>
@endsection
