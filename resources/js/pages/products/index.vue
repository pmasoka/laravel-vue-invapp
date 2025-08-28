<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { ShieldCheck } from 'lucide-vue-next';
import type { PageProps } from '@/types/inertia'
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

interface Product {
    id: number,
    name: string,
    quantity: number,
    unit_price: number,
    total_price: number,
    description: string,
}

interface Props {
    products: Product[];
}

// Get props from Inertia
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

const page = usePage<PageProps>()

const handleDelete = (id: number) => {
    if (confirm('Do you want to delete a product?')) {
        router.delete(route('products.destroy', (id)));
    }
};

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div v-if="page.props.flash?.message" class="mb-4">
                <Alert class="bg-blue-200">
                    <ShieldCheck class="h-4 w-4" />
                    <AlertTitle>Notification!</AlertTitle>
                    <AlertDescription>
                        {{ page.props.flash.message }}
                    </AlertDescription>
                </Alert>
            </div>
            <div>
                <div>

                </div>

                <div>
                    <Link :href="route('products.create')"><Button>Create a Product</Button></Link>
                </div>

                <Table>
                    <TableCaption>A list of your recent products.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                ID
                            </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Catrgory</TableHead>
                            <TableHead>Supplier Name</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Unit Price</TableHead>
                            <TableHead>Total Price</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-center w-[100px]">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>

                        <TableRow v-for="product in props.products" :key="product.id">
                            <TableCell>{{ product.id }}</TableCell>
                            <TableCell class="font-medium">{{ product.name }}</TableCell>
                            <TableCell class="font-medium">catergory</TableCell>
                            <TableCell class="font-medium">supplier name</TableCell>
                            <TableCell class="font-medium">{{ product.quantity }}</TableCell>
                            <TableCell>{{ product.unit_price }}</TableCell>
                            <TableCell>{{ product.total_price }}</TableCell>
                            <TableCell>{{ product.description }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Link :href="route('products.edit', { id: product.id })">
                                <Button class="bg-slate-600">Edit</Button>
                                </Link>
                                <Button class="bg-red-600" @click="handleDelete(product.id)">Delete</Button>
                            </TableCell>
                        </TableRow>

                    </TableBody>
                </Table>

            </div>
        </div>
    </AppLayout>
</template>
