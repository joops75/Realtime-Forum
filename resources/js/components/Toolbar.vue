<template>
    <v-toolbar color="indigo" dark>
        <router-link to="/">
            <v-toolbar-title class="white--text">RT-Forum</v-toolbar-title>
        </router-link>

        <v-spacer></v-spacer>

        <Notification />

        <div class="hidden-sm-and-down">

            <v-btn flat v-show="show()" @click="showQuestionModal">Ask Question</v-btn>

            <router-link v-for="item in items" :key="item.title" :to="item.to" v-show="item.show">
                <v-btn flat>{{ item.title }}</v-btn>
            </router-link>

        </div>
    </v-toolbar>
</template>

<script>
import Notification from '../components/notification/Notification';

export default {
    components: { Notification },
    data() {
        return {
            items: this.getItems()
        }
    },
    created() {
        this.items = this.getItems();
    },
    methods: {
        getItems() {
            return [
                { title: 'Forum', to: '/forum', show: true },
                { title: 'Category', to: '/category', show: User.isAdmin() },
                { title: 'Signup', to: '/signup', show: !this.show() },
                { title: 'Login', to: '/login', show: !this.show() },
                { title: 'Logout', to: '/logout', show: this.show() }
            ];
        },
        show() {
            return User.loggedIn();
        },
        showQuestionModal() {
            EventBus.$emit('showQuestionModal');
        }
    }
}
</script>