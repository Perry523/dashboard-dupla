<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gerar Cobrança Pix',
        href: '/GeneratePixCharge',
    },
];
</script>

<template>
    <Head title="GeneratePixCharge" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid status-container auto-rows-min gap-4 md:grid-cols-3">
                <!-- Add your components for Pix Charge generation here -->
                <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <!-- Example component for Pix Charge generation -->
                    <h2 class="text-lg font-semibold">Pix Charge Generation</h2>
                    <!-- Add form or components to generate Pix charge -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
