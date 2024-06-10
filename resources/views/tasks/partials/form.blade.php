<div class="mb-4">
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
        value="{{ $task->title ?? old('title') }} " />
    <x-input-error :messages="$errors->first('title')" class="mt-2" />

</div>

<div class="mb-4">
    <x-input-label for="duedate" :value="__('Due Date')" />
    <x-text-input id="duedate" name="duedate" type="date" class="mt-1 block w-full"
        value="{{ $task->duedate ?? old('duedate') }} " />
    <x-input-error :messages="$errors->first('duedate')" class="mt-2" />

</div>


<div class="mb-4">
    <x-input-label for="status" :value="__('Status')" />
    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        name="status" id="status">
        <option value="" selected disabled>--Select One--</option>

        @foreach ($statuses as $status)
            <option value="{{ trim($status) }}"
                {{ (old('status') ?? $task->status) == trim($status) ? 'selected' : '' }}>
                {{ trim($status) }}
            </option>
        @endforeach

    </select>
    </select>
    <x-input-error :messages="$errors->first('status')" class="mt-2" />
</div>

<div class="mb-4 ">
    <x-input-label for="title" :value="__('Description')" />
    <x-textarea name='description' label="Description" class="mt-1 block w-full" :rows="5"
        value="{{ $task->description }} " />
    <x-input-error :messages="$errors->first('description')" class="mt-2" />

</div>
