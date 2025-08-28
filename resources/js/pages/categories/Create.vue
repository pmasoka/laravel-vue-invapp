<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create a Category',
        href: '/categories/create',
    },
];

const form = useForm({
    name: '',
    description: '',
});

const handleSubmit = () => {
    form.post(route('categories.store'));
};
</script>

<template>
    <Head title="Create a Category" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input v-model="form.name" type="text" placeholder="Name" />
                    <div class="text-sm text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        placeholder="Description"
                        class="w-full rounded-md border border-gray-300 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4"
                    ></textarea>
                    <div class="text-sm text-red-600" v-if="form.errors.description">
                        {{ form.errors.description }}
                    </div>
                </div>

                <Button type="submit" :disabled="form.processing">Create Category</Button>
            </form>
        </div>
    </AppLayout>
</template>