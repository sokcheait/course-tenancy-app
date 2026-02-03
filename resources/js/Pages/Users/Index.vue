<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3'
import DataTable from '@/Components/DataTable/BaseTable.vue'
import ActionDropdown from '@/Components/DataTable/ActionDropdown.vue'
import {
    HomeIcon,
    ChevronRightIcon
} from '@heroicons/vue/24/outline'

defineProps({
    users: Object
})

const columns = [
    { label: '#', key: 'index' },
    { label: 'Name', key: 'name' },
    { label: 'Email', key: 'email' }
]

</script>

<template>
    <AppLayout title="User">
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">Home</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">User</span>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="px-0 mb-4 mt-4">
                <Link :href="route('admin.users.create')" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-primary focus:outline-none">
                    + Create User
                </Link>
            </div>
            <div class="px-0">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <DataTable
                        :columns="columns"
                        :rows="users?.data"
                        :links="users?.links"
                        empty-text="No domains found."
                    >
                        <template #actions="{ row }">
                            <ActionDropdown
                                :edit-url="route('admin.users.edit', row.id)"
                                :delete-url="route('admin.users.destroy', row.id)"
                            />
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>