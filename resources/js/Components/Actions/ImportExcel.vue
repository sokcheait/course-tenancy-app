<template>
    <button
        @click="open = true"
        class="inline-flex items-center h-8 px-3 rounded-md shadow
            border border-gray-200 text-gray-700"
    >
        <InboxArrowDownIcon class="w-5 h-5 mr-2" />
        {{ label }}
    </button>

    <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40" @click="close"></div>

        <div class="relative bg-white dark:bg-gray-800 w-full max-w-md rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
            Import Excel File
        </h2>

        <form @submit.prevent="submit">
            <!-- File Input -->
            <input
            type="file"
            accept=".xlsx,.xls,.csv"
            @change="handleFile"
            class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded file:border-0
                    file:bg-gray-100 file:text-gray-700
                    hover:file:bg-gray-200"
            />

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" @click="close" class="px-4 py-2 border rounded text-gray-600">
                    Cancel
                </button>
                <button type="submit" :disabled="!file || loading" class="px-4 py-2 border text-gray-600 rounded disabled:opacity-50">
                    {{ loading ? 'Uploading...' : 'Upload' }}
                </button>
            </div>
        </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { InboxArrowDownIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    routeName: {
        type: String,
        required: true,
    },
    only: {
        type: Array,
        default: () => [],
    },
    label: {
        type: String,
        default: () => 'Import Excel',
    }
})

const open = ref(false)
const file = ref(null)
const loading = ref(false)

const handleFile = (e) => {
    file.value = e.target.files[0]
}

const close = () => {
    open.value = false
    file.value = null
}

const submit = () => {
    if (!file.value) return
    loading.value = true
    const formData = new FormData()
    formData.append('file', file.value)
    router.post(route(props.routeName), formData, {
        forceFormData: true,
        onFinish: () => {
            loading.value = false
            close()
            if (props.only.length) {
                router.reload({ only: props.only })
            }
        },
    })
}
</script>