@extends('template')

@section('content')

    <div class="flex min-h-screen bg-gray-100 items-center flex-col gap-2">
        <div class="max-w-4xl w-full mx-auto my-10 grid gap-5 justify-items-center bg-white p-8 border rounded-sm">

            {!! Form::open(['route' => ['update.send', $feed->slug, $meeting->slug], 'method' => 'post', 'class' => 'grid w-full gap-5']) !!}

            <h1 class="font-bold text-4xl">Request Update</h1>

            <div class="grid gap-1">
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Meeting name
                </label>
                {!! Form::text('name', old('name', $meeting->name), [
    'id' => 'name',
    'autocomplete' => 'off',
    'placeholder' => 'Sunday Funday',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md',
]) !!}
            </div>

            <div class="grid gap-1">
                <label for="day" class="block text-sm font-medium text-gray-700">
                    Day
                </label>
                {!! Form::select('day', ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], old('day', $meeting->day), [
    'id' => 'day',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md',
]) !!}
            </div>

            <div class="grid gap-1">
                <label for="time" class="block text-sm font-medium text-gray-700">
                    Time
                </label>
                {!! Form::time('time', old('time', $meeting->time), [
    'id' => 'time',
    'autocomplete' => 'off',
    //'placeholder' => 'Sunday Funday',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md',
]) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>


@endsection
