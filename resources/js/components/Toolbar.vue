<template>
    <v-toolbar>
        <router-link to="/">
            <v-toolbar-title>RT-Forum</v-toolbar-title>
        </router-link>
        <v-spacer></v-spacer>
        <div class="hidden-sm-and-down">

            <v-btn flat v-show="show()" @click="showDialog">Ask Question</v-btn>

            <router-link v-for="item in items" :key="item.title" :to="item.to" v-show="item.show">
                <v-btn flat>{{ item.title }}</v-btn>
            </router-link>

        </div>
    </v-toolbar>
</template>

<script>
export default {
    data() {
        return {
            items: this.getItems()
        }
    },
    created() {
        EventBus.$on(['logout', 'login'], () => {
            this.items = this.getItems();
        });
    },
    methods: {
        getItems() {
            return [
                { title: 'Forum', to: '/forum', show: true },
                { title: 'Category', to: '/category', show: this.show() },
                { title: 'Signup', to: '/signup', show: !this.show() },
                { title: 'Login', to: '/login', show: !this.show() },
                { title: 'Logout', to: '/logout', show: this.show() }
            ];
        },
        show() {
            return User.loggedIn();
        },
        showDialog() {
            EventBus.$emit('showCreateEditModal');
        }
    }
}
</script>