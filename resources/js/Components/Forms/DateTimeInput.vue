<template>
    <div class="p-2 w-full relative">
        <label class="block mt-2 pb-2">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
        </label>

        <!-- Input -->
        <div class="relative">
            <input
                type="text"
                :value="displayValue"
                @focus="open = true"
                readonly
                class="w-full text-sm px-2 py-2 border rounded-md cursor-pointer
                    focus:outline-none focus:ring-2 pr-10"
                :class="errors ? 'border-red-500 focus:ring-red-400' : 'border-gray-400 focus:ring-blue-400'"
            />

        <!-- Icons -->
        <span class="absolute inset-y-0 right-2 flex items-center space-x-1">
            <!-- Clear Button -->
            <button
                v-if="displayValue"
                @click.prevent="clearValue"
                class="text-gray-500 hover:text-gray-700"
                title="Clear">
                ✕
            </button>

            <!-- Error Icon -->
            <ExclamationCircleIcon v-if="errors" class="h-5 w-5 text-red-500" />
            <!-- Calendar Icon -->
            <svg v-else class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </span>
        </div>

        <!-- Dropdown -->
        <div v-if="open" class="absolute z-50 mt-1 bg-white border rounded-lg shadow-lg p-2 w-full">
        <!-- Calendar -->
        <div v-if="showDate" class="grid grid-cols-7 gap-1 text-center">
            <div v-for="day in days" :key="day" class="font-bold">{{ day }}</div>
            <div
            v-for="date in calendarDates"
            :key="date.key"
            @click="selectDate(date.date)"
            class="p-2 rounded cursor-pointer hover:bg-blue-100"
            :class="date.isSelected ? 'bg-blue-500 text-white' : ''"
            >
            {{ date.day }}
            </div>
        </div>

        <!-- Time Picker -->
        <div v-if="showTime" class="mt-2 flex gap-2 items-center justify-center">
            <input type="number" v-model.number="hour" min="0" max="23" class="w-16 text-center border rounded px-1 py-0.5"/>
            :
            <input type="number" v-model.number="minute" min="0" max="59" class="w-16 text-center border rounded px-1 py-0.5"/>
            <button @click="selectTime" class="bg-blue-500 text-white px-2 py-1 rounded">Set</button>
        </div>
        </div>

        <p v-if="errors" class="text-red-500 text-sm mt-1">{{ errors }}</p>
    </div>
</template>

<script>
import { ref, computed, watch } from "vue";
import { ExclamationCircleIcon } from "@heroicons/vue/24/outline";

export default {
    components: { ExclamationCircleIcon },
    props: {
        label: String,
        modelValue: String,
        mode: {
            type: String,
            default: "datetime", // date | time | datetime
            validator: (v) => ["date", "time", "datetime"].includes(v),
        },
        format: { type: String, default: "" }, // custom format string
        required: { type: Boolean, default: false },
        errors: { type: String, default: "" },
    },
    emits: ["update:modelValue"],
    setup(props, { emit }) {
        const open = ref(false);
        const selectedDate = ref(props.modelValue ? new Date(props.modelValue) : null);
        const hour = ref(selectedDate.value ? selectedDate.value.getHours() : 0);
        const minute = ref(selectedDate.value ? selectedDate.value.getMinutes() : 0);

        const days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

        const showDate = computed(() => props.mode === "date" || props.mode === "datetime");
        const showTime = computed(() => props.mode === "time" || props.mode === "datetime");

        const calendarDates = computed(() => {
        const date = selectedDate.value || new Date();
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const dates = [];
        for(let i=0;i<firstDay;i++) dates.push({day:"",key:`empty-${i}`,date:null,isSelected:false});
        for(let d=1;d<=daysInMonth;d++){
            const current = new Date(year, month, d);
            dates.push({
                day:d,
                key:`day-${d}`,
                date:current,
                isSelected:selectedDate.value && current.toDateString()===selectedDate.value.toDateString()
            });
        }
        return dates;
        });

        const displayValue = computed(() => {
        if(!selectedDate.value) return "";
        const y = selectedDate.value.getFullYear();
        const m = String(selectedDate.value.getMonth()+1).padStart(2,"0");
        const d = String(selectedDate.value.getDate()).padStart(2,"0");
        const h = String(selectedDate.value.getHours()).padStart(2,"0");
        const min = String(selectedDate.value.getMinutes()).padStart(2,"0");

        if(props.format){
            return props.format
            .replace("YYYY", y)
            .replace("MM", m)
            .replace("DD", d)
            .replace("HH", h)
            .replace("mm", min);
        }

        if(props.mode==="date") return `${y}-${m}-${d}`;
        if(props.mode==="time") return `${h}:${min}`;
        return `${y}-${m}-${d} ${h}:${min}`;
        });

        const selectDate = (date) => {
            if(!date) return;
            selectedDate.value = new Date(date);
            if(!showTime.value){
                emit("update:modelValue", displayValue.value);
                open.value = false;
            }
        };

        const selectTime = () => {
        if(!selectedDate.value) selectedDate.value = new Date();
        selectedDate.value.setHours(hour.value);
        selectedDate.value.setMinutes(minute.value);
        emit("update:modelValue", displayValue.value);
        open.value = false;
        };

        const clearValue = () => {
        selectedDate.value = null;
        hour.value = 0;
        minute.value = 0;
        emit("update:modelValue", "");
        };

        watch(()=>props.modelValue,(val)=>{
        selectedDate.value = val ? new Date(val) : null;
        if(selectedDate.value){
            hour.value = selectedDate.value.getHours();
            minute.value = selectedDate.value.getMinutes();
        }
        });

        return { open, calendarDates, days, selectDate, displayValue, hour, minute, selectTime, showDate, showTime, clearValue };
    },
};
</script>