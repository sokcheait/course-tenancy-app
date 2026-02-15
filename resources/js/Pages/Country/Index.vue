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
    countries: Object,
    filters:Object,
    meta: Object,
})

const columns = [
    { label: '#', key: 'index' },
    { label: 'Name', key: 'name' },
    { label: 'Flag', key: 'flag' }
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
                    <span class="mx-1 mt-[3px]">Countries</span>
                </div>
            </div>
        </template>

        <div class="py-2">
        	<div class="px-0 mb-4 mt-4"></div>
            <div class="px-0">
                <div class="bg-white shadow rounded-lg">
                    <DataTable 
                        :columns="columns" 
                        :rows="countries?.data" 
                        :links="countries?.links" 
                        empty-text="No roles found."
                        :search="filters.search" 
                        :meta="meta"
                        route-name="admin.countries.index"
                    >
                    </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>