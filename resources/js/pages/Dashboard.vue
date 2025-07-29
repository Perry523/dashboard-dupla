<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import ChartDashboard from '../components/ui/chart/ChartDashboard.vue';
import PixesStatusResume from '../components/ui/status/PixesStatusResume.vue';
import UsersStatusResume from '../components/ui/status/UsersStatusResume.vue';
import MsElapsedStatusResume from '../components/ui/status/MsElapsedStatusResume.vue';
import { toRaw } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface StatsFiltereds{
    total: number,
    paid: number,
    expired: number,
    generated: number,
    tempoDeExecucao: number
}

interface Props {
    usersCount: number,
    statsFiltered: StatsFiltereds
}

/*  const props = defineProps({
        usersCount: Number,
        statsFiltered: Array
}); */

const statssFiltered = withDefaults(defineProps<Props>(), {
    usersCount: () => 0,
    statsFiltered: undefined
}); 

const sf = toRaw(statssFiltered.statsFiltered);

/* console.log("chegou ");
console.log(statssFiltered.usersCount);
console.log("chegou statsFiltered");
console.log(toRaw(statssFiltered.statsFiltered));
console.log("chegou sf");
console.log(sf);
 */
const insightObj = {
    finalizados: sf.paid,
    pendentes: sf.generated,
    expirados: sf.expired
}

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid status-container auto-rows-min gap-4 md:grid-cols-3">
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PixesStatusResume :pixesCount="statssFiltered.statsFiltered.total"/>
                </div>
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <UsersStatusResume :usersCount="statssFiltered.usersCount" />
                </div>
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <MsElapsedStatusResume :timeElapsed="statssFiltered.statsFiltered.tempoDeExecucao"/>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <ChartDashboard :insight="insightObj"/>
            </div>
        </div>
    </AppLayout>
</template>
