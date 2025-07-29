<script setup lang="ts">
import { ref, toRaw } from "vue";
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { Link,useForm } from '@inertiajs/vue3';
import SuccessScreen from "./SuccessScreen.vue";

export interface userSelected{
    name: string,
    email: string,
    created_at: string
}

export interface PixData{
    pixDescription: string,
    pixValue: number,
}

interface Props {
    usersToSend?: Array<userSelected>,
    pixData?: PixData
}

const props = withDefaults(defineProps<Props>(), {
  usersToSend: () =>[],
  pixData: undefined
});

const visible = ref(false);
const loading = ref(false);

const getEmailsList = (selecteds: Array<userSelected>) => {
const emails: string[] = [];
selecteds.forEach(el => {
    emails.push(el.email);
});
if(emails.length==0) emails.push("");
return emails;
}
const pixDataToSend = toRaw(props.pixData);

const loadCreatePixes = () => {
    loading.value = true;
    const emailList = getEmailsList(toRaw(props.usersToSend));
    const form = useForm({
        usersDestination: emailList,
        pixDataValue: pixDataToSend?.pixValue,
        pixDataDescription: pixDataToSend?.pixDescription,
    });
    form.post(route('pix.store'), {
        onFinish: () => {

            loading.value = false;
            visible.value = true;
        }
    })
};

</script>

<template>
    <div class="card flex justify-center">
        <Button class="p-[24px]" label="Enviar Cobrança" icon="pi pi-check" @click="loadCreatePixes" :loading="loading" />

        <Dialog v-model:visible="visible" pt:root:class="!border-0 !bg-transparent" pt:mask:class="backdrop-blur-sm">
            <template #container="{ closeCallback }">
                <div class="flex flex-col px-8 py-8 gap-6 rounded-2xl" style="background-image: radial-gradient(circle at left top, var(--p-primary-400), var(--p-primary-700))">
                    <SuccessScreen />
                    <div class="flex items-center gap-4">
                        <Link :href="route('MyPixes')"> <Button label="Meus Pixes" text class="!p-4 w-full !text-primary-50 !border !border-white/30 hover:!bg-white/10 min-w-fit"></Button>
                        </Link>
                        <Button label="Continuar Criando" @click="closeCallback" text class="!p-4 w-full !text-primary-50 !border !border-white/30 hover:!bg-white/10"></Button>
                    </div>
                </div>
            </template>
        </Dialog>
    </div>
</template>