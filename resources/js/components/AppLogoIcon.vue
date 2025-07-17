<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
<img src="https://res.cloudinary.com/dv33g6nco/image/upload/w_40/h_42/v1752701788/double_robots_noback_fazaj5.png" alt="App Logo" :class="className" />
</template>
