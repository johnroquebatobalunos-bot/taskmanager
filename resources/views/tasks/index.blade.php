@extends('layouts.app')

@section('content')
    <section class="intro">
        <div class="intro-copy">
            <div class="eyebrow">Personal Task Manager </div>
            <h1> Healthy leaving cuz popular. </h1>
            <p>Doubt kills more dreams than failure ever will.</p>
        </div>
        <span class="intro-note">Your tasks, all in one place.</span>
    </section>

    <section class="stats" aria-label="Task summary">
        <div class="stat"><div class="stat-label">All tasks</div><div class="stat-value">{{ $totalTasks }}</div></div>
        <div class="stat"><div class="stat-label">Still to do</div><div class="stat-value">{{ $pendingTasks }}</div></div>
        <div class="stat"><div class="stat-label">Completed</div><div class="stat-value">{{ $completedTasks }}</div></div>
    </section>

    <section class="task-panel">
        <div class="panel-head">
            <h2>Your tasks</h2>
            <span id="task-count">{{ $totalTasks }} {{ $totalTasks === 1 ? 'item' : 'items' }}</span>
        </div>
        <div class="task-toolbar">
            <label class="search-box" for="task-search">
                <span aria-hidden="true">⌕</span>
                <input id="task-search" type="search" placeholder="Search tasks..." autocomplete="off">
            </label>
            <div class="filter-group" aria-label="Filter tasks">
                <button class="filter-button is-active" type="button" data-filter="all" aria-pressed="true">All</button>
                <button class="filter-button" type="button" data-filter="Pending" aria-pressed="false">Pending</button>
                <button class="filter-button" type="button" data-filter="Completed" aria-pressed="false">Completed</button>
            </div>
        </div>
        @forelse ($tasks as $task)
            <article class="task-item" data-status="{{ $task->status }}" data-search="{{ strtolower($task->task_name . ' ' . $task->description) }}">
                <div>
                    <div class="task-title">{{ $task->task_name }}</div>
                    @if ($task->description)
                        <div class="task-description">{{ $task->description }}</div>
                    @endif
                </div>
                <div class="task-meta {{ $task->status === 'Pending' && $task->due_date && $task->due_date->isBefore(now()->startOfDay()) ? 'overdue' : '' }}">
                    @if ($task->due_date)
                        {{ $task->status === 'Pending' && $task->due_date->isBefore(now()->startOfDay()) ? 'Overdue' : 'Due' }} {{ $task->due_date->format('M j, Y') }}
                    @else
                        No deadline
                    @endif
                </div>
                <div class="actions">
                    <form class="inline-form" action="{{ route('tasks.status', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="status {{ strtolower($task->status) }}" type="submit" aria-label="Mark {{ $task->status === 'Pending' ? 'completed' : 'pending' }}: {{ $task->task_name }}" title="Click to change status">{{ $task->status }}</button>
                    </form>
                    <a class="text-link" href="{{ route('tasks.edit', $task) }}">Edit</a>
                    <form class="inline-form" action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-link danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="empty"><strong>Your list is clear.</strong>Add your first task to get moving.</div>
        @endforelse
        <div class="empty filtered-empty" hidden><strong>No matching tasks.</strong>Try a different search or status filter.</div>
    </section>

    <section class="add-task-panel" id="add-task-panel">
        <div class="add-task-heading">
            <div>
                <div class="eyebrow">New task</div>
                <h2>Add something to your list</h2>
            </div>
        </div>
        <form class="form-grid" action="{{ route('tasks.store') }}" method="POST">
            @csrf
            @include('tasks.form')
            <div class="form-actions">
                <button class="button" type="submit">Save task</button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        const searchInput = document.querySelector('#task-search');
        const filterButtons = document.querySelectorAll('[data-filter]');
        const taskItems = document.querySelectorAll('.task-item');
        const filteredEmpty = document.querySelector('.filtered-empty');
        const taskCount = document.querySelector('#task-count');
        let selectedFilter = 'all';

        function filterTasks() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            taskItems.forEach((task) => {
                const matchesFilter = selectedFilter === 'all' || task.dataset.status === selectedFilter;
                const matchesSearch = task.dataset.search.includes(searchTerm);
                const visible = matchesFilter && matchesSearch;
                task.hidden = !visible;
                visibleCount += visible ? 1 : 0;
            });

            filteredEmpty.hidden = visibleCount !== 0 || taskItems.length === 0;
            taskCount.textContent = `${visibleCount} ${visibleCount === 1 ? 'item' : 'items'}`;
        }

        searchInput.addEventListener('input', filterTasks);
        filterButtons.forEach((button) => button.addEventListener('click', () => {
            selectedFilter = button.dataset.filter;
            filterButtons.forEach((filterButton) => {
                const active = filterButton === button;
                filterButton.classList.toggle('is-active', active);
                filterButton.setAttribute('aria-pressed', active);
            });
            filterTasks();
        }));
    </script>
@endpush
