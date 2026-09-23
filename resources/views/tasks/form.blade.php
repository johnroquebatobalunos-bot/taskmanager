<div class="field">
    <label for="task_name">Task name</label>
    <input id="task_name" name="task_name" type="text" value="{{ old('task_name', $task->task_name ?? '') }}" placeholder="e.g. Prepare weekly report" maxlength="255" required autofocus>
    @error('task_name') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="field">
    <label for="description">Description <span>(optional)</span></label>
    <textarea id="description" name="description" placeholder="Add useful context or a first step...">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="form-grid form-grid-two">
    <div class="field">
        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="Pending" @selected(old('status', $task->status ?? 'Pending') === 'Pending')>Pending</option>
            <option value="Completed" @selected(old('status', $task->status ?? '') === 'Completed')>Completed</option>
        </select>
        @error('status') <div class="error">{{ $message }}</div> @enderror
    </div>
    <div class="field">
        <label for="due_date">Due date <span>(optional)</span></label>
        <input id="due_date" name="due_date" type="date" value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
        @error('due_date') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>
