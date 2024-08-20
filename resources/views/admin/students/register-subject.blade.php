@extends('admin.layouts.index')

@section('title', __('message.Register Subjects'))
@section('content')
    <div class="card-body">
        <h1>{{  __('message.Register Subjects') }}</h1>
        <div class="row mb-2">
            <div class="col-md-8 d-flex align-items-center">
                <img src="{{ $student->avatar_url }}" id="show-image" style="max-width: 100px;max-height: 100px; border-radius: 5px" alt=""/>
                <div class="ml-3">
                    <h4 style="font-weight: 600"> {{ $student->user->name }}</h4>
                    <div class="d-flex">
                        <p class="mb-0 mr-3">{{ __('message.Student Code')}}: {{ $student->student_code }}</p>
                        <p class="mb-0 mr-3">Email: {{ $student->user->email }}</p>
                        <p class="mb-0 mr-3">{{ __('message.Phone')}}: {{ $student->phone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="row mt-6 mr-2">
            <div class="ml-auto">
                <a class="btn btn-warning" id="update-register-subject-btn" style="display: none;max-width: 140px"
                    data-toggle="modal" data-target="#modal-update-multi-register-subjects"
                >
                    <i class="fas fa-plus"></i>
                    {{ __('message.Register All') }}
                </a>
            </div>
        </div>
        
        <table class="table table-hover table-bordered mt-4">
            <thead>
                <tr>
                    <th style="width: 50px;">
                        <input type="checkbox" id="check-all-register-subject">
                    </th>
                    <th style="width: 50px;">ID</th>
                    <th >{{ __('message.Subject Name') }}</th>
                    <th class="text-center">{{ __('message.Status') }}</th>
                    <th style="width: 100px" class="text-center">{{ __('message.Register') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>
                            @if (!in_array($subject->id, $subjectStudent))
                                <input type="checkbox" class="register-subject-checkbox" value="{{ $subject->id }}"
                                        data-name="{{ $subject->name }}"
                                >
                            @endif
                        </td>
                        <td> {{ $subject->id }} </td>
                        <td> {{ $subject->name }} </td>
                        <td class="text-center"> 
                            {!! in_array($subject->id, $subjectStudent) ? 
                                '<button class="btn btn-sm btn-success" style="min-width: 96px;">'. __('message.Registered') .'</button>' :
                                 '<button class="btn btn-sm btn-secondary" style="min-width: 96px;">'. __('message.UnRegistered') .'</button>' 
                            !!}  
                        </td>
                        <td class="text-center">
                            @if (!in_array($subject->id, $subjectStudent))
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-update-register-subjects-{{$subject->id}}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                @include('admin.includes.update-register-subjects')
                                @include('admin.includes.update-multi-register-subjects')
                            @endif
                        </td>
                @endforeach

            </tbody>
        </table>
        {{ $subjects->appends(request()->query())->links() }}

        {{ Form::open(['route' => ['students.register-subjects', $student->id], 'method' => 'GET', 'class' => 'mb-4']) }}
            <div class="row mt-4">
                <div class="col-md-1 ml-0">
                    {{ Form::select('per_page', config('const.PER_PAGE') , request('per_page'), 
                    [
                        'class' => 'form-control',
                        'onchange' => 'this.form.submit()'
                    ]) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
    
@endsection

@section('script')
    <script src="{{ asset('admin/assets/js/checkbox-subject.js')}}"></script>
@endsection