<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
    domains: Object
})

</script>

<template>
    <AppLayout title="Domain">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Domain
            </h2>
            <Link :href="route('domains.create')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none">
                + Create Domain
            </Link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
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
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>