@extends('layouts.app')

@section('content')
    <div class="form-wrap">
        <div class="form-card">
            <div class="eyebrow">Add to your list</div>
            <h1>What needs doing?</h1>
            <p>Write it down while it is fresh. You can always add more detail later.</p>
            <form class="form-grid" action="{{ route('tasks.store') }}" method="POST">
                @csrf
                @include('tasks.form')
                <div class="form-actions">
                    <button class="button" type="submit">Save task</button>
                    <a class="button secondary" href="{{ route('tasks.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
