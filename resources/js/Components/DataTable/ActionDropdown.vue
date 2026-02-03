<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

import {
    EllipsisVerticalIcon,
    EyeIcon,
    PencilSquareIcon,
    TrashIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    viewUrl: String,
    editUrl: String,
    deleteUrl: String,
    deleteText: {
        type: String,
        default: 'Are you sure you want to delete this item?'
    }
})

const open = ref(false)

function destroy() {
    if (confirm(props.deleteText)) {
        router.delete(props.deleteUrl)
    }
}
</script>

<template>
    <div class="relative inline-block text-left">
        <!-- Button -->
        <button @click="open = !open" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
            <EllipsisVerticalIcon class="w-5 h-5" />
        </button>

        <!-- Dropdown -->
        <div v-if="open" class="absolute right-0 mt-2 w-44 bg-white dark:bg-darker border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50">
            <div class="py-1 text-sm">
                <!-- View -->
                <Link
                    v-if="viewUrl"
                    :href="viewUrl"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <EyeIcon class="w-4 h-4" />
                    View
                </Link>

                <!-- Edit -->
                <Link
                    v-if="editUrl"
                    :href="editUrl"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <PencilSquareIcon class="w-4 h-4" />
                    Edit
                </Link>

                <!-- Delete -->
                <button
                    v-if="deleteUrl"
                    @click="destroy"
                    class="flex items-center gap-2 w-full text-left px-4 py-2
                           text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <TrashIcon class="w-4 h-4" />
                    Delete
                </button>

            </div>
        </div>
    </div>
</template>