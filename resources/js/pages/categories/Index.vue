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

interface Category {
    id: number,
    name: string,
    description: string,
}

interface Props {
    categories: Category[];
}

// Get props from Inertia
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

const page = usePage<PageProps>()

const handleDelete = (id: number) => {
    if (confirm('Do you want to delete a category?')) {
        router.delete(route('categories.destroy', (id)));
    }
};

</script>

<template>
    <Head title="Categories" />

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
                    <Link :href="route('categories.create')"><Button>Create a Category</Button></Link>
                </div>
                <Table>
                    <TableCaption>A list of your categories.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                ID
                            </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-center w-[100px]">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in props.categories" :key="category.id">
                            <TableCell>{{ category.id }}</TableCell>
                            <TableCell class="font-medium">{{ category.name }}</TableCell>
                            <TableCell>{{ category.description }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Link :href="route('categories.edit', { id: category.id })">
                                    <Button class="bg-slate-600">Edit</Button>
                                </Link>
                                <Button class="bg-red-600" @click="handleDelete(category.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>