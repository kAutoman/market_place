@extends('panel::layouts.master')

@section('content')
    
    <h2>Users</h2>
	@include("panel::components.user_menu")


    {!! Form::open(['url' => url()->current(), 'method' => 'GET']) !!}
    <div class="input-group mb-3">
        {{Form::text('q', request('q'), ['class' => 'form-control', 'placeholder' => "Search..."])}}
        <div class="input-group-append">
            <button class="btn btn-secondary" type="submit">Search</button>
        </div>
    </div>
    {!! Form::close() !!}

    <table class="table table-sm table-striped">
        <thead class="thead- border-0">
        <tr>
            <th scope="col" class="w-25 border-0">Name</th>
            <th scope="col" class="w-25 border-0">Display name</th>
            <th scope="col" class="w-25 border-0">Email</th>
            <th scope="col" class="w-25 border-0">Date registered</th>
            <th scope="col"  class="w-25 border-0"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $item)
            <tr>
                <td>
                    {{str_limit($item->username, 40)}}
                    {!!  ($item->banned_at)?'<i class="text-muted">(banned)</i>':'' !!}
                </td>
                <td>{{$item->username}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->created_at}}</td>
                <td>
                    <a href="{{url('panel/useredit/'.$item->id)}}" class="text-muted float-right"><i class="fa fa-pencil"></i></a>
                </td>
				<td>
				   <a href="#" ic-target="#main" ic-select-from-response="#main" ic-delete-from="{{ url('panel/userdelete/'.$item->id) }}" ic-confirm="Are you sure?" class="text-muted float-right ml-2"><i class="fa fa-remove"></i></a>

                </td> 
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $users->appends(app('request')->except('page'))->links() }}

@stop
