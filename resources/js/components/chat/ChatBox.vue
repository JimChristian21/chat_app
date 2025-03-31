<script setup lang="ts">
import Input from '../ui/input/Input.vue';
import Button from '../ui/button/Button.vue';
import { router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    receiver: {
        type: [null, Object]
    },
    messages: {
        type: [null, Object]
    }
});

const page = usePage();
const message = ref('');
const submit = () => {
    router.visit(route('chat.store', props.receiver.id), {
        method: 'post',
        data: {
            message: message.value
        },
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => message.value = ''
    });
}

onMounted(() => {
    Echo.private('chat.' + props.receiver.id + '_' + page.props.auth.user.id)
        .listen('ChatUserBroadcast', (e) => {
            console.log(e);
        });
})

</script>

<template>
    <div class="bg-slate-300 w-4/5 h-full flex flex-col">
        <div v-if="props.receiver">
            <div class="font-bold pl-5 border border-bottom-2">
                {{ props.receiver.name }} ({{ props.receiver.email }})
            </div>
            <div class="h-full flex flex-col">
                <template v-for="message in props.messages" :key="message.id">
                    <div :class="[message.sender_id == $page.props.auth.user.id ? 'text-end' : 'text-start']">
                        {{ message.message }}
                    </div>
                </template>
            </div>
            <div class="flex gap-1 p-2">
                <Input v-model="message"/>
                <Button class="bg-slate-500" @click="submit()">Send</Button>
            </div>
        </div>
        <div v-else class="mx-auto my-auto">
            Select someone to chat!
        </div>
    </div>
</template>