<script setup lang="ts">
import AppStatusResume from './AppStatusResume.vue';
import { receiveStatusResume } from './index';

const statusType = 'USERS', // This can be 'PIXES', 'USERS', or 'MSELAPSED'
iconName = 'Users';

let usersResumeValue = receiveStatusResume(statusType).toString();

</script>

<template>
    <div class="status-card flex justify-center">
        <AppStatusResume
            :statusType="statusType"
            :iconName="iconName"
            :value="usersResumeValue"/>
    </div>
</template>