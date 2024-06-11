<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task:' . $task->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div
            class=" grid grid-cols-1 lg:grid-cols-2 gap-4 p-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">

            <form class="col-span-2" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 ml-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Delete Task</button>
              </form>


            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <p>
                    {{ $task->title }}
                </p>
            </div>

            <div class="mb-4">
                <x-input-label for="duedate" :value="__('Due Date')" />
                <p>{{ $task->duedate }}</p>
            </div>

            <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <p>{{ $task->status }}</p>
            </div>

            <div class="mb-4 ">
                <x-input-label for="title" :value="__('Description')" />
                <p>{{ $task->description }}</p>

            </div>
        </div>
    </div>

</x-app-layout>
