<script setup>
import { ref, computed, watch } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import CardBox from "@/Components/CardBox.vue";
import {
    Table,
    setTranslations,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

import {
    mdiAccountGroup,
    mdiFileSearch,
    mdiPlusCircleMultipleOutline,
    mdiDeleteCircleOutline,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import { useToast, TYPE } from "vue-toastification";

defineProps(["users"]);

const formStatusWithHeader = ref(true);
setTranslations({
    next: "Next",
    no_results_found: "No results found",
    per_page: "/page",
    previous: "Prev",
    results: "",
    of: "",
    to: "",
});

const page = usePage();
const toast = useToast();

// console.log(usePage().props.flash);
watch(
    () => usePage().props.flash,
    (flash) => {
        console.log(flash.message.type);
        let toastId = null;

        switch (flash.message.type) {
            case "success":
                toastId = toast({
                    component: ToastNotification,
                    props: { type: TYPE.SUCCESS, title: flash.message.text },
                });
                break;
            case "error":
                toastId = toast({
                    component: ToastNotification,
                    props: { type: TYPE.ERROR, title: flash.message.text },
                });
                break;
            default:
                toastId = toast({
                    component: ToastNotification,
                    props: { type: TYPE.DEFAULT, title: flash.message.text },
                });
                break;
        }

        // if (flash.message.type.default) {
        //     toastId = toast({
        //         component: ToastNotification,
        //         props: { type: TYPE.DEFAULT, title: flash.message.text },
        //     });
        // }
        // if (flash.message.type.success) {
        //     toastId = toast({
        //         component: ToastNotification,
        //         props: { type: TYPE.SUCCESS, title: flash.message.text },
        //     });
        // }
        // if (flash.message.type.error) {
        //     toastId = toast({
        //         component: ToastNotification,
        //         props: { type: TYPE.ERROR, title: flash.message.text },
        //     });
        // }

        if (toastId !== null) {
            setTimeout(() => toast.dismiss(toastId), 5000);
        }
    },
    { deep: true }
);

const confirmDeleteModal = ref(false);

const confirmDelete = (id) => {
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
            title: "Do you want to Delete user?",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: `Batal`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                router.delete(`users/delete/${id}`);
                // swalButtons.fire("Deleted!", "", "success");
            }
            // else if (
            //     /* Read more about handling dismissals below */
            //     result.dismiss === swalButtons.DismissReason.cancel
            // ) {
            //     swalButtons.fire(
            //         "Cancelled",
            //         "Your imaginary file is safe :)",
            //         "error"
            //     );
            // }
        });
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Users" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                title="Pengguna"
            />

            <div v-if="$page.props.toast">dd</div>

            <NotificationBarInCard
                v-if="$page.props.flash.message"
                :color="$page.props.flash.message.type"
                :is-placed-with-header="formStatusWithHeader"
            >
                <span>
                    <b class="capitalize">
                        {{ $page.props.flash.message.text }}
                    </b>
                </span>
            </NotificationBarInCard>

            <CardBox has-outline>
                <BaseButton
                    route-name="user.create"
                    color="bg-blue-700"
                    label="Tambah data"
                    class="text-white"
                    :icon="mdiPlusCircleMultipleOutline"
                    small
                />

                <BaseDivider />

                <!-- <Table
                    :meta="users"
                    :striped="true"
                    :prevent-overlapping-requests="false"
                    :input-debounce-ms="1000"
                    preserve-scroll="table-top"
                >
                    <template v-slot:tableGlobalSearch="slotProps">
                        <div class="flex flex-row w-full">
                            <div
                                class="relative text-gray-600 focus-within:text-gray-400 w-full"
                            >
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-2 pt-3"
                                >
                                    <BaseIcon
                                        :path="mdiFileSearch"
                                        class="w-6 h-6"
                                    />
                                </span>
                                <input
                                    placeholder="pencarian global..."
                                    @input="
                                        slotProps.onChange($event.target.value)
                                    "
                                    class="mt-2 block w-full pl-9 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300"
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                    </template>
                    <template #head>
                        <tr>
                            <th>User</th>
                        </tr>
                    </template>

                    <template #body>
                        <tr v-for="(user, key) in users.data" :key="key">
                            <td>{{ user.name }}</td>
                            <td>
                                <a
                                    :href="`/users/${user.id}/edit`"
                                    class="p-2 bg-blue-500 text-white"
                                >
                                    Edit
                                </a>
                            </td>
                        </tr>
                    </template>
                </Table> -->

                <Table
                    :resource="users"
                    :striped="true"
                    :prevent-overlapping-requests="false"
                    :input-debounce-ms="1000"
                    preserve-scroll="table-top"
                >
                    <template v-slot:tableGlobalSearch="slotProps">
                        <div class="flex flex-row w-full">
                            <div
                                class="relative text-gray-600 focus-within:text-gray-400 w-full"
                            >
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-2 pt-3"
                                >
                                    <BaseIcon
                                        :path="mdiFileSearch"
                                        class="w-6 h-6"
                                    />
                                </span>
                                <input
                                    placeholder="pencarian global..."
                                    @input="
                                        slotProps.onChange($event.target.value)
                                    "
                                    class="mt-2 block w-full pl-9 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300"
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                    </template>

                    <template #cell(actions)="{ item: user }">
                        <BaseButton
                            :inertia-link="`/users/${user.id}/edit`"
                            color="bg-blue-700"
                            label="Edit"
                            class="text-white"
                            :icon="mdiPlusCircleMultipleOutline"
                            small
                        />
                        <BaseButton
                            as="button"
                            color="bg-red-600"
                            label="Hapus"
                            class="text-white"
                            :icon="mdiDeleteCircleOutline"
                            small
                            @click="confirmDelete(user.id)"
                        />
                    </template>

                    <!-- <template #sort>
                        <svg
                            v-if="cell.sortable"
                            aria-hidden="true"
                            class="w-3 h-3 ml-2"
                            :class="{
                                'text-gray-400': !cell.sorted,
                                'text-green-500': cell.sorted,
                            }"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 320 512"
                            :sorted="cell.sorted"
                        >
                            <path
                                v-if="!cell.sorted"
                                fill="currentColor"
                                d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"
                            />

                            <path
                                v-if="cell.sorted === 'asc'"
                                fill="currentColor"
                                d="M279 224H41c-21.4 0-32.1-25.9-17-41L143 64c9.4-9.4 24.6-9.4 33.9 0l119 119c15.2 15.1 4.5 41-16.9 41z"
                            />

                            <path
                                v-if="cell.sorted === 'desc'"
                                fill="currentColor"
                                d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z"
                            />
                        </svg>
                    </template> -->

                    <!-- <template #tableWrapper>
                        <div class="flex flex-col">
                            <div
                                class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"
                            >
                                <div
                                    class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
                                >
                                    <div
                                        class="shadow border-b border-gray-200 relative"
                                    >
                                        <slot />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template> -->
                    <!-- <template #head>
                        <tr
                            class="font-medium text-xs uppercase text-left tracking-wider text-gray-500 py-3 px-6"
                        ></tr>
                    </template> -->
                    <template #pagination> </template>
                </Table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
