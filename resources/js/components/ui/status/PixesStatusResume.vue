<script setup lang="ts">
import AppStatusResume from './AppStatusResume.vue';
import { receiveStatusResume } from './index';

interface Props {
    pixesCount?: Number;
}

const props = withDefaults(defineProps<Props>(), {
  pixesCount: () => 0,
});

const statusType = 'PIXES', // This can be 'PIXES', 'USERS', or 'MSELAPSED'
iconName = 'Coins';

//let pixesResumeValue = receiveStatusResume(statusType).toString();
let pixesResumeValue = props.pixesCount.toString();

</script>

<template>
    <div class="status-card flex justify-center">
        <AppStatusResume
            :statusType="statusType"
            :iconName="iconName"
            :value="pixesResumeValue"/>
    </div>
</template>