<template>
    <label class="p-2 w-full cursor-pointer">
        <span class="block mt-2 pb-4">{{ label }} <span v-if="required" class="text-red-500">*</span></span>
        <div class="relative">
            <input 
                type="checkbox" 
                class="sr-only peer" 
                :checked="modelValue" 
                @change="onChange"
            />
            <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-green-600 transition-colors duration-300"></div>
            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all duration-300 peer-checked:left-6"></div>
        </div>
    </label>
    <p v-if="errors" class="text-red-500 text-sm mt-1">{{ errors }}</p>
</template>

<script>
import { watch } from "vue";

export default {
    name: "ToggleSwitch",
    props: {
        modelValue: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ""
        },
        required: {
            type: Boolean,
            default: false
        },
        errors: {
            type: String,
            default: ""
        }
    },
    emits: ["update:modelValue"],
    setup(props, { emit }) {
        const onChange = (event) => {
            emit("update:modelValue", event.target.checked);
        };
        // watch(() => props.modelValue, (newVal) => {
        //     console.log("Toggle value changed:", newVal);
        // });

        return { onChange };
    }
};
</script>