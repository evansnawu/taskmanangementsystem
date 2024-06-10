<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task:' . $task->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div
            class=" grid grid-cols-1 lg:grid-cols-2 gap-4 p-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
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
