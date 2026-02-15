<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import DataFilter from './DataFilter.vue'

const props = defineProps({
    columns: {
        type: Array,
        required: true,
        // Example:
        // [
        //   { label: '#', key: 'index' },
        //   { label: 'Domain', key: 'domain' },
        //   { label: 'Created', key: 'created_at' }
        // ]
    },
    rows: {
        type: Array,
        required: true
    },
    links: {
        type: Array,
        default: () => []
    },
    emptyText: {
        type: String,
        default: 'No data found.'
    },
    search: {
        type: String,
        default: ''
    },
    routeName: {
        type: String,
        default: ''
    },
    filters: { 
        type:Array, 
        default:()=>[] 
    },
    filterValues: { 
        type:Object, 
        default:()=>({}) 
    },
})
const searchText = ref(props.search || '')

let timeout = null

watch(searchText, (val) => {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
        router.get(route(props.routeName), {
            search: val
        }, {
            preserveState: true,
            replace: true,
            preserveScroll: true
        })
    }, 400)
})

</script>

<template>
    <div class="w-full">
        <div class="flex justify-between items-center mb-3">
            <DataFilter
                v-if="filters.length"
                :routeName="routeName"
                :filters="filters"
                :values="form"
            />
            <input
                v-model="searchText"
                type="text"
                placeholder="Search..."
                class="border px-3 py-2 rounded-md text-sm w-72 focus:ring-2 focus:ring-blue-400"
            />
        </div>

        <!-- Table -->
        <table class="min-w-full divide-y divide-gray-200">
            <!-- Head -->
            <thead class="bg-gray-50">
                <tr>
                    <th
                        v-for="col in columns"
                        :key="col.key"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                    >
                        {{ col.label }}
                    </th>

                    <!-- Action column -->
                    <th v-if="$slots.actions"
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                        Action
                    </th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(row, index) in rows" :key="row.id ?? index">
                    
                    <!-- LOOP COLUMN -->
                    <td
                        v-for="col in columns"
                        :key="col.key"
                        class="px-6 py-4 text-sm text-gray-600"
                    >
                        <!-- INDEX -->
                        <template v-if="col.key === 'index'">
                            {{ index + 1 }}
                        </template>

                        <!-- CUSTOM SLOT COLUMN -->
                        <template v-else-if="$slots[col.key]">
                            <slot :name="col.key" :row="row" :value="row[col.key]" :index="index" />
                        </template>

                        <!-- FORMATTER -->
                        <template v-else-if="col.formatter">
                            {{ col.formatter(row[col.key], row) }}
                        </template>

                        <!-- DEFAULT -->
                        <template v-else>
                            {{ row[col.key] }}
                        </template>
                    </td>

                    <!-- ACTION SLOT -->
                    <td v-if="$slots.actions"
                        class="px-6 py-4 text-right text-sm">
                        <slot name="actions" :row="row" :index="index" />
                    </td>
                </tr>

                <!-- EMPTY -->
                <tr v-if="rows.length === 0">
                    <td :colspan="columns.length + ($slots.actions ? 1 : 0)"
                        class="text-center py-6 text-gray-400">
                        {{ emptyText }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->

        <div v-if="links.length" class="p-4 flex items-center justify-between">

            

            <div class="text-sm text-gray-500">
                Page {{ $page.props.meta?.current_page }} of {{ $page.props.meta?.last_page }}
                • Showing {{ $page.props.meta?.from }}-{{ $page.props.meta?.to }} of {{ $page.props.meta?.total }}
            </div>

            <!-- RIGHT: LINKS -->
            <div class="flex gap-2">
                <Link
                    v-for="link in links"
                    :key="link.label"
                    :href="link.url || ''"
                    v-html="link.label"
                    class="px-3 py-1 border rounded text-sm"
                    :class="{
                        'bg-primary text-white': link.active,
                        'text-gray-400 pointer-events-none': !link.url
                    }"
                />
            </div>
        </div>
    </div>
</template>