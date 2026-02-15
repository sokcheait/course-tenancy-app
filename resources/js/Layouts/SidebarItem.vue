<template>
    <Link 
        v-if="can(redirect) || is_superAdmin() || redirect ==='dashboard'"
        :href="href" preserve-state
        class="flex items-center p-2 rounded-md transition-colors
               text-gray-500 dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
        :class="{ 'bg-primary-100 dark:bg-primary': active }"
    >
        <component :is="heroIcons[icon]" class="w-5 h-5" />
        <span class="ml-2 text-sm">{{ title }}</span>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import * as heroIcons from '@heroicons/vue/24/outline';
defineProps({
    title: String,
    href: String,
    redirect: String,
    icon: String,
    active: {
        type: Boolean,
        default: false
    }
});

</script>