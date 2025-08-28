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

interface Supplier {
    id: number,
    name: string,
    phone: string,
    email: string,
    address: string,
}

interface Props {
    suppliers: Supplier[];
}

// Get props from Inertia
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Suppliers',
        href: '/suppliers',
    },
];

const page = usePage<PageProps>()

const handleDelete = (id: number) => {
    if (confirm('Do you want to delete this supplier?')) {
        router.delete(route('suppliers.destroy', (id)));
    }
};

</script>

<template>

    <Head title="Suppliers" />

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
                    <Link :href="route('suppliers.create')"><Button>Create a Supplier</Button></Link>
                </div>

                <Table>
                    <TableCaption>A list of your recent suppliers.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                ID
                            </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Phone</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Address</TableHead>
                            <TableHead class="text-center w-[100px]">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="supplier in props.suppliers" :key="supplier.id">
                            <TableCell>{{ supplier.id }}</TableCell>
                            <TableCell class="font-medium">{{ supplier.name }}</TableCell>
                            <TableCell class="font-medium">{{ supplier.phone }}</TableCell>
                            <TableCell class="font-medium">{{ supplier.email }}</TableCell>
                            <TableCell class="font-medium">{{ supplier.address }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Link :href="route('suppliers.edit', { supplier: supplier.id })">
                                <Button class="bg-slate-600">Edit</Button>
                                </Link>
                                <Button class="bg-red-600" @click="handleDelete(supplier.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

            </div>
        </div>
    </AppLayout>
</template>