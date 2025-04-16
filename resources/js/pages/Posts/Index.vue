<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { Plus } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/show/posts',
    },
];

const props = defineProps({
    allPosts: Array
});

function deletePost(encrypted_id: string) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/delete/posts/${encrypted_id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire(
                        'Deleted!',
                        'Post has been deleted.',
                        'success'
                    );
                },
                onError: () => {
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>

<template>

    <Head title="Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div>
                <Link href="/create/posts" type="button" class="inline-flex px-3 py-2 text-xs font-medium text-center text-white
                bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4
                focus:outline-none focus:ring-purple-300 dark:bg-purple-600
                dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                <Plus class="w-4 h-4" /> Create Post </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Body
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="allPosts.length === 0">
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No Data Available
                            </td>
                        </tr>

                        <tr v-for="data in allPosts" :key="data.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ data.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ data.title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ data.body }}
                            </td>
                            <td class="px-6 py-4">
                                <!-- <Link :href="`/edit/posts/${data.id}`" -->
                                <Link :href="`/edit/posts/${data.encrypted_id}`"
                                    class="px-3 py-2 text-xs font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                Edit</Link>
                                <button @click="deletePost(data.encrypted_id)"
                                    class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    Delete</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>



        </div>
    </AppLayout>
</template>
