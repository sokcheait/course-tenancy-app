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
    domains: Object
})

const columns = [
    { label: '#', key: 'index' },
    { label: 'Domain', key: 'domain' },
    { label: 'Created', key: 'created_at' }
]

</script>

<template>
    <AppLayout title="Domain">
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">Home</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Domain</span>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="px-0 mb-4 mt-4">
                <Link :href="route('admin.domains.create')" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-primary focus:outline-none">
                    + Create Domain
                </Link>
            </div>
            <div class="px-0">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <DataTable
                        :columns="columns"
                        :rows="domains.data"
                        :links="domains.links"
                        empty-text="No domains found."
                    >
                        <template #actions="{ row }">
                            <ActionDropdown
                                :view-url="route('admin.domains.show', row.id)"
                                :edit-url="route('admin.domains.edit', row.id)"
                                :delete-url="route('admin.domains.destroy', row.id)"
                            />
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>