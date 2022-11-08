@extends('layouts.app')
@push('styles')
    <style>
        #users > li{
            cursor:pointer;
        }
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
                                        </ul>
                                    </div>
                                </div>
                                <form>
                                    <div class="row py-3">
                                        <div class="col-10">
                                            <input id="message" class="form-control" type="text">
                                        </div>
                                        <div class="col-2">
                                            <button id="send" type="submit" class="btn btn-info text-white">Send
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-2">
                                <p><strong>Online now</strong></p>
                                <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh">
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

        const usersElement = document.getElementById("users");
        let messages = document.getElementById("messages");

        Echo.join('chat')
            .here((users)=>{
                users.forEach((user,index) => {
                    let element= document.createElement('li')
                    element.setAttribute('id',user.id)
                    element.setAttribute('onclick','greetUser("'+user.id+'")')
                    element.innerText = user.name;
                    usersElement.appendChild(element)
                })
            })
            .joining((user)=>{
                let element= document.createElement('li')
                element.setAttribute('id',user.id)
                element.setAttribute('onclick','greetUser("'+user.id+'")')
                element.innerText = user.name;
                usersElement.appendChild(element)
            })
            .leaving((user)=>{
                const element = document.getElementById(user.id)
                element.parentNode.removeChild(element)
            })
            .listen('MessageSent', el => {
                console.log(el);
                let element = document.createElement('li');
                element.innerText = el.user.name + " : " + el.message;
                messages.appendChild(element);
        });
    </script>

    <script>
        const sendElement = document.getElementById('send');
        const messageElement = document.getElementById("message");

        sendElement.addEventListener('click', (e) => {
            e.preventDefault();

            window.axios.post('/chat/message', {
                message: messageElement.value,
            }).then(el => {
                console.log(el);
            });
            messageElement.value = '';
        })
    </script>

    <script>
        function greetUser(id){
            window.axios.post('/chat/greet/'+id);
        }
    </script>

    <script>
        Echo.private('chat.greet.{{auth()->user()->id}}')
            .listen('GreetingSent',(e) => {
                console.log(e);
                let element = document.createElement('li');
                element.innerText = e.message;
                element.classList.add('text-success');
                messages.appendChild(element);
            })
    </script>
@endpush
