<template>
    <div class="mx-2 rounded-md bg-rose-600 text-white hover:bg-rose-700 block">
        <button
            type="button"
            @click="goBack"
            class="flex items-center px-4 py-2 font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span>{{ label }}</span>
        </button>
    </div>
</template>

<script>
export default {
    name: "BackButton",
    props: {
        label: {
        type: String,
        default: "Back",
        },
        disabled: {
        type: Boolean,
        default: false,
        },
    },
    setup(props) {
        const goBack = () => {
        if (!props.disabled) {
            window.history.back();
        }
        };

        return { goBack };
    },
};
</script>