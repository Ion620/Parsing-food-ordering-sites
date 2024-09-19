@extends('layout.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>CRUD</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('establishments.create') }}"> Create</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Opening time</th>
            <th>Closing time</th>
            <th>Payment methods</th>
            <th>Popular dishes</th>
        </tr>
        @foreach ($establishments as $establishment)
            <tr>
                <td>{{ $establishment->name }}</td>
                <td>{{ $establishment->opening_time }}</td>
                <td>{{ $establishment->closing_time }}</td>
                <td>{{ $establishment->payment_methods }}</td>
                <td>{{ $establishment->popular_dishes }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('establishments.show',$establishment->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('establishments.edit',$establishment->id) }}">Edit</a>
                    <form action="{{ route('establishments.destroy',$establishment->id) }}" method="POST">

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
