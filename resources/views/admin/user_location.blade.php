@extends('admin.layouts.user')

@section('title', 'Lokatsiyalar')

@section('content')
    <div class="content">
        Oraliqni tanlang
        <form method="get">
            <input type="date" name="start_date" value="{{ request('start_date') }}">
            <input type="date" name="end_date" value="{{ request('end_date') }}">
            <input type="submit" value="Ko'rish">
        </form>

    </div>
@endsection