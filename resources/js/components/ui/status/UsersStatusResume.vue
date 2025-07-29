<script setup lang="ts">
import AppStatusResume from './AppStatusResume.vue';
import { receiveStatusResume } from './index';

interface Props {
    usersCount?: Number;
}

const props = withDefaults(defineProps<Props>(), {
  usersCount: () => 0,
});

const statusType = 'USERS', // This can be 'PIXES', 'USERS', or 'MSELAPSED'
iconName = 'Users';

/* let usersResumeValue = receiveStatusResume(statusType).toString(); */

let usersResumeValue = props.usersCount.toString();

</script>

<template>
    <div class="status-card flex justify-center">
        <AppStatusResume
            :statusType="statusType"
            :iconName="iconName"
            :value="usersResumeValue"/>
    </div>
</template>