<script setup lang="ts">
import AppStatusResume from './AppStatusResume.vue';
import { receiveStatusResume } from './index';

const statusType = 'MSELAPSED', // This can be 'PIXES', 'USERS', or 'MSELAPSED'
iconName = 'Clock';

let msResumeValue =  receiveStatusResume(statusType);
let formattedMsResumeValue = `${msResumeValue / 1000} s`;

</script>

<template>
    <div class="status-card flex justify-center">
        <AppStatusResume
            :statusType="statusType"
            :iconName="iconName"
            :value="formattedMsResumeValue"/>
    </div>
</template>