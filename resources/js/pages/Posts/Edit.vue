<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Posts',
        href: '/edit/posts',
    },
];

const props = defineProps({
    editPost: Object,
    id: String, // <- encrypted ID
});

const form = useForm({
    title: props.editPost.title,
    body: props.editPost.body,
});

function submit() {
    // form.post(route('update.posts', props.editPost.id), {
    form.post(route('update.posts', props.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>

    <Head title="Edit Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div>
                <Link href="/show/posts" class="px-3 py-2 text-xs font-medium text-center text-white
                bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4
                focus:outline-none focus:ring-purple-300 dark:bg-purple-600
                dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                Back</Link>
            </div>

            <form @submit.prevent="submit">

                <div class="grid gap-2">
                    <Label for="title"> Title </Label>
                    <Input id="title" type="text" class="mt-1 block w-full" v-model="form.title" placeholder="Title"
                        required />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div class="grid gap-2 mt-3">
                    <Label for="body"> Body </Label>
                    <textarea id="body" type="text"
                        class="mt-1 block w-full flex h-15 file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                        v-model="form.body" placeholder="Body" required>
                    </textarea>
                    <InputError class="mt-2" :message="form.errors.body" />
                </div>

                <div class="flex items-center gap-4 mt-3">
                    <!-- <Button :disabled="form.processing">Update</Button> -->
                    <Button>Update</Button>
                </div>

            </form>

        </div>
    </AppLayout>
</template>
