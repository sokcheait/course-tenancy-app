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
                <Link :href="route('domains.create')" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-primary focus:outline-none">
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
                                :view-url="route('domains.show', row.id)"
                                :edit-url="route('domains.edit', row.id)"
                                :delete-url="route('domains.destroy', row.id)"
                            />
                        </template>
                    </DataTable>
                    <!-- <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Domain</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(domain, index) in domains.data" :key="domain.id">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ index + 1 }}
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ domain.domain }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ domain.created_at }}
                                </td>

                                <td class="px-6 py-4 text-right text-sm">
                                    <Link
                                        :href="route('domains.show', domain.id)"
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        View
                                    </Link>
                                </td>
                            </tr>

                            <tr v-if="domains.data.length === 0">
                                <td colspan="4" class="text-center py-6 text-gray-500">
                                    No domains found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="p-4 flex justify-end gap-2">
                        <Link
                            v-for="link in domains.links"
                            :key="link.label"
                            :href="link.url"
                            v-html="link.label"
                            class="px-3 py-1 border rounded text-sm"
                            :class="{
                                'bg-indigo-600 text-white': link.active,
                                'text-gray-500 pointer-events-none': !link.url
                            }"
                        />
                    </div> -->

                </div>
            </div>
        </div>
    </AppLayout>
</template>