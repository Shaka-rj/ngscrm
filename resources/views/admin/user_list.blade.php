@extends('admin.layouts.user')

@section('title', 'Hodimlar')

@section('content')
    <div class="content">
        @if ($type == 1)
            <table>
                <tr>
                    <th>Ism - Familiya</th>
                    <th>Hudud</th>
                    <th>Lavozim</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }} - {{ $user->lastname }}</td>
                    <td>{{ $user->region->name }}</td>
                    <td>@if ($user->role == 2) Agent @else Menejer @endif</td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>
@endsection