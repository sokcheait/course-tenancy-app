<script setup>
import { router } from '@inertiajs/vue3'
import { reactive, watch } from 'vue'

const props = defineProps({
    routeName: {
        type: String,
        required: true
    },
    filters: {
        type: Array,
        default: () => []
    },
    values: {
        type: Object,
        default: () => ({})
    }
})

/* ---------------- STATE ---------------- */
const form = reactive({
    ...props.values
})

let timeout = null

/* ---------------- AUTO SEARCH ---------------- */
watch(form, (val) => {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
        router.get(route(props.routeName), val, {
            preserveState: true,
            replace: true,
            preserveScroll: true
        })
    }, 400)
}, { deep:true })

/* ---------------- RESET ---------------- */
function resetFilter(){
    Object.keys(form).forEach(k => form[k] = '')
}
</script>

<template>
	<div class="flex flex-wrap gap-2 items-center">
	    <!-- LOOP FILTER -->
	    <template v-for="f in filters" :key="f.key">

	        <!-- SEARCH -->
	        <input
	            v-if="f.type==='search'"
	            v-model="form[f.key]"
	            type="text"
	            :placeholder="f.label || 'Search...'"
	            class="border px-3 py-2 rounded-md text-sm w-64"
	        />

	        <!-- TEXT -->
	        <input
	            v-else-if="f.type==='text'"
	            v-model="form[f.key]"
	            type="text"
	            :placeholder="f.label"
	            class="border px-3 py-2 rounded-md text-sm"
	        />

	        <!-- SELECT -->
	        <select
	            v-else-if="f.type==='select'"
	            v-model="form[f.key]"
	            class="border pl-4 pr-6 py-2 rounded-md text-sm"
	        >
	            <option value="">All {{ f.label }}</option>
	            <option
	                v-for="opt in f.options"
	                :key="opt.value"
	                :value="opt.value"
	            >
	                {{ opt.label }}
	            </option>
	        </select>

	        <!-- DATE -->
	        <input
	            v-else-if="f.type==='date'"
	            type="date"
	            v-model="form[f.key]"
	            class="border px-3 py-2 rounded-md text-sm"
	        />

	    </template>

	    <!-- RESET -->
	    <button
	        @click="resetFilter"
	        class="px-3 py-2 bg-gray-200 rounded text-sm hover:bg-gray-300"
	    >
	        Reset
	    </button>

	    <!-- SLOT RIGHT -->
	    <slot />
	</div>
</template>