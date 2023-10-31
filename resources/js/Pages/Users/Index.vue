<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import CardBox from "@/Components/CardBox.vue";
import {
    Table,
    setTranslations,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

import {
    mdiAccountGroup,
    mdiFileSearch,
    mdiPlusCircleMultipleOutline,
    mdiClose,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";
import CardBoxModal from "@/components/CardBoxModal.vue";
import CardBoxComponentTitle from "@/components/CardBoxComponentTitle.vue";

defineProps(["users"]);
const formStatusWithHeader = ref(true);
setTranslations({
    next: "Next",
    no_results_found: "No results found",
    per_page: "per page",
    previous: "Prev",
    results: "",
    of: "",
    to: "",
});

const modalOneActive = ref(false);
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Users" />
        <CardBoxModal
            v-model="modalOneActive"
            title="Please confirm action"
            button-label="Confirm"
            has-cancel
        >
            <p>This is sample modal</p>
            <p>Lorem ipsum dolor</p>
        </CardBoxModal>

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                title="Pengguna"
            />

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

                <CardBox
                    class="cursor-pointer md:w-7/12 lg:w-5/12 shadow-2xl md:mx-auto"
                    is-hoverable
                    @click="modalOneActive = true"
                >
                    <CardBoxComponentTitle title="Please confirm action">
                        <BaseButton
                            :icon="mdiClose"
                            color="whiteDark"
                            small
                            rounded-full
                        />
                    </CardBoxComponentTitle>
                    <div class="space-y-3">
                        <p>Click to see in action</p>
                    </div>

                    <template #footer>
                        <BaseButtons>
                            <BaseButton label="Confirm" color="info" />
                            <BaseButton label="Cancel" color="info" outline />
                        </BaseButtons>
                    </template>
                </CardBox>

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

                        <a
                            :href="`/users/${user.id}/edit`"
                            class="p-2 bg-red-600 text-white rounded"
                        >
                            Hapus
                        </a>
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
