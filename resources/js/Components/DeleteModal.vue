<script setup>
import { computed } from "vue";
import { mdiClose } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import OverlayLayer from "@/Components/OverlayLayer.vue";
import CardBoxComponentTitle from "@/Components/CardBoxComponentTitle.vue";
import Swal from "sweetalert2";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    button: {
        type: String,
        default: "info",
    },
    buttonLabel: {
        type: String,
        default: "Done",
    },
    hasCancel: Boolean,
    modelValue: {
        type: [String, Number, Boolean],
        default: null,
    },
});

const emit = defineEmits(["update:modelValue", "cancel", "confirm"]);

const value = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const confirmCancel = (mode) => {
    value.value = false;
    emit(mode);
};

const confirm = () => confirmCancel("confirm");

const cancel = () => confirmCancel("cancel");

window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && value.value) {
        cancel();
    }
});

if (value.value == true) {
    const swalButtons = Swal.mixin({
        customClass: {
            confirmButton:
                "text-gray-900 w-28 bg-red-400 border border-gray-300 focus:outline-none hover:bg-red-700 hover:text-white focus:ring-1 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700",
            cancelButton:
                "text-gray-900 w-28 bg-gray-300 border border-gray-300 focus:outline-none hover:bg-gray-400 hover:text-white focus:ring-1 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700",
        },
        buttonsStyling: false,
    });
    swalButtons
        .fire({
            title: title,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: `Batal`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                const store = useLaporanStore();
                store.delete(this.row.id);
                this.$emit("itemDeleted", "data.deleted");
                swalButtons.fire("Deleted!", "", "success");
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === swalButtons.DismissReason.cancel
            ) {
                swalButtons.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                );
            }
        });
}
</script>

<template></template>
