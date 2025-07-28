<script setup lang="ts">
import { ref, onMounted, onBeforeMount } from "vue";
import { route } from 'ziggy-js';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage, Link} from '@inertiajs/vue3';
import Divider from 'primevue/divider';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';


import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Button from 'primevue/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Meus Pixes',
        href: '/MyPixes'
    },
];

const { getInitials } = useInitials();

const setDeadline = (pix: {created_at: string, deadlineClock: any}, ti: number) =>{
    pix.deadlineClock = setDeadLineClock(getTimeRemaining(deadlineFromCreatedTime(pix.created_at),ti));
}

let pixes = ref([
    {
        name: 'Gean Jesus',
        email: 'geansantos2010@hotmail.com',
        valor: '1200',
        user_origin:'admin@admin.com',
        created_at: '2025-07-21 03:13:00',
        status: 'SEND',
        deadlineClock: '00:00'
    },
    {
        name: 'Gean Jesus',
        email: 'geansantos2010@hotmail.com',
        valor: '4000',
        user_origin:'admin@admin.com',
        created_at: '2025-07-21 03:15:00',
        status: 'SEND',
        deadlineClock: '00:00'
    },
    {
        name: 'Gean Jesus',
        email: 'geansantos2010@hotmail.com',
        valor: '12000',
        user_origin:'admin@admin.com',
        created_at: '2025-07-21 02:18:00',
        status: 'PAID',
        deadlineClock: '00:00'
    },
    {
        name: 'Gean Jesus',
        email: 'geansantos2010@hotmail.com',
        valor: '12000',
        user_origin:'admin@admin.com',
        created_at: '2025-07-20 22:00:00',
        status: 'PAID',
        deadlineClock: '00:00'
    },
]);

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

/* const selectRow = (data: any) => {
    alert(route('MyPixDetail'))
    const page = usePage();
    page.url = 
    //route('MyPixDetail', data);
}; */

const mountPixDetailRoute = (data: any) => {
    return route('MyPixDetail');
    //route('MyPixDetail', data);
};


const deadlineFromCreatedTime = (creationDate: string) =>{
    const dataExpiracao = new Date(new Date(Date.parse(creationDate)).valueOf() + 1 * 1 * 10 * 60 * 1000);
    return dataExpiracao.toString();
}

const setDeadLineClock = (time: {minutes:string, seconds:string}) => {
    return `${('0' + time.minutes).slice(-2)}:${('0' + time.seconds).slice(-2)}`;
}

const getTimeRemaining =(endtime: string, ti: number) => {
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
        console.log('pre ti')
        console.log(ti);
        const onDeadline = pixes.value.filter((pix) =>{
            return pix.status == 'SEND'
        })
    console.log("onDeadline")
    console.log(onDeadline);
        const onMonitoring = onDeadline.filter((pix) =>{
            return Date.parse(deadlineFromCreatedTime(pix.created_at)) > Date.now()
        });
    console.log("onMonitoring")
    console.log(onMonitoring);

        if(!onMonitoring || onMonitoring.length == 0){
            console.log(`clearInterval(${ti});`)
            clearInterval(ti);
        }
        if(onDeadline.length > 0){
        
            onDeadline.forEach(async (pix) => {
            console.log(pix.deadlineClock)
            setDeadline(pix,ti);
            });
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

    <Head title="Meus Pixes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-row items-start gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid h=full gen-pc-container auto-rows-min gap-4 md:grid-cols-3">
                <div class="w-full flex flex-row items-center justify-evenly">
                    <div>
                        <DataTable :value="pixes" tableStyle="min-width: 50rem">
                            <template #empty>
                                <div class="text-center">Ainda não há pixes enviados para você.</div>
                            </template>
                            <template #header>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xl font-bold pl-3">Registros:</span>
                                    <Button icon="pi pi-refresh" rounded raised />
                                </div>
                            </template>
                            <Column header="">
                                <template #body="slotProps">
                                    <Avatar class="h-8 w-8 overflow-hidden rounded-lg mr-2">
                                        <AvatarImage :src="''" :alt="slotProps.data.name" />
                                        <AvatarFallback class="rounded-lg text-black dark:text-white">
                                            {{ getInitials(slotProps.data.name) }}
                                        </AvatarFallback>
                                    </Avatar>
                                </template>
                            </Column>
                            <Column field="name" header="Nome"></Column>
                            <Column field="email" header="E-mail"></Column>
                            <Column header="Valor">
                                <template #body="slotproop">
                                    <span>
                                        {{ formatCurrency(slotproop.data.valor) }}
                                    </span>
                                </template>
                            </Column>
                            <Column header="Prazo/Tempo restante">
                                <template #body="slotproop">
                                    <span :class="setTimeColor(slotproop.data.status)">
                                        {{ slotproop.data.deadlineClock }}
                                    </span>
                                </template>
                            </Column>
                            <Column field="user_origin" header="Gerado por"></Column>
                            <Column header="Gerado em" data-type="created_at">
                                <template #body="data">
                                    {{ formatDate(data.data.created_at) }}
                                </template>
                            </Column>
                            <Column header="Status">
                                <template #body="slotProps">
                                    <Tag :value="slotProps.data.status" :severity="getSeverity(slotProps.data.status)" rounded/>
                                </template>
                            </Column>
                            <Column class="w-24 !text-end" header="Pagar">
                                <template #body="data">
                                    <Link :href="mountPixDetailRoute(data.data)">
                                    <Button icon="pi pi-sign-in" severity="secondary" rounded></Button>
                                    </Link>
                                </template>
                            </Column>
                            <template #footer > 
                                <span class="pl-3">
                                    Total: {{ pixes ? pixes.length : 0 }} registro(s).
                                </span>
                                
                            </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>