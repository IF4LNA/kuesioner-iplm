@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Aktivitas</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Aksi</th>
                <th>Deskirpsi</th>
                <th>Waktu</th>
                <th>Pengguna</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activityLogs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->created_at}}</td>
                <td>{{ $log->user->username }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
