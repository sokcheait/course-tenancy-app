<template>
    <span
        :class="[
            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
            item.is_active
                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
        ]"
    >
        <span
            :class="[
                'mr-1.5 h-2 w-2 rounded-full',
                item.is_active ? 'bg-green-500' : 'bg-red-500'
            ]"
        ></span>

        {{ item.is_active ? 'Active' : 'Inactive' }}
    </span>
</template>
<script>
export default {
    name: "StatusBadge",
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
};
</script>