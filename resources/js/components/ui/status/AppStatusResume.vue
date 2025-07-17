<script setup lang="ts">
import { stylizeStatusType } from './index';

interface AppStatusResumeProps {
    statusType: 'PIXES'|'USERS'|'MSELAPSED'| string;
    iconName?: string;
    title?: string;
    value?: string;
}
let props = withDefaults(defineProps<AppStatusResumeProps>(), {
    title: 'Status',
    statusType: 'PIXES',
    iconName: 'CreditCard',
    value: '0',
});

let stylizedStatusType = stylizeStatusType(props.statusType);

</script>

<template>
    <div class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
        <!--<Icon />-->
        <span class="text-lg font-semibold">{{ stylizedStatusType }}</span>
        <span class="status-value font-bold">{{ value }}</span>
    </div>
</template>