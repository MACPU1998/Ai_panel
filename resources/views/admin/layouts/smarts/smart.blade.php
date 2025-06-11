@extends('admin.layouts.project_master_admin')

@section('title', 'مشاور هوشمند')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">


                <div class="container mt-3">
                    <div id="chatBox" class="border rounded p-3 mb-3" style="height: 300px; overflow-y: auto;">
                        <!-- پیام‌ها اینجا نمایش داده می‌شوند -->
                    </div>

                    <div class="d-flex mt-4">
                        <textarea id="chatMessage" class="form-control me-2" rows="1" placeholder="سوال خود را بپرسید ..."></textarea>
                        <button id="sendBtn" class="btn btn-primary" style="height: 40px; align-self: center;">ارسال
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.getElementById('sendBtn').addEventListener('click', function () {
            const message = document.getElementById('chatMessage').value;
            if (message.trim() === '') return;

            const chatBox = document.getElementById('chatBox');
            chatBox.innerHTML += `<div class="text-end mb-2"><strong>پیام شما:</strong> ${message}</div>`;

            fetch('{{ route('smarts.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML += `<div class="text-start mb-2"><strong>ربات:</strong> ${data.reply}</div>`;
                    chatBox.scrollTop = chatBox.scrollHeight;
                });

            document.getElementById('chatMessage').value = '';
        });
    </script>
@endsection
