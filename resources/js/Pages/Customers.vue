<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                            <div class="bg-green-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="flash.message">
                                <div class="flex">
                                    <div>
                                        <p class="text-sm">{{ flash.message }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-red-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="Object.keys(errors).length">
                                <div class="flex">
                                    <div>
                                        <p v-for="error in errors" :key="error" class="text-sm" v-html="error"></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded my-3">Create New Customer</button>
                            </div>
                            <div class="mb-3">
                                <label class="search-label">Search:</label>
                                <input type="search" v-model="searchKeyword" @keyup="searchCustomers" class="search-input">
                            </div>

                            <table class="table-auto min-w-full leading-normal">
                                <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">First name</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Last name</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone number</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in customersList.data" :key="item.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ item.first_name }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ item.last_name }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ item.email }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ item.phone_number }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <button @click="edit(item)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 mr-1 rounded">Edit</button>
                                        <button @click="deleteRow(item)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <pagination class="mt-6" :links="customersList.links"/>

                        </div>
                    </div>

                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <!-- This element is to trick the browser into centering the modal contents. -->

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">First name:</label>
                                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter first name" v-model="form.first_name">
                                                <div v-if="errors.first_name" class="text-red-500">{{ errors.first_name }}</div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Last name:</label>
                                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" placeholder="Enter last name" v-model="form.last_name">
                                                <div v-if="errors.last_name" class="text-red-500">{{ errors.last_name }}</div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput3" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput3" placeholder="Enter email" v-model="form.email">
                                                <div v-if="errors.email" class="text-red-500">{{ errors.email }}</div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput4" class="block text-gray-700 text-sm font-bold mb-2">Phone number:</label>
                                                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput4" placeholder="Enter phone number" v-model="form.phone_number">
                                                <div v-if="errors.phone_number" class="text-red-500">{{ errors.phone_number }}</div>
                                            </div>
                                            <div class="mb-4" v-if="!editMode">
                                                <label for="exampleFormControlInput5" class="block text-gray-700 text-sm font-bold mb-2">Bulk:</label>
                                                <input type="file" accept="text/csv" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput5" @input="form.bulk = $event.target.files[0]">
                                                <p><a href="/sample_files/sample_customers.csv" class="text-primary-blue" download>Example file</a></p>
                                                <div v-if="errors.bulk" class="text-red-500">{{ errors.bulk }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                          <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">Save</button>
                                        </span>
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                          <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">Update</button>
                                        </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                          <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">Cancel</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Components/Pagination'

export default {
    props: {
        customersList: Object,
        errors: Object,
        flash: Object,
    },
    components: {
        AppLayout,
        Pagination,
    },
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                first_name: null,
                last_name: null,
                email: null,
                phone_number: null,
                bulk: null,
            },
            searchKeyword: '',
            pageErrors: Object,
            flashErrors: Object,
        }
    },
    watch: {
        $page (newData,oldData) {
            this.updatePageErrors()
            this.updateFlashErrors()
        }
    },
    methods: {
        openModal: function () {
            this.isOpen = true;
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode=false;
        },
        reset: function () {
            this.form = {
                first_name: null,
                last_name: null,
                email: null,
                phone_number: null,
                bulk: null,
            }
        },
        save: function (data) {
            this.$inertia.post('/customers', data, { preserveState:false, forceFormData: true })
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            data._method = 'PUT';
            this.$inertia.post('/customers/' + data.id, data, { preserveState:false })
            this.reset();
            this.closeModal();
        },
        deleteRow: function (data) {
            if (!confirm('Are you sure want to remove?')) return;
            data._method = 'DELETE';
            this.$inertia.post('/customers/' + data.id, data, { preserveState:false })
            this.reset();
            this.closeModal();
        },
        updatePageErrors() {
            this.pageErrors = this.$page.props.errors
        },
        updateFlashErrors() {
            this.flashErrors = this.$page.props.flash
        },
        searchCustomers() {
            this.$inertia.get('/customers', { keyword: this.searchKeyword }, { preserveState:false })
        }
    }
}
</script>
<style>
input.search-input {
    display: block;
    padding: 10px 6px;
    width: 100%;
    box-sizing: border-box;
    border: none;
    border-bottom: 1px solid #ddd;
    color: #555;
}
label.search-label {
     color: #aaa;
     display: inline-block;
     margin: 25px 0 15px;
     font-size: 0.6em;
     text-transform: uppercase;
     letter-spacing: 1px;
     font-weight: bold;
 }
</style>
