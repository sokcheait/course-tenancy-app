<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { onClickOutside } from '@vueuse/core'
import DestroyMixin from '@/Actions/DestroyMixin.js'

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
const dropdownRef = ref(null)
const { destroy } = DestroyMixin()

onClickOutside(dropdownRef, () => {
    open.value = false
})

function handleDelete() {
    open.value = false
    destroy(props.deleteUrl,props.deleteText)
}
</script>

<template>
    <div ref="dropdownRef" class="relative inline-block text-left">
        <!-- Trigger button -->
        <button @click.stop="open = !open" @keydown.esc="open = false" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
            <EllipsisVerticalIcon class="w-5 h-5" />
        </button>

        <!-- Dropdown -->
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-if="open"
                class="absolute right-0 z-50 mt-2 w-44
                       bg-white dark:bg-darker
                       border border-gray-200 dark:border-gray-700
                       rounded-lg shadow-lg"
            >
                <div class="py-1 text-sm">
                    <!-- View -->
                    <Link
                        v-if="viewUrl"
                        :href="viewUrl"
                        @click="open = false"
                        class="flex items-center gap-2 px-4 py-2
                               hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <EyeIcon class="w-4 h-4" />
                        View
                    </Link>

                    <!-- Edit -->
                    <Link
                        v-if="editUrl"
                        :href="editUrl"
                        @click="open = false"
                        class="flex items-center gap-2 px-4 py-2
                               hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <PencilSquareIcon class="w-4 h-4" />
                        Edit
                    </Link>

                    <!-- Delete -->
                    <button
                        v-if="deleteUrl"
                        @click="handleDelete"
                        class="flex items-center gap-2 w-full text-left
                               px-4 py-2 text-red-600
                               hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <TrashIcon class="w-4 h-4" />
                        Delete
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>