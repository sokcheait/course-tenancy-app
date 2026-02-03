<template>
    <div class="p-2 w-full">
        <label class="mt-2 pb-2 block">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <div class="relative">
            <span v-if="errors" class="absolute inset-y-0 right-2 flex items-center pl-3">
                <ExclamationCircleIcon class="h-5 w-5 text-red-500" />
            </span>
            <input 
                :type="type"
                :value="modelValue"
                @input="handleInput"
                :placeholder="placeholder"
                class="w-full text-sm px-2 py-2 border-gray-400 rounded-md"
                :class="{ 'border-red-500': errors }" 
            />
        </div>
        <p v-if="errors" class="text-red-500 text-sm">{{ errors }}</p>
    </div>
</template>
<script>
import { ExclamationCircleIcon } from '@heroicons/vue/24/outline';
    export default {
        components: {
            ExclamationCircleIcon
        },
        props: {
            label: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'text'
            },
            modelValue: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            errors: {
                type: String,
                default: ''
            },
            required: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                emits: ["update:modelValue"],
            };
        },
        methods: {
            handleInput(event) {
                const value = event.target.value;
                this.$emit('update:modelValue', value);
            },
        }
    };
</script>