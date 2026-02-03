<template>
    <div class="bg-primary mx-2 hover:opacity-75 rounded-md">
        <button
            type="button"
            :disabled="loading || disabled"
            @click="onClick"
            class="flex items-center justify-center px-4 py-2 text-white font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <svg
            v-if="loading"
            class="animate-spin h-5 w-5 mr-2 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            >
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>

            <span>{{ label }}</span>
        </button>
    </div>
</template>

<script>
export default {
    name: "SaveButton",
    props: {
        label: {
            type: String,
            default: "Save"
        },
        loading: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    emits: ["click"],
    setup(props, { emit }) {
        const onClick = (event) => {
            if (!props.loading && !props.disabled) {
                emit("click", event);
            }
        };

        return { onClick };
    }
};
</script>