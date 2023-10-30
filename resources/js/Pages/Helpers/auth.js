import { usePage } from "@inertiajs/vue3";

export const can = (permission) => {
    const page = usePage();
    const adminRole = page.props.user.permissions.includes("Superadmin");

    if (!adminRole) {
        if (permission && page.props.user.permissions.includes(permission)) {
            return true;
        }

        return false;
    }
};
