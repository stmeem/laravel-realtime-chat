@extends('layouts.app')
@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Real-time Chat App</div>

                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 border rounded-lg p-3">
                                        <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh">
                                            <li>Test1:Hello</li>
                                            <li>Test2:Hi!</li>
                                        </ul>
                                    </div>
                                </div>
                                    <form>
                                        <div class="row py-3">
                                            <div class="col-10">
                                                <input id="message" class="form-control" type="text">
                                            </div>
                                            <div class="col-2">
                                                <button id="send" type="submit" class="btn btn-info text-white">Send</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <div class="col-2">
                                <p><strong>Online now</strong></p>
                                <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh">
                                    <li>Test1</li>
                                    <li>Test2</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const usersElement=document.getElementById('users')
    Echo.join('chat')
        .here((users)=>{
            users.forEach((user,index)=>{
                let element= document.createElement('li')
                element.setAttribute('id',e.user.id)
                element.innerText = e.user.name;
                usersElement.appendChild(element)
            })
        })
        .joining()
        .leaving()
</script>
@endpush
