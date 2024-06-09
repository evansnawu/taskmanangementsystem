<div class="mb-4">
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $task->value ?? old('title')}} "  />
    <x-input-error :messages="$errors->updateTask->get('title')" class="mt-2" />

</div>

<div class="mb-4">
    <x-input-label for="duedate" :value="__('Due Date')" />
    <x-text-input id="duedate" name="duedate" type="date" class="mt-1 block w-full" value="{{ $task->value ?? old('duedate')}} "  />
    <x-input-error :messages="$errors->updateTask->get('duedate')" class="mt-2" />

</div>

<div class="mb-4">
    <x-input-label for="status" :value="__('Status')" />
        <x-select name="status" :options="$statuses" :selected="$task->status" />
    <x-input-error :messages="$errors->updateTask->get('status')" class="mt-2" />
</div>

<div class="mb-4 ">
    <x-input-label for="title" :value="__('Description')" />
    <x-textarea name='description' label="Description" class="mt-1 block w-full" :rows="5" value="{{ $task->description}} " />
    <x-input-error :messages="$errors->updateTask->get('title')" class="mt-2" />

</div>


