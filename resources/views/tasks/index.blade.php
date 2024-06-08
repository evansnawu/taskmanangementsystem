<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <table id="tasks-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            user
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Due date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

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
                        data: function(){
                            return '<div className="bg-blue-700 p-0.5 text-center text-xs font-medium leading-none text-white">Completed</div>'
                        },
                        name: 'status'
                    },
                ],
                drawCallback: function() {
                    $('#tasks-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider');
                     $('#tasks-table tbody tr').addClass('bg-white divide-y divide-gray-200 hover:bg-gray-100 cursor-pointer');
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
                    confirmButtonText: "View Details",
                    denyButtonText: "Make Changes",
                    confirmButtonColor: "#3085d6",
                    denyButtonColor: "#d42e12",
                }).then((result) => {

                    id = urlid(data.id)

                    if (result.isConfirmed) {
                        window.location.href = `{{ url('tasks/${id}') }}`;
                    } else if (result.isDenied) {
                        window.location.href =
                            `{{ url('tasks/${id}/edit') }}`;
                    }
                })

            })

        });
    </script>

</x-app-layout>
