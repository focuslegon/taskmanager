<table class="table table-bordered" id="task-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr id="task-{{ $task->id }}">
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td class="task-status">
                    <span class="badge bg-{{ $task->status == 'pending' ? 'warning' : 'success' }}">{{ $task->status }}</span>
                    @if($task->status == 'pending')
                        <button class="btn btn-primary complete-task" data-id="{{ $task->id }}">Mark as Completed</button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>