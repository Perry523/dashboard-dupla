<script setup lang="ts">
import { ref, defineProps } from "vue";

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import MultiSelect from 'primevue/multiselect';
import Divider from 'primevue/divider';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Checkbox from 'primevue/checkbox';
import ModalDialog from "./ModalDialog.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gerar Cobrança Pix',
        href: '/GeneratePixCharge',
    },
];

const props = defineProps({
        usersList: Array // Declare 'categories' as an Array prop
});
const selectedUsers = ref();
const groupedUsers = ref(props.usersList);
const groupedUsersModel = ref([
    {
        name: 'Gean Jesus',
        items: [
            { email: 'geansantos2010@hotmail.com', created_at: '2025-07-16 04:25:05'},
        ]
    }
]);

const { getInitials } = useInitials();
const severityValue = 'CREATED';
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

const emailChecked = ref(false);
const anonymChecked = ref(false);

</script>

<template>

    <Head title="Geração de Pix" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-row items-center gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid h-full gen-pc-container auto-rows-min gap-4 md:grid-cols-3">

                <div
                    class="relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="card pix-select-card">
                        <MultiSelect 
                        v-model="selectedUsers" :options="groupedUsers" optionLabel="email" filter
                            optionGroupLabel="name" optionGroupChildren="items" display="chip"
                            placeholder="Selecione os usuários..." class=" pix-select-card w-full md:w-80">
                            <template #optiongroup="slotProps">
                                <div class="flex pix-select-card items-center">
                                    <Avatar class="h-8 w-8 overflow-hidden rounded-lg mr-2">
                                        <AvatarImage :src="''" :alt="slotProps.option.name" />
                                        <AvatarFallback class="rounded-lg text-black dark:text-white">
                                            {{ getInitials(slotProps.option.name) }}
                                        </AvatarFallback>
                                    </Avatar>
                                    <div>{{ slotProps.option.name }}</div>
                                </div>
                            </template>
                        </MultiSelect>
                    </div>
                </div>
                <div
                    class="pix-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div data-v-9cb1914c=""
                        class="md:col-span-2 p-4 md:p-0 shadow-md rounded-2xl bg-white min-w-[170%]">
                        <div data-v-9cb1914c="" class="flex flex-col justify-center items-center">
                            <h2 data-v-9cb1914c="" class="mt-6 mb-4 text-2xl font-semibold title-decoration"> Gerar QR
                                Code Pix </h2>
                            <div data-v-9cb1914c="" class="w-full md:w-1/2"><label data-v-9cb1914c=""
                                    class="form-control">
                                    <div data-v-9cb1914c="" class="label"><span data-v-9cb1914c=""
                                            class="label-text font-semibold text-gray-800 -mb-1">Tipo da Chave</span>
                                    </div><select data-v-9cb1914c=""
                                        class="select select-sm rounded-md focus:border-2 focus:border-gray-900 border-[0.5px] border-gray-400 focus:outline-none w-full max-w-xs">
                                        <option data-v-9cb1914c="" value="cnpj">CNPJ</option>
                                        <option data-v-9cb1914c="" value="cpf">CPF</option>
                                        <option data-v-9cb1914c="" value="email">Email</option>
                                        <option data-v-9cb1914c="" value="phone">Telefone</option>
                                        <option data-v-9cb1914c="" value="other">Outro</option>
                                    </select>
                                </label><label data-v-9cb1914c="" class="mt-3 form-control">
                                    <div data-v-9cb1914c="" class="label"><span data-v-9cb1914c=""
                                            class="label-text font-semibold text-gray-800 -mb-1">Chave Pix</span></div>
                                    <input data-v-9cb1914c="" type="email" placeholder="Informe o email" maxlength="50"
                                        class="input-sm rounded-md focus:border-2 focus:border-gray-900 border-[0.5px] border-gray-400 focus:outline-none w-full max-w-xs">
                                </label><label data-v-9cb1914c="" class="mt-3 form-control w-full max-w-xs">
                                    <div data-v-9cb1914c="" class="label"><span data-v-9cb1914c=""
                                            class="label-text font-semibold -mb-1 text-start">Identificador</span><span
                                            data-v-9cb1914c="" class="text-xs italic -mb-1">Opcional</span></div><input
                                        data-v-9cb1914c="" type="text" maxlength="20" placeholder="PGTOLOJA123"
                                        class="input-sm rounded-md focus:border-2 focus:border-gray-900 border-[0.5px] border-gray-400 focus:outline-none w-full max-w-xs">
                                </label><label data-v-9cb1914c="" class="mt-3 form-control w-full max-w-xs">
                                    <div data-v-9cb1914c="" class="label"><span data-v-9cb1914c=""
                                            class="label-text font-semibold -mb-1">Valor (R$)</span><span
                                            data-v-9cb1914c="" class="text-xs italic -mb-1">Opcional</span></div><input
                                        data-v-9cb1914c="" type="text" placeholder="0,00"
                                        class="input-sm rounded-md focus:border-2 focus:border-gray-900 border-[0.5px] border-gray-400 focus:outline-none w-full max-w-xs"
                                        inputmode="numeric">
                                </label></div>
                            <div data-v-9cb1914c=""><img data-v-9cb1914c=""
                                    src="data:image/png;base64,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"
                                    alt="qr code pix" class="hidden"></div><button data-v-9cb1914c=""
                                class="mt-6 btn btn-sm text-white bg-teal-600 hover:bg-teal-500 mb-5 text-center p-5"><svg
                                    data-v-e8d572f6="" data-v-9cb1914c="" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                    class="icon text-md" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5.283 18.36a3.5 3.5 0 0 0 2.493-1.032l3.6-3.6a.684.684 0 0 1 .946 0l3.613 3.613a3.5 3.5 0 0 0 2.493 1.032h.71l-4.56 4.56a3.647 3.647 0 0 1-5.156 0L4.85 18.36ZM18.428 5.627a3.5 3.5 0 0 0-2.493 1.032l-3.613 3.614a.67.67 0 0 1-.946 0l-3.6-3.6A3.5 3.5 0 0 0 5.283 5.64h-.434l4.573-4.572a3.646 3.646 0 0 1 5.156 0l4.559 4.559ZM1.068 9.422L3.79 6.699h1.492a2.48 2.48 0 0 1 1.744.722l3.6 3.6a1.73 1.73 0 0 0 2.443 0l3.614-3.613a2.48 2.48 0 0 1 1.744-.723h1.767l2.737 2.737a3.646 3.646 0 0 1 0 5.156l-2.736 2.736h-1.768a2.48 2.48 0 0 1-1.744-.722l-3.613-3.613a1.77 1.77 0 0 0-2.444 0l-3.6 3.6a2.48 2.48 0 0 1-1.744.722H3.791l-2.723-2.723a3.646 3.646 0 0 1 0-5.156">
                                    </path>
                                </svg> Gerar Qr Code Pix </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center flex-col min-w-[15%]">
                    <div
                        class="status-card relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    </div>
                </div>
                <Divider />
                <div class="w-full flex flex-row items-center justify-evenly">
                    <div>
                        <DataTable :value="selectedUsers" tableStyle="min-width: 50rem">
                            <template #empty>
                                <div class="text-center">Selecione um usuário acima.</div>
                            </template>
                            <template #header>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xl font-bold pl-3">Prontos para o envio:</span>
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
                            <Column header="Criado em" data-type="date">
                                <template #body="data">
                                    {{ formatDate(data.data.created_at) }}
                                </template>
                            </Column>
                            <Column header="Status">
                                <template #body="">
                                    <Tag :value="severityValue" :severity="getSeverity(severityValue)" rounded />
                                </template>
                            </Column>
                            <template #footer>
                                <span class="pl-3">
                                    Total: {{ selectedUsers ? selectedUsers.length : 0 }} envio(s).
                                </span>

                            </template>
                        </DataTable>
                    </div>
                    <div>
                        <div class="card flex flex-row justify-between rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 p-2 mb-2"
                            @click="emailChecked = !emailChecked">
                            <Checkbox inputId="sendEmail" v-model="emailChecked" binary />
                            <label class="ml-5" for="sendEmail">Enviar e-mail?</label>
                        </div>
                        <div class="card flex flex-row justify-between rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 p-2 mb-5"
                            @click="anonymChecked = !anonymChecked">
                            <Checkbox inputId="anonymCharge" v-model="anonymChecked" binary />
                            <label class="ml-5" for="anonymCharge">Cobrança anônima?</label>
                        </div>
                        <ModalDialog :usersToSend="selectedUsers" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>