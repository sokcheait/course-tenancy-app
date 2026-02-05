<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3'
import DataTable from '@/Components/DataTable/BaseTable.vue'
import ActionDropdown from '@/Components/DataTable/ActionDropdown.vue'
import {
    HomeIcon,
    ChevronRightIcon,
    PlusCircleIcon
} from '@heroicons/vue/24/outline'

defineProps({
    roles: Object
})

const columns = [
    { label: '#', key: 'index' },
    { label: 'Name', key: 'name' },
    { label: 'Status', key: 'is_active' }
]

</script>

<template>
    <AppLayout title="Roles">
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">Home</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Role</span>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="px-0 mb-4 mt-4">
                <Link :href="route('admin.roles.create')" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-primary focus:outline-none">
                    <PlusCircleIcon class="w-5 h-5 mr-2" /> Create Role
                </Link>
            </div>
            <div class="px-0">
                <div class="bg-white shadow rounded-lg">
                    <DataTable :columns="columns" :rows="roles?.data" :links="roles?.links" empty-text="No roles found.">
                        <template #is_active="{ value }">
                            <span class="px-2 py-1 rounded text-xs" :class="value ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                                {{ value ? 'Active' : 'Inactive' }}
                            </span>
                        </template>
                        <template #actions="{ row }">
                            <ActionDropdown
                                :edit-url="route('admin.roles.edit', row.id)"
                                :delete-url="route('admin.roles.destroy', row.id)"
                            />
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>