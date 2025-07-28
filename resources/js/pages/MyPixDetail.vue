<script setup lang="ts">
import { ref, onMounted } from "vue";

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

import Tag from 'primevue/tag';
import DataView from 'primevue/dataview';
import VueQrcode from 'vue-qrcode';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Meus Pixes > Pix Detalhe',
        href: '/MyPixDetail.vue',
    },
];

const setDeadline = (pix: {created_at: string, deadlineClock: any}) =>{
    pix.deadlineClock = setDeadLineClock(getTimeRemaining(deadlineFromCreatedTime(pix.created_at)));
}

const pixDetail = ref([{
    id: '68c6ed18-c45c-42d6-a5a5-99a096fd5c8f',
    description: 'Taxa adicional serviço #5230',
    status: 'SEND',
    user_origin:'admin@admin.com',
    deadlineClock: '00:00',
    valor: '12000',
    created_at: '2025-07-24 03:08:00',
    isAnonym: true
}]);

/* const page = usePage();
const user = page.props.auth.user as User; */

const urlQrCode = `http://192.168.0.107:5173/pix/${pixDetail.value[0].id}`;
//`http://192.168.0.107:5173/pix/${user.id}/${pixDetail.value[0].id}`;

const getSeverity = (severityVal: string) => {
    switch (severityVal) {
        case 'SEND':
            return 'info';

        case 'EXPIRED':
            return 'warn';

        case 'ERROR':
            return 'danger';

        case 'CREATED':
            return 'secondary';

        case 'PAID':
            return 'success';

        default:
            return undefined;
    }
};
const setTimeColor = (severityColor: string) =>{
    switch (severityColor) {
        case 'SEND':
            return 'text-red-600';
        case 'EXPIRED':
            return 'text-grey-600';
        case 'ERROR':
            return 'text-grey-600';
        case 'CREATED':
            return 'text-grey-600';
        case 'PAID':
            return 'text-green-600';
        default:
            return 'text-white-600';
    }
}

const formatDate = (value: string) => {
    const dateObject: Date = new Date(value);
    return dateObject.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};


const deadlineFromCreatedTime = (creationDate: string) =>{
    const dataExpiracao = new Date(new Date(Date.parse(creationDate)).valueOf() + 1 * 1 * 10 * 60 * 1000);
    return dataExpiracao.toString();
}

const setDeadLineClock = (time: {minutes:string, seconds:string}) => {
    return `${('0' + time.minutes).slice(-2)}:${('0' + time.seconds).slice(-2)}`;
}

const getTimeRemaining =(endtime: string) => {
  const t = Date.parse(endtime) - Date.parse(new Date().toString());
  let seconds = Math.floor((t / 1000) % 60);
  let minutes = Math.floor((t / 1000 / 60) % 60);
  const hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  const days = Math.floor(t / (1000 * 60 * 60 * 24));

   if (t <= 0) {
    minutes= 0;
    seconds= 0;
    } 

  return {
    total: t,
    days: days,
    hours: hours,
    minutes: minutes.toString(),
    seconds: seconds.toString(),
  };
}

/* const deadlineStatusMonitor = async() =>{
    const onDeadline = pixes.value.filter((pix) =>{
        return pix.status = 'SEND'
    })
    if(onDeadline.length > 0){
        onDeadline.forEach(async (pix) =>{
            let timeinterval = 0;
            timeinterval = setInterval(() => setDeadline(pix,timeinterval), 1000); 
        })
    }
} */

//await deadlineStatusMonitor();

onMounted(() => {
    let ti=0;
    ti=setInterval(() =>{
        const onDeadline = pixDetail.value[0].status == 'SEND';

        const onMonitoring = Date.parse(deadlineFromCreatedTime(pixDetail.value[0].created_at)) > Date.now();

        if(onDeadline && onMonitoring){
            setDeadline(pixDetail.value[0]);

        }else{
            console.log(`onDeadline: ${onDeadline}`)
            console.log(`onMonitoring: ${onMonitoring}`)

            console.log(`clearInterval(${ti});`)
            clearInterval(ti);
        }
    }, 1000);

    console.log('pos ti')
    console.log(ti);
})

const formatCurrency = (value: string) => {
    return Number(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

</script>

<template>

    <Head title="Meu Pix" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-row justify-center items-center gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="pix-detail-content rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div class="grid h=full gen-pc-container auto-rows-min gap-4 md:grid-cols-3">
                    <div class="w-full flex flex-col flex-nowrap items-center content-center justify-start">

                        <div class="flex justify-center align-center w-full aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                            <vue-qrcode :value="urlQrCode" :width="420" type="image/png" :color="{ dark: '#000000', light: '#ffffff' }"></vue-qrcode>
                        </div>
                        <div class="min-w-[80%] mt-[2%]">
                            <DataView :value="pixDetail">
                                <template #list>
                                    <div class="flex flex-col">
                                        <div>
                                            <div class="border-t border-surface-200 dark:border-surface-700">
                                                <div
                                                    class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div
                                                        class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                        <div>
                                                            <div class="text-lg font-bold ml-2">
                                                                <span class="text-xl font-semibold">
                                                                    Descrição:
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col md:items-end gap-8">
                                                        <span class="text-xl font-medium mr-2">{{
                                                            pixDetail[0].description }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="border-t border-surface-200 dark:border-surface-700">
                                                <div
                                                    class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div
                                                        class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                        <div>
                                                            <div class="text-lg font-medium ml-2">
                                                                <span class="text-xl font-semibold">
                                                                    Status:
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col md:items-end gap-8">
                                                        <span class="text-xl font-medium mr-2">
                                                            <Tag :value="pixDetail[0].status"
                                                                :severity="getSeverity(pixDetail[0].status)" rounded />
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="border-t border-surface-200 dark:border-surface-700">
                                                <div
                                                    class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div
                                                        class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                        <div>
                                                            <div class="text-lg font-medium ml-2">
                                                                <span class="text-xl font-semibold">
                                                                    Tempo restante:
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col md:items-end gap-8">
                                                        <span
                                                            :class="`text-xl font-medium mr-2 ${setTimeColor(pixDetail[0].status)}`">{{
                                                            pixDetail[0].deadlineClock }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="border-t border-surface-200 dark:border-surface-700">
                                                <div
                                                    class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div
                                                        class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                        <div>
                                                            <div class="text-lg font-medium ml-2">
                                                                <span class="text-xl font-semibold">
                                                                    Valor:
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col md:items-end gap-8">
                                                        <span class="text-xl font-medium mr-2">{{
                                                            formatCurrency(pixDetail[0].valor) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="border-t border-surface-200 dark:border-surface-700">
                                                <div
                                                    class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div
                                                        class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                        <div>
                                                            <div class="text-lg font-medium ml-2">
                                                                <span class="text-xl font-semibold">
                                                                    Autor:
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col md:items-end gap-8">
                                                        <span class="text-xl font-medium mr-2">{{ pixDetail[0].isAnonym
                                                            ? 'SISTEMA':pixDetail[0].user_origin }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="border-t border-surface-200 dark:border-surface-700">
                                                <div
                                                    class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div
                                                        class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                        <div>
                                                            <div class="text-lg font-medium ml-2">
                                                                <span class="text-xl font-semibold">
                                                                    Criado em:
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col md:items-end gap-8">
                                                        <span class="text-xl font-medium mr-2">{{
                                                            formatDate(pixDetail[0].created_at) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </DataView>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>