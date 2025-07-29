<script setup lang="ts">
import AppStatusResume from './AppStatusResume.vue';
import { receiveStatusResume } from './index';

interface Props {
    timeElapsed?: number;
}

const props = withDefaults(defineProps<Props>(), {
  timeElapsed: () => 0,
});

const statusType = 'MSELAPSED', // This can be 'PIXES', 'USERS', or 'MSELAPSED'
iconName = 'Clock';
//let msResumeValue =  receiveStatusResume(statusType);

let msResumeValue =  props.timeElapsed
//let formattedMsResumeValue = `${msResumeValue / 1000} s`;
let formattedMsResumeValue = `${(msResumeValue.toFixed(3))} s`;


</script>

<template>
    <div class="status-card flex justify-center">
        <AppStatusResume
            :statusType="statusType"
            :iconName="iconName"
            :value="formattedMsResumeValue"/>
    </div>
</template>