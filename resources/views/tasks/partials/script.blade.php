<script>
    $(document).ready(function() {

        let table = $('#tasks-table').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            pageLength: 10,
            lengthMenu: [
                [50, 60, 70, 80, -1],
                [50, 60, 70, 80, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('tasks.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'user.name',
                    name: 'user'
                },
                {
                    data: 'duedate',
                    name: 'duedate'
                },
                {
                    data: function(data) {
                        return data.status
                    },
                    name: 'status'
                },
            ],
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        let column = this;
                        let title = column.header().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = 'Search '+title.toString().trim();
                        input.id = title;
                        input.className = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full";
                        column.header().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            },
            drawCallback: function() {
                $('#tasks-table thead th').addClass(
                    'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'
                );
                $('#tasks-table tbody tr').addClass(
                    'bg-white divide-y divide-gray-200 hover:bg-gray-100 cursor-pointer');
                $('#tasks-table tbody td').addClass('px-6 py-4 whitespace-wrap');

            }
        });

        $('#tasks-table tbody').on('click', 'tr', function() {
            var data = table.row(this).data();

            Swal.fire({
                title: 'What do you want to do?',
                icon: 'info',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "View or Delete Task",
                denyButtonText: "Edit Task",
                    confirmButtonColor: "#3085d6",
                denyButtonColor: "#000",
                denyButtonColor: "#d42e12",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{ url('tasks/${data.id}') }}`;
                } else if (result.isDenied) {
                    window.location.href =
                        `{{ url('tasks/${data.id}/edit') }}`;
                }
            })

        })

        $('#tasks-table_length').addClass('hidden')
        $('#tasks-table_filter').addClass('hidden')

    });
</script>
