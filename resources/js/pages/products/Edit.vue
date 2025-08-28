<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, watch } from "vue";

interface Product {
    id: number;
    name: string;
    quantity: number;
    unit_price: number;
    total_price: number;
    description: string;
}

const props = defineProps<{ product: Product }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit a Product',
        href: `/products/${props.product.id}/edit`,
    },
];

const form = useForm({
    name: props.product.name,
    quantity: props.product.quantity,
    unit_price: props.product.unit_price,
    total_price: props.product.total_price,
    description: props.product.description,
});

// auto calculate
const total_price = computed(() => {
    const qty = Number(form.quantity) || 0;
    const unit = Number(form.unit_price) || 0;
    return qty * unit;
});

// sync with form
watch(total_price, (newVal) => {
    form.total_price = newVal;
});

const handleSubmit = () => {
    form.put(route('products.update', { product: props.product.id }));
};
</script>

<template>
    <Head title="Edit a Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <!-- Product Name -->
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input v-model="form.name" type="text" placeholder="Name" />
                    <div class="text-sm text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>

                <!-- Quantity -->
                <div class="space-y-2">
                    <Label for="quantity">Quantity</Label>
                    <Input v-model="form.quantity" type="number" placeholder="Quantity" />
                    <div class="text-sm text-red-600" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>
                </div>

                <!-- Unit Price -->
                <div class="space-y-2">
                    <Label for="unit_price">Unit Price</Label>
                    <Input v-model="form.unit_price" type="number" step="0.01" placeholder="Unit Price" />
                    <div class="text-sm text-red-600" v-if="form.errors.unit_price">{{ form.errors.unit_price }}</div>
                </div>

                <!-- Auto Calculated Total Price -->
                <div class="space-y-2">
                    <Label for="total_price">Total Price</Label>
                    <Input v-model="form.total_price" type="number" step="0.01" placeholder="Total Price" readonly />
                </div>

                <!-- Description -->
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

                <!-- Submit -->
                <Button type="submit" :disabled="form.processing">Update Product</Button>
            </form>
        </div>
    </AppLayout>
</template>
