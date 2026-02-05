<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
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
    }
})
</script>

<template>
    <div class="w-full">
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
        <div v-if="links.length" class="p-4 flex justify-end gap-2">
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
</template>