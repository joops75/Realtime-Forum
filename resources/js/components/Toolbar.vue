<template>
    <v-toolbar>
        <router-link to="/">
            <v-toolbar-title>RT-Forum</v-toolbar-title>
        </router-link>
        <v-spacer></v-spacer>
        <div class="hidden-sm-and-down">
            <v-btn flat>Forum</v-btn>
            <v-btn flat>Ask Question</v-btn>
            <v-btn flat>Category</v-btn>
            <router-link to="/login">
                <v-btn flat>Login</v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>