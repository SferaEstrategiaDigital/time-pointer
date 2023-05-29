import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

export default function usePermissions() {
    const { props } = usePage();
    const permissions = ref([]);

    watchEffect(() => {
        // console.log(props);
        // if (props.value.auth && props.value.auth.permissions) {
        //     permissions.value = props.value.auth.permissions;
        // }
    });

    const hasPermission = (permissionName) => {
        // console.log(props.value);
        // console.log(permissions.value.includes(permissionName));
        // return permissions.value.includes(permissionName);
    };

    return {
        hasPermission,
    };
}
