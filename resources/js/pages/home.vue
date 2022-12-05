<script setup>
</script>

<template>
    <div class="mt-32">
        <div class="px-4 sm:px-8 max-w-5xl m-auto">
            <h1 class="text-center font-semibold text-sm">User List</h1>
            <ul class="border border-gray-200 rounded overflow-hidden shadow-md">
                <li v-for="user in users" :key="user.name" class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">                {{ user.name }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "User",
    data() {
        return {
            users: {},
        };
    },
    created() {
        this.getUser();
    },
    methods: {
        getUser(){
            axios.get('api/users', this.formData).then((response) => {
                localStorage.setItem('token', response.data)
                this.users = response.data
            }).catch((errors) => {
                this.errors = errors.response.data.errors
            })
        }
    },
}
</script>

