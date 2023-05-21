import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

export default function usePermissions() {
    const page = usePage();
    const permissions = ref([]);

    watchEffect(() => {
        permissions.value = page.props.permissions;
    });

    const hasPermission = (permissionName) => {
        return permissions.value.includes(permissionName);
    };

    return {
        hasPermission,
    };
}
