<!-- resources/views/tasks/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Task Management</h1>

    <!-- Display the response message from Flask -->
    <div id="message" class="alert alert-success" style="display:none;"></div>
    <div id="error" class="alert alert-danger" style="display:none;"></div>

    <!-- Task Creation Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Create a New Task</h2>
        </div>
        <div class="card-body">
           @include('tasks.form')
        </div>
    </div>

    <!-- Task List -->
    <div class="card">
        <div class="card-header">
            <h2>Task List</h2>
        </div>
        <div class="card-body" id="task-table">
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // fetch tasks on page load 
        $.ajax({
            url: "{{ route('tasks.view') }}",
            method: "GET",
            success: function(response) {
                $('#task-table').html(response.data);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                $('#error').text(xhr?.responseJSON?.message).show();
            }
        });


        // Handle task creation via jQuery and AJAX
        $('#create-task-form').submit(function(event) {
            event.preventDefault();
            let name = $('#name').val();
            let description = $('#description').val();
            let token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('tasks.store') }}",
                method: "POST",
                data: {
                    _token: token,
                    name: name,
                    description: description
                },
                success: function(response) {
                    // Append new task to the task list
                    $('#task-table').html(response.data);
                    // Display success message from Python API
                    $('#message').text(response.message).show();
                    // Reset the form
                    $('#create-task-form')[0].reset();
                },
                error: function(xhr, status, error) {
                    $('#error').text(xhr?.responseJSON?.message).show();
                }
            });
        });

        // Handle task completion via jQuery and AJAX
        $(document).on('click', '.complete-task', function() {
            let taskId = $(this).data('id');
            let token = $('input[name="_token"]').val();

            $.ajax({
                url: `/tasks/${taskId}/complete`,
                method: 'PUT',
                data: {
                    _token: token
                },
                success: function(response) {
                    // Update task status in the task list
                    $('#task-table').html(response.data);
                    // Display success message from Python API
                    $('#message').text(response.message).show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $('#error').text(xhr?.responseJSON?.message).show();
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
