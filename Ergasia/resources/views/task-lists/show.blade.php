<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $taskList->title }}
            </h2>
            <button onclick="document.getElementById('createTaskForm').classList.toggle('hidden')" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add New Task
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Create Task Form -->
                    <form id="createTaskForm" class="hidden mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded" 
                          action="{{ route('tasks.store', $taskList) }}" method="POST">
                        @csrf
                        <input type="hidden" name="task_list_id" value="{{ $taskList->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="title">Title</label>
                                <input type="text" name="title" id="title" required
                                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="priority">Priority</label>
                                <select name="priority" id="priority" required
                                        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="deadline">Deadline</label>
                                <input type="datetime-local" name="deadline" id="deadline"
                                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Create Task
                            </button>
                        </div>
                    </form>

                    <!-- Tasks List -->
                    <div class="space-y-4">
                        @foreach($tasks as $task)
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="mt-1">
                                                <div class="w-6 h-6 border-2 rounded {{ $task->completed ? 'bg-green-500 border-green-500' : 'border-gray-400' }}">
                                                    @if($task->completed)
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </button>
                                        </form>
                                        
                                        <div>
                                            <h3 class="font-semibold {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                                                {{ $task->title }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-400">{{ $task->description }}</p>
                                            <div class="mt-2 text-sm">
                                                <span class="px-2 py-1 rounded 
                                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                                       ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                                @if($task->deadline)
                                                    <span class="ml-2 text-gray-500 dark:text-gray-400">
                                                        Due: {{ $task->deadline->format('M d, Y H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex space-x-2">
                                        <form action="{{ route('tasks.destroy', $task) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 