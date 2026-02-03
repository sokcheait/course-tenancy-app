<template>
    <div class="p-2 w-full relative">
        <label class="block mt-2 pb-2">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <div class="relative">
        <button
            type="button"
            @click="toggleDropdown"
            class="w-full text-left text-sm px-2 py-2 border rounded-md cursor-pointer
                focus:outline-none focus:ring-2 pr-10"
            :class="errors ? 'border-red-500 focus:ring-red-400' : 'border-gray-400 focus:ring-blue-400'"
        >
            <span>{{ selectedLabel || placeholder }}</span>
        </button>

        <!-- Clear + Dropdown Icons -->
        <div class="absolute inset-y-0 right-2 flex items-center space-x-1">
            <button
            v-if="selectedValue"
            @click.prevent="clearValue"
            class="text-gray-500 hover:text-gray-700"
            title="Clear"
            >
            ✕
            </button>
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <!-- Dropdown -->
        <ul
            v-if="open"
            class="absolute z-50 mt-1 w-full bg-white border rounded-md shadow-lg max-h-60 overflow-auto"
        >
            <li
            v-for="option in options"
            :key="option.value"
            @click="selectOption(option)"
            class="px-2 py-2 cursor-pointer hover:bg-blue-100"
            :class="option.value === selectedValue ? 'bg-blue-500 text-white' : ''"
            >
            {{ option.label }}
            </li>
        </ul>
        </div>

        <p v-if="errors" class="text-red-500 text-sm mt-1">{{ errors }}</p>
    </div>
</template>

<script>
import { ref, computed, watch } from "vue";

export default {
    props: {
        label: String,
        modelValue: [String, Number, null],
        options: {
            type: Array,
            default: () => [],
        },
        placeholder: {
            type: String,
            default: "Select an option",
        },
        required: { type: Boolean, default: false },
        errors: { type: String, default: "" },
    },
    emits: ["update:modelValue"],
    setup(props, { emit }) {
        const open = ref(false);
        const selectedValue = ref(props.modelValue);

        const selectedLabel = computed(() => {
            const selected = props.options.find((o) => o.value === selectedValue.value);
            return selected ? selected.label : "";
        });

        const toggleDropdown = () => {
            open.value = !open.value;
        };

        const selectOption = (option) => {
            selectedValue.value = option.value;
            emit("update:modelValue", option.value);
            open.value = false;
        };

        const clearValue = () => {
            selectedValue.value = null;
            emit("update:modelValue", null);
        };

        watch(() => props.modelValue, (val) => {
            selectedValue.value = val;
        });

        return { open, selectedValue, selectedLabel, toggleDropdown, selectOption, clearValue };
    },
};
</script>