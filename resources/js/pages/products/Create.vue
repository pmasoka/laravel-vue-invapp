<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from "vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create a Product',
        href: '/products/create',
    },
];

const form = useForm({
    name: '',
    quantity: '',
    unit_price: '',
    total_price: '',
    description: '',
});

// auto calculate
const total_price = computed(() => {
    const qty = Number(form.quantity) || 0;
    const unit = Number(form.unit_price) || 0;
    return qty * unit;
});

// sync with form
watch(total_price, (newVal) => {
    form.total_price = String(newVal);
});


const handleSubmit = () => {
    form.post(route('products.store'));
};
</script>

<template>

    <Head title="Create a Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="Product name">Name</Label>
                    <Input v-model="form.name" type="text" placeholder="Name" />
                    <div class="text-sm text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>
                <div class="space-y-2">
                    <Label for="Product price">Quantity</Label>
                    <Input v-model="form.quantity" type="number" placeholder="Quantity" />
                    <div class="text-sm text-red-600" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>
                </div>
                <div class="space-y-2">
                    <Label for="Product price">Unit Price</Label>
                    <Input v-model="form.unit_price" type="number" placeholder="Unit Price" />
                    <div class="text-sm text-red-600" v-if="form.errors.unit_price">{{ form.errors.unit_price }}</div>
                </div>
                <div class="space-y-2">
                    <Label>Total Price</Label>
                    <p class="font-semibold">{{ total_price }}</p>
                    <!-- Or use readonly input -->
                    <!-- <Input v-model="form.total_price" type="number" readonly /> -->
                </div>
                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <textarea id="description" v-model="form.description" placeholder="Description"
                        class="w-full rounded-md border border-gray-300 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4"></textarea>
                    <div class="text-sm text-red-600" v-if="form.errors.description">
                        {{ form.errors.description }}
                    </div>
                </div>
                <Button type="submit" :disabled="form.processing">Add a Product</Button>
            </form>
        </div>
    </AppLayout>
</template>
