<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import ChartDashboard from '../components/ui/chart/ChartDashboard.vue';
import PixesStatusResume from '../components/ui/status/PixesStatusResume.vue';
import UsersStatusResume from '../components/ui/status/UsersStatusResume.vue';
import MsElapsedStatusResume from '../components/ui/status/MsElapsedStatusResume.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid status-container auto-rows-min gap-4 md:grid-cols-3">
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PixesStatusResume />
                </div>
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <UsersStatusResume />
                </div>
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <MsElapsedStatusResume />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <ChartDashboard />
            </div>
        </div>
    </AppLayout>
</template>
