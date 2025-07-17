<script setup lang="ts">
import AppStatusResume from './AppStatusResume.vue';
import { receiveStatusResume } from './index';

const statusType = 'PIXES', // This can be 'PIXES', 'USERS', or 'MSELAPSED'
iconName = 'Coins';

let pixesResumeValue = receiveStatusResume(statusType).toString();

</script>

<template>
    <div class="status-card flex justify-center">
        <AppStatusResume
            :statusType="statusType"
            :iconName="iconName"
            :value="pixesResumeValue"/>
    </div>
</template>