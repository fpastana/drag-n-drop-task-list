<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>felipepastana.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .feather-16{
            width: 16px;
            height: 16px;
        }

        table {width: 400px; font-size: 14px; font-family: tahoma, arial, sans-serif;}
        table thead th {background-color: #ddd; padding: 5px 8px;}
        table tr td {border-top: 1px solid #999;}
        table td {background-color: #eee; padding: 5px 8px;}
        table tbody tr:nth-child(even) td {background-color: #f3f3f3;}

        table.sorting-table {cursor: move;}
        table tr.sorting-row td {background-color: #aaa !important; color: #fff;}
    </style>
</head>
<body>
    <div class="container">
        <div class="row p-lg-5">
            <div class="col-md-12">
                <h1 class="text-center">
                    <a href="https://laravel.felipepastana.com" target="_blank" class="link-success">felipepastana.com</a>
                </h1>
            </div>
        </div>
        <div class="row p-lg-3">
            <div class="col-md-12 d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Projects
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item @if(!isset(request()->project_id)) active @endif" href="{{ route('taskIndex') }}">All</a></li>
                        @foreach($projects as $project)
                            <li><a class="dropdown-item @if(request()->project_id == $project->id) active @endif" href="{{ route('taskIndex', [ 'project_id' => $project->id ]) }}">{{ $project->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @if ($tasks->count() ===0)
            <div class="row p-lg-5">
                <div class="col-md-12">
                    <h1 class="text-center">
                        No records yet
                    </h1>
                    <p class="text-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTask">Add</button>
                    </p>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                        <tr scope="row">
                            <th scope="col">#</th>
                            <th scope="col">Task Name</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Project</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Updated At</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr scope="row" data-reorder-id="{{ $task->id }}">
                                    <th scope="col">{{$task->id}}</th>
                                    <td scope="col">{{$task->name}}</td>
                                    <td scope="col">{{$task->priority}}</td>
                                    <td scope="col">{{$task->project->name}}</td>
                                    <td scope="col">{{$task->created_at}}</td>
                                    <td scope="col">{{$task->updated_at}}</td>
                                    <td scope="col"><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTask" onClick="editTask('{{ $task->id }}', '{{ $task->name }}', {{ $task->project->id }})"><i class="feather-16" data-feather="edit"></i></button></td>
                                    <td scope="col">
                                        <form action="{{ route('taskDestroy', $task->id) }}" id='{{$task->id}}' method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleting('{{$task->id}}')"><i class="feather-16" data-feather="delete"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('statusDelete'))
                        <div class="alert alert-danger">
                            {{ session('statusDelete') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTask">Add</button>
                </div>
            </div>
        @endif
    </div>
    <div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="addTaskLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('taskStore') }}" method="POST">
                @csrf
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTaskLabel">Add Tasks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Task Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Project</label>
                        <select class="form-select" aria-label="Projects" name="project_id">
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <div class="modal fade" id="editTask" tabindex="-1" aria-labelledby="editTaskLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('taskUpdate') }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" class="form-control" id="id" name="id">

                <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTaskLabel">Edit Tasks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Project</label>
                        <select class="form-select" aria-label="Projects" name="project_id" id="project_id">
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script type="text/javascript" src="js/RowSorter.js"></script>

    <script type="text/javascript">

        feather.replace()

        function confirmDeleting(taskId) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this task!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Poof! Your task has been deleted!", {
                        icon: "success",
                    });

                    document.getElementById(taskId).submit();
                } else {
                    swal("Your task is safe!");
                }
            });
        }

        function editTask(taskId, taskName, projectId) {

            document.getElementById("id").value = taskId;
            document.getElementById("name").value = taskName;
            document.getElementById("project_id").value = projectId;

        }

        // https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
        async function putData(url = '', data = {}) {

            const csrfToken = document.querySelector("[name=_token]").value;

            const response = await fetch(url, {
                method: 'PUT',
                mode: 'same-origin',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(data)
            });
            return response.json();
        }

        RowSorter("#table", {
            onDrop:function(tbody, row, new_index, old_index){
                let reorderId = row.getAttribute('data-reorder-id')
                let priority = new_index + 1

                putData('{{route('ajaxSetTaskNewPriority')}}', { id: reorderId, priority: priority })
                    .then((data) => {
                        console.log(data)
                        location.reload()
                    })
            }

        });

    </script>
</body>
</html>
