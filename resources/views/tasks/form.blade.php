<form id="create-task-form">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Task Name</label>
        <input type="text" class="form-control" id="name" name="name" >
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Task Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" ></textarea>
        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Create Task</button>
</form>