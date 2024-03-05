@extends('layout/add')

@section('title', 'Todo Edit')

@section('content')
<div>
    <h1> edit Todo list with laravel</h1>

    @if($errors->first('title'))
    <div>
        {{ $errors->first('title') }}
    </div>
    @endif
        
    @if(session()->has('success'))
    <div>
        {{session()->get('success')}}
    </div>
    @endif
    <form  action="{{ route('todo.update' ,['id' => $todo->id] ) }}" method="post">
        @method('PUT')
        @csrf
        <input value="{{ $todo->title }}" name="title" type="text" placeholder="edit todo title">
        <br>
        <select name="is_completed" id="">
            <option {{ !$todo->is_completed ? 'selected' : ''  }} value="0">Pending</option>
            <option {{ $todo->is_completed ? 'selected' : ''  }} value="1">Completed</option>
        </select>
        <input type="submit" value ="edit todo">
    </form>
   
</div>
@endsection