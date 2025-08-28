<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Supplier {
    id: number;
    name: string;
    phone: string;
    email: string;
    address: string;
}

const props = defineProps<{ supplier: Supplier }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit a Supplier',
        href: `/suppliers/${props.supplier.id}/edit`,
    },
];

const form = useForm({
    name: props.supplier.name,
    phone: props.supplier.phone,
    email: props.supplier.email,
    address: props.supplier.address,
});

const handleSubmit = () => {
    form.put(route('suppliers.update', { supplier: props.supplier.id }));
};
</script>

<template>
    <Head title="Edit a Supplier" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input v-model="form.name" type="text" placeholder="Name" />
                    <div class="text-sm text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="phone">Phone</Label>
                    <Input v-model="form.phone" type="tel" placeholder="Phone" />
                    <div class="text-sm text-red-600" v-if="form.errors.phone">{{ form.errors.phone }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="email">Email</Label>
                    <Input v-model="form.email" type="email" placeholder="Email" />
                    <div class="text-sm text-red-600" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="address">Address</Label>
                    <textarea
                        id="address"
                        v-model="form.address"
                        placeholder="Address"
                        class="w-full rounded-md border border-gray-300 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4"
                    ></textarea>
                    <div class="text-sm text-red-600" v-if="form.errors.address">
                        {{ form.errors.address }}
                    </div>
                </div>

                <Button type="submit" :disabled="form.processing">Update Supplier</Button>
            </form>
        </div>
    </AppLayout>
</template>