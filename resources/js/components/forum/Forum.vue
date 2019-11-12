<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs8>
                <Questions />
            </v-flex>
            <v-flex xs4>
                <AppSidebar />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import Questions from './Questions';
import AppSidebar from './AppSidebar';

export default {
    components: { Questions, AppSidebar }
}
</script>