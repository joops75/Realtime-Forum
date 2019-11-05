<template>
    <v-toolbar>
        <router-link to="/">
            <v-toolbar-title>RT-Forum</v-toolbar-title>
        </router-link>
        <v-spacer></v-spacer>
        <div class="hidden-sm-and-down">

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
                { title: 'Ask Question', to: '/ask', show: User.loggedIn() },
                { title: 'Category', to: '/category', show: User.loggedIn() },
                { title: 'Signup', to: '/signup', show: !User.loggedIn() },
                { title: 'Login', to: '/login', show: !User.loggedIn() },
                { title: 'Logout', to: '/logout', show: User.loggedIn() }
            ];
        }
    }
}
</script>