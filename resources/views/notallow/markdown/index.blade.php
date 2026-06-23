<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('MarkDown Index') }}</div> 
                    <div class="add-markdown">
                        <input type="text" placeholder="name" id="name">
                        <input type="text" placeholder="detail" id="detail">
                        <button>  Add MarkDown </button>
                    </div>
                    
                <div class="card-body">
                    <p>Load markdown list</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="font-weight: bold;">Name</th>
                                <th class="text-center" style="font-weight: bold;">Detail</th>
                                <th class="text-center" style="font-weight: bold;" width="5%">Edit</th>
                                <th class="text-center" style="font-weight: bold;" width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="display-markdown"> 
                            @foreach ($select_markdown as $markdown)
                                <tr>
                                    <td>{{ $markdown->name }}</td>
                                    <td>{{ $markdown->detail }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-edit" data-id="{{ $markdown->id }}" data-name="{{ $markdown->name }}" data-detail="{{ $markdown->detail }}">Edit</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-delete" data-id="{{ $markdown->id }}">Delete</button>
                                    </td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('.add-markdown button').on('click', function() {
        var name = $('#name').val();
        var detail = $('#detail').val();
        // Perform AJAX request to add markdown
        $.ajax({
            url: '/markdown/store', // Adjust the URL as needed
            method: 'POST',
            data: {
                name: name,
                detail: detail,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                // Handle success (e.g., refresh markdown list)
                 
                $('#display-markdown').append(`
                    <tr>
                        <td>${name}</td>
                        <td>${detail}</td>
                        <td><button class="btn btn-primary btn-edit" data-id="${response.id}" data-name="${name}" data-detail="${detail}">Edit</button></td>
                        <td><button class="btn btn-danger btn-delete" data-id="${response.id}">Delete</button></td>
                    </tr>
                `);
                console.log('Markdown added successfully');
            },
            error: function(error) {
                // Handle error
                console.error('Error adding markdown:', error);
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
       
        if(confirm('Are you sure you want to delete this markdown?')) {
            
            var id = $(this).data('id');
            var data = {
                id: id,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            };
            // Perform AJAX request to delete markdown
            $.ajax({
                url: '/markdown/delete/', // Adjust the URL as needed
                method: 'DELETE',
                data: data,
                success: function(response) {
                    // Handle success (e.g., remove markdown from list)
                    console.log('Markdown deleted successfully');
                    location.reload(); // Reload the page to reflect changes
                },
                error: function(error) {
                    // Handle error
                    console.error('Error deleting markdown:', error);
                }
            });

        }
    });

    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var detail = $(this).data('detail');
            Swal.fire({
                title: 'Edit MarkDown',
                html: `
                    <input type="text" id="edit-name" class="swal2-input" placeholder="Name" value="${name}">
                    <input type="text" id="edit-detail" class="swal2-input" placeholder="Detail" value="${detail}">
                `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                preConfirm: () => {
                    const name = document.getElementById('edit-name').value;
                    const detail = document.getElementById('edit-detail').value;
                    return { name, detail };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = {
                        id: id,
                        name: result.value.name,
                        detail: result.value.detail,
                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                    };
                    // Perform AJAX request to update markdown
                    $.ajax({
                        url: '/markdown/update/', // Adjust the URL as needed
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            // Handle success (e.g., refresh markdown list)
                            console.log('Markdown updated successfully');
                            location.reload(); // Reload the page to reflect changes
                        },
                        error: function(error) {
                            // Handle error
                            console.error('Error updating markdown:', error);
                        }
                    });
                }
        });
    });
</script>
</x-app-layout>