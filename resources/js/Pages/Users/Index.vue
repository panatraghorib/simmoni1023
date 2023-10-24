<script setup>
import { Head } from "@inertiajs/vue3";
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/stores/main";
import CardBox from "@/Components/CardBox.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

import {
    mdiAccountMultiple,
    mdiCartOutline,
    mdiChartTimelineVariant,
    mdiMonitorCellphone,
    mdiReload,
    mdiGithub,
    mdiChartPie,
    mdiAccountGroup,
} from "@mdi/js";
import * as chartConfig from "@/Components/Charts/chart.config.js";
import LineChart from "@/Components/Charts/LineChart.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import TableSampleClients from "@/Components/TableSampleClients.vue";
import NotificationBar from "@/Components/NotificationBar.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardBoxTransaction from "@/Components/CardBoxTransaction.vue";
import CardBoxClient from "@/Components/CardBoxClient.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/Components/SectionBannerStarOnGitHub.vue";

defineProps(["users"]);

const chartData = ref(null);

const fillChartData = () => {
    chartData.value = chartConfig.sampleChartData();
};

onMounted(() => {
    fillChartData();
});

const mainStore = useMainStore();

const clientBarItems = computed(() => mainStore.clients.slice(0, 4));

const transactionBarItems = computed(() => mainStore.history);
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Dashboard" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiAccountGroup" title="Users">
                <BaseButton
                    href="https://github.com/justboil/admin-one-vue-tailwind"
                    target="_blank"
                    :icon="mdiGithub"
                    label="Star on GitHub"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox has-table>
                <Table
                    :resource="users"
                    :striped="true"
                    :prevent-overlapping-requests="false"
                    :input-debounce-ms="1000"
                    :preserve-scroll="true"
                >
                    <template #cell(actions)="{ item: user }">
                        <a
                            :href="`/users/${user.id}/edit`"
                            class="p-2 bg-blue-500 text-white"
                        >
                            Edit
                        </a>
                    </template>
                </Table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
