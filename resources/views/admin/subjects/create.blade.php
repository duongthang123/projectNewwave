@extends('admin.layouts.index')

@section('title', 'Create Subject')
@section('content')
    <div class="card-body">
        <h1>{{ isset($subject) ? 'Update Subject' : 'Create Subject'}}</h1>
        @if (isset($subject))
            {!! Form::model($subject, [
                'route' => ['subjects.update', $subject->id],
                'method' => 'PUT',
            ]) !!}
        @else
        {!! Form::open([
            'route' => ['subjects.store'],
            'method' => 'POST',
        ]) !!}
        @endif
            <div>
                <div class="form-group">
                    {!! Form::label('subject_name', 'Subject Name') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'subject_name', 'placeholder' => 'Enter subject name...']) !!}
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('subject_description', 'Subject Description') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4, 'id' => 'subject_description']) !!}
                </div>
            </div>

            <div>
                @if (isset($subject))
                    {!! Form::submit(__('message.Update'), ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                        data-url="subjects/{{ $subject->id }}">
                        {{__('message.Delete')}}
                    </button>
                    @include('admin.layouts.confirmDelete')
                @else
                    {!! Form::submit(__('message.Create'), ['class' => 'btn btn-primary']) !!}
                @endif
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">{{__('message.Back')}}</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection