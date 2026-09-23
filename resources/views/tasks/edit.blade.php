@extends('layouts.app')

@section('content')
    <div class="form-wrap">
        <div class="form-card">
            <div class="eyebrow">Make a change</div>
            <h1>Keep it up to date.</h1>
            <p>Plans change. Update the details or mark this task as complete.</p>
            <form class="form-grid" action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                @include('tasks.form')
                <div class="form-actions">
                    <button class="button" type="submit">Update task</button>
                    <a class="button secondary" href="{{ route('tasks.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
