<template>
    <div>
        <a
            href="#"
            @click.prevent="toggle"
            class="flex items-center p-2 rounded-md transition-colors
                   text-gray-500 dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
            :class="{ 'bg-primary-100 dark:bg-primary': active || open }"
        >
            <component :is="heroIcons[icon]" class="w-5 h-5" />
            <span class="ml-2 text-sm">{{ title }}</span>

            <ChevronDownIcon
                class="w-4 h-4 ml-auto transition-transform"
                :class="{ 'rotate-180': open }"
            />
        </a>

        <div v-show="open" class="mt-2 space-y-2 px-7">
            <Link
                v-for="(item, i) in items"
                :key="i"
                :href="item.href"
                class="block p-2 text-sm rounded-md transition-colors"
                :class="item.disabled
                    ? 'text-gray-400 cursor-not-allowed'
                    : 'text-gray-700 dark:text-light hover:text-gray-700 dark:hover:text-light'"
            >
                {{ item.label }}
            </Link>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { ChevronDownIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/inertia-vue3'
import * as heroIcons from '@heroicons/vue/24/outline';

const props = defineProps({
    title: String,
    icon: Object,
    items: Array,
    active: Boolean
})

const open = ref(props.active)

const toggle = () => {
    open.value = !open.value
}
</script>