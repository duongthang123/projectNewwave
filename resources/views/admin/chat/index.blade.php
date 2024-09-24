@extends('admin.layouts.index')

@section('title', 'Trò chuyện')
@section('content')
    <div class="card-body">
            <div class="row">
                <div style="overflow: scroll" class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0 d-none d-md-block">
                    <div class="p-3">
                        <div class="input-group rounded mb-3">
                            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon">
                            <span class="input-group-text border-0" id="search-addon">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>

                        <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;">
                            <ul id="users" class="list-unstyled mb-0">
                            </ul>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-lg-7 col-xl-8">
                    <div id="scroll-list-message" class="pt-3 pe-3" data-mdb-perfect-scrollbar="true" style="position: relative; min-height: 85vh; overflow: scroll">
                        <div  data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;">
                            <ul id="messages" class="messages list-unstyled mb-0">
                            </ul>
                        </div>
                    </div>

                    <div id="typing-status" class="p-2 text-muted" style="font-style: italic;"></div>

                    <form class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                        <input type="text" id="message" class="form-control" placeholder="Nhập tin nhắn...">
                        <button id="send" class="ms-3 btn btn-primary sm"><i class="fas fa-paper-plane"></i></button>
                    </form>

                </div>
            </div>
    </div>
@endsection

@section('script')
    <script>
        window.currentUser =  @json(auth()->user());
    </script>
    <script src="{{ asset('admin/assets/js/join-chat.js')}}" type="module"></script>
    <script src="{{ asset('admin/assets/js/chat.js')}}" type="module"></script>
    <script src="{{ asset('admin/assets/js/notify-chat.js')}}"></script>
@endsection