@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Active Todos</div>
                <div class="panel-body">
                    @if ($active)
                    @foreach ($active as $todo)
                        <div><a href="todo/{{ $todo->id }}/complete">{{ $todo->name }}</a></div>
                    @endforeach
                    @else
                        <p>No Todo's... Create one!</p>
                    @endif
                </div>
                @if ($completed)
                <div class="panel-heading">Completed Todos</div>
                <div class="panel-body">
                    <a href="/delete" class="btn pull-right btn-primary btn-danger">Delete Completed</a>
                    @foreach ($completed as $todo)
                        <div><del><a href="todo/{{ $todo->id }}/complete">{{ $todo->name }}</a></del></div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Create new Todo</div>
                <div class="panel-body">
                    @if($errors->first('name'))
                    <div class="alert alert-danger">
                        <?php echo $errors->first('name'); ?>
                    </div>
                    @endif
                    <form action="/todo" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="todo-name" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="todo-name" class="form-control" placeholder="What do you want to fix later?">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-primary">Add Todo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
