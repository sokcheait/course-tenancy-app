<template>
    <div class="">
        <h2 class="font-bold mb-2">Select Permissions</h2>
        <div v-for="(modules, role) in permissions" :key="role" class="mb-4 border p-2 rounded">
            <div class="font-bold mb-2 text-lg">{{ role }}</div>
            <div class="grid md:grid-cols-3 gap-4 p-3">
                <div v-for="(items, module) in modules" :key="module" class="mb-2 shadow p-2">
                    <label class="flex items-center space-x-2 font-medium">
                        <input
                            type="checkbox"
                            :checked="isModuleChecked(role, module)"
                            :indeterminate.prop="isModuleIndeterminate(role, module)"
                            @change="toggleModule(role, module, $event.target.checked)"
                            class="form-checkbox h-4 w-4"
                        />
                        <span>{{ module }}</span>
                    </label>

                      <!-- Child permissions checkboxes -->
                    <div class="ml-6 mt-1">
                        <label
                            v-for="(permName, permKey) in items"
                            :key="permKey"
                            class="flex items-center space-x-2"
                        >
                            <input
                                type="checkbox"
                                :value="permFullName(role, module, permKey)"
                                v-model="selectedPermissions"
                                class="form-checkbox h-4 w-4"
                            />
                            <span>{{ permName }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PermissionSelector",
    props: {
        permissions: {
            type: Object,
            default: () => []
        },
        modelValue: {
            type: Object,
            default: () => []
        }
    },
    data() {
        return {
            selectedPermissions: Array.isArray(this.modelValue) ? this.modelValue : []
        };
    },
    mounted() {
        this.selectedPermissions = Array.isArray(this.modelValue) ? this.modelValue : [];
    },
    watch: {
        selectedPermissions(newVal) {
            this.$emit("update:modelValue", newVal);
        },
        modelValue(newVal) {
            this.selectedPermissions = Array.isArray(newVal) ? newVal : [];
        }
    },
    methods: {
        permFullName(role, module, permKey) {
            // If permKey already contains module name, just prefix role
            if (permKey.startsWith(module + ".")) return `${role}.${permKey}`;

            // If permKey equals module name or is unique (like 'dashboard'), just role.permKey
            if (permKey === module || module.includes(permKey)) return `${role}.${permKey}`;

            // Default: role.module.permKey
            return `${role}.${module}.${permKey}`;
        },
        isModuleChecked(role, module) {
            const perms = this.permissions[role][module];
            const all = Object.keys(perms).map(perm => this.permFullName(role, module, perm));
            return all.every(p => this.selectedPermissions.includes(p));
        },
        isModuleIndeterminate(role, module) {
            const perms = this.permissions[role][module];
            const all = Object.keys(perms).map(perm => this.permFullName(role, module, perm));
            const selectedCount = all.filter(p => this.selectedPermissions.includes(p)).length;
            return selectedCount > 0 && selectedCount < all.length;
        },
        toggleModule(role, module, checked) {
            const perms = this.permissions[role][module];
            const all = Object.keys(perms).map(perm => this.permFullName(role, module, perm));
            if (checked) {
                this.selectedPermissions = Array.from(new Set([...this.selectedPermissions, ...all]));
            } else {
                this.selectedPermissions = this.selectedPermissions.filter(p => !all.includes(p));
            }
        }
    }
};
</script>