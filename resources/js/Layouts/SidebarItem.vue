<template>
    <a
        :href="href"
        class="flex items-center p-2 rounded-md transition-colors
               text-gray-500 dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
        :class="{ 'bg-primary-100 dark:bg-primary': active }"
    >
        <component :is="icon" class="w-5 h-5" />
        <span class="ml-2 text-sm">{{ title }}</span>
    </a>
</template>

<script setup>
defineProps({
    title: String,
    href: String,
    icon: Object,
    active: {
        type: Boolean,
        default: false
    }
})
</script>