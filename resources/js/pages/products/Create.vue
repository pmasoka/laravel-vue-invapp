<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import {
    Select, SelectContent, SelectItem, SelectTrigger, SelectValue,
} from '@/components/ui/select/';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, watch } from "vue";

// Destructure the props for categories and suppliers
const { categories, suppliers } = defineProps<{
    categories: { id: number; name: string }[];
    suppliers: { id: number; name: string }[]; // Add suppliers prop
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Create a Product', href: '/products/create' },
];

const form = useForm({
    name: '',
    quantity: '',
    unit_price: '',
    total_price: '',
    description: '',
    category_id: '',
    supplier_id: '', // Add the new supplier_id field to the form
});

interface Category {
    id: number,
    name: string,
}

// Add an interface for Supplier
interface Supplier {
    id: number,
    name: string,
}

const total_price = computed(() => {
    const qty = Number(form.quantity) || 0;
    const unit = Number(form.unit_price) || 0;
    return qty * unit;
});

watch(total_price, (v) => {
    form.total_price = String(v);
});

const handleSubmit = () => {
    form.transform((data) => ({
        ...data,
        quantity: Number(form.quantity),
        unit_price: Number(form.unit_price),
        total_price: Number(form.total_price),
        category_id: Number(form.category_id),
        supplier_id: Number(form.supplier_id), // Transform supplier_id to a number
    })).post(route('products.store'));
};

</script>

<template>

    <Head title="Create a Product" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="form.name" type="text" placeholder="Name" />
                    <div class="text-sm text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>

                <div class="space-y-2">
                    <Label>Category</Label>
                    <Select v-model="form.category_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select a category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="category in categories" :key="category.id" :value="String(category.id)">
                                {{ category.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <div class="text-sm text-red-600" v-if="form.errors.category_id">{{ form.errors.category_id }}</div>
                </div>

                <div class="space-y-2">
                    <Label>Supplier</Label>
                    <Select v-model="form.supplier_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select a supplier" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="supplier in suppliers" :key="supplier.id" :value="String(supplier.id)">
                                {{ supplier.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <div class="text-sm text-red-600" v-if="form.errors.supplier_id">{{ form.errors.supplier_id }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="quantity">Quantity</Label>
                    <Input id="quantity" v-model="form.quantity" type="number" placeholder="Quantity" />
                    <div class="text-sm text-red-600" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="unit_price">Unit Price</Label>
                    <Input id="unit_price" v-model="form.unit_price" type="number" placeholder="Unit Price" />
                    <div class="text-sm text-red-600" v-if="form.errors.unit_price">{{ form.errors.unit_price }}</div>
                </div>

                <div class="space-y-2">
                    <Label>Total Price</Label>
                    <p class="font-semibold">{{ total_price }}</p>
                </div>

                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <textarea id="description" v-model="form.description" placeholder="Description"
                        class="w-full rounded-md border border-gray-300 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4" />
                    <div class="text-sm text-red-600" v-if="form.errors.description">{{ form.errors.description }}</div>
                </div>

                <Button type="submit" :disabled="form.processing">Add a Product</Button>
            </form>
        </div>
    </AppLayout>
</template>
