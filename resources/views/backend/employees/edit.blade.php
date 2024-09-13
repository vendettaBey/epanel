@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Edit Employee</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $employee->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $employee->email }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $employee->phone }}" required>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position (optional)</label>
            <input type="text" name="position" id="position" class="form-control" value="{{ $employee->position }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($employee->image)
                <img src="{{ asset('storage/'.$employee->image) }}" alt="Profile Image" class="mt-2" style="width: 150px;">
            @endif
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="1" {{ $employee->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$employee->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Employee</button>
    </form>
</div>
@endsection
